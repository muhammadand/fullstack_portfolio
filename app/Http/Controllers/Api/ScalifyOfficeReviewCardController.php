<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\GoogleCardOrder;
use App\Services\QrisPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

/**
 * API khusus Scalify Office (mesin prospek WhatsApp) untuk menjual Google Review Card secara otomatis:
 *   1. POST   /api/scalify-office/review-card-orders                 → buat order pending + QRIS dinamis (statis → dinamis)
 *   2. POST   /api/scalify-office/review-card-orders/{orderId}/confirm → admin sudah cek uang masuk → lunas → kartu dibuat & AKTIF
 *   3. GET    /api/scalify-office/review-card-orders/{orderId}        → status order (+ kartu bila sudah lunas)
 *
 * Dijaga header "Authorization: Bearer <SCALIFY_OFFICE_TOKEN>" (min. 32 karakter, di .env). Token kosong → 404.
 * Kartu baru dibuat saat konfirmasi (markAsPaid → createOrActivateReviewCard), jadi tidak ada kartu aktif sebelum bayar.
 */
class ScalifyOfficeReviewCardController extends Controller
{
    private const PRICE = 20000;

    private function guard(Request $request): ?JsonResponse
    {
        $token = trim((string) config('services.scalify_office.token'));
        if (strlen($token) < 32) {
            return response()->json(['error' => 'api_nonaktif', 'message' => 'SCALIFY_OFFICE_TOKEN belum diisi (min. 32 karakter).'], 404);
        }
        if (! hash_equals($token, (string) $request->bearerToken())) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        return null;
    }

    public function store(Request $request): JsonResponse
    {
        if ($denied = $this->guard($request)) {
            return $denied;
        }
        $v = $request->validate([
            'business_name' => 'required|string|max:150',
            'customer_name' => 'nullable|string|max:100',
            'phone' => 'required|string|max:30',
            'google_maps_url' => 'nullable|string|max:500',
        ]);

        $orderId = 'GRC-'.date('ymd').'-'.strtoupper(Str::random(4));
        $name = trim($v['customer_name'] ?? '') ?: $v['business_name'];

        try {
            [$customer] = Customer::findOrCreateByPhone($v['phone'], Customer::SOURCE_GOOGLE_CARD, $name);

            $order = GoogleCardOrder::create([
                'order_id' => $orderId,
                'customer_id' => $customer->id,
                'business_name' => $v['business_name'],
                'customer_name' => $name,
                'phone' => $v['phone'],
                'google_maps_url' => $v['google_maps_url'] ?? null,
                'design_type' => 'File digital (PNG + PDF)',
                'theme' => 'Classic White',
                'amount' => self::PRICE,
                'payment_method' => 'qris_dynamic',
                'payment_status' => GoogleCardOrder::STATUS_PENDING,
            ]);

            $qris = QrisPaymentService::createDynamicQris($orderId, self::PRICE, ['name' => $name, 'phone' => $v['phone']]);
            if (empty($qris['success'])) {
                $order->update(['payment_status' => GoogleCardOrder::STATUS_FAILED, 'raw_response' => $qris]);

                return response()->json(['success' => false, 'message' => $qris['message'] ?? 'Gagal membuat QRIS dinamis'], 422);
            }
            $d = $qris['data'];
            $order->update([
                'qris_payload' => $d['qris_payload'] ?? null,
                'transaction_id' => $d['id'] ?? null,
                'expires_at' => $d['expires_at'] ?? now()->addMinutes(30),
                'raw_response' => $d,
            ]);

            return response()->json(['success' => true, 'data' => [
                'order_id' => $order->order_id,
                'business_name' => $order->business_name,
                'amount' => self::PRICE,
                'unique_code' => $d['unique_code'] ?? 0,
                'total_amount' => $d['total_amount'] ?? self::PRICE,
                'merchant_name' => $d['merchant_name'] ?? 'Scalify',
                'qris_payload' => $d['qris_payload'] ?? '',
                'expires_at' => $d['expires_at'] ?? now()->addMinutes(30)->toIso8601String(),
            ]]);
        } catch (Throwable $e) {
            Log::error('ScalifyOffice review card order gagal: '.$e->getMessage());

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat membuat order'], 500);
        }
    }

    public function confirm(Request $request, string $orderId): JsonResponse
    {
        if ($denied = $this->guard($request)) {
            return $denied;
        }
        $order = GoogleCardOrder::where('order_id', $orderId)->first();
        if (! $order) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
        }
        try {
            // Idempoten: order yang sudah lunas mengembalikan kartu yang sama
            $card = $order->payment_status === GoogleCardOrder::STATUS_PAID
                ? $order->createOrActivateReviewCard()
                : $order->markAsPaid(null, ['confirmed_by' => 'scalify-office', 'confirmed_at' => now()->toIso8601String()]);

            return response()->json(['success' => true, 'data' => ['order_id' => $order->order_id, 'card' => $this->card($card)]]);
        } catch (Throwable $e) {
            Log::error("ScalifyOffice konfirmasi {$orderId} gagal: ".$e->getMessage());

            return response()->json(['success' => false, 'message' => 'Gagal mengonfirmasi order'], 500);
        }
    }

    public function show(Request $request, string $orderId): JsonResponse
    {
        if ($denied = $this->guard($request)) {
            return $denied;
        }
        $order = GoogleCardOrder::where('order_id', $orderId)->first();
        if (! $order) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => [
            'order_id' => $order->order_id,
            'payment_status' => $order->payment_status,
            'paid_at' => optional($order->paid_at)->toIso8601String(),
            'card' => $order->reviewCard ? $this->card($order->reviewCard) : null,
        ]]);
    }

    private function card($card): array
    {
        return [
            'serial_number' => $card->serial_number,
            'slug' => $card->slug,
            'activation_code' => $card->activation_code,
            'business_name' => $card->business_name,
            'google_review_url' => $card->google_review_url,
            'scan_url' => url('/r/'.$card->slug),
            'status' => $card->status,
        ];
    }
}
