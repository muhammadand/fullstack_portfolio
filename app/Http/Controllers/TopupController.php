<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ScalifyPayService;
use App\Services\TopupCatalogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TopupController extends Controller
{
    private const PAY_MINUTES = 30;

    public function index()
    {
        return view('topup.index', ['catalog' => TopupCatalogService::games()]);
    }

    public function show(string $slug)
    {
        $game = TopupCatalogService::game($slug);

        abort_if($game === null, 404);

        return view('topup.show', $game);
    }

    /**
     * Buat pesanan + tagihan QRIS (GoPay). Dipanggil saat pelanggan menekan "Bayar" di modal pembayaran.
     * Harga selalu dihitung ulang di server dari katalog, nilai dari browser tidak dipercaya.
     * Pelanggan login: pesanan tersimpan di riwayat (belum bayar sampai lunas). Tamu: tidak punya riwayat,
     * baris order hanya dipakai untuk menerima webhook pembayaran dan dihapus bila tagihan gagal dibuat.
     */
    public function checkout(Request $request, string $slug): JsonResponse
    {
        $game = TopupCatalogService::game($slug);

        abort_if($game === null, 404);

        $fields = $game['form']['fields'];
        $products = collect($game['products'])->keyBy('id');

        $rules = [
            'product_id' => ['required', 'integer'],
            'email'      => ['nullable', 'email:rfc', 'max:255'],
            'note'       => ['nullable', 'string', 'max:200'],
        ];
        $labels = ['product_id' => 'nominal', 'email' => 'email'];

        foreach ($fields as $f) {
            $rules['account.' . $f['key']] = ['required', 'string', 'regex:/' . str_replace('/', '\\/', $f['pattern']) . '/'];
            $labels['account.' . $f['key']] = $f['label'];
        }

        $data = $request->validate($rules, [], $labels);

        $item = $products->get((int) $data['product_id']);

        if (!$item || !$item['available']) {
            throw ValidationException::withMessages([
                'product_id' => 'Nominal tidak tersedia, silakan pilih yang lain.',
            ]);
        }

        $product = \App\Models\DigitalProduct::sellable()->findOrFail($item['id']);

        $account = collect($fields)->mapWithKeys(fn ($f) => [$f['key'] => trim($data['account'][$f['key']])])->all();
        $customer = Auth::guard('customer')->user();

        $order = Order::create([
            'order_no'           => Order::generateOrderNo(),
            'source'             => Order::SOURCE_TOPUP_GAME,
            'customer_id'        => $customer?->id,
            'digital_product_id' => $product->id,
            // Digiflazz menerima semua ID akun sebagai satu string (mis. User ID + Zone ID digabung).
            'customer_no'        => $account ? implode('', $account) : '-',
            'email'              => filled($data['email'] ?? null) ? mb_strtolower(trim($data['email'])) : null,
            'account_data'       => $account ?: null,
            'product_name'       => $product->name,
            'sku_code'           => $product->sku_code,
            'cost_price'         => $product->cost_price,
            'price'              => $item['price'],
            'admin_fee'          => 0,
            'total_amount'       => $item['price'],
            'status'             => Order::STATUS_PENDING,
            'payment_status'     => Order::PAYMENT_UNPAID,
            'notes'              => filled($data['note'] ?? null) ? trim($data['note']) : null,
        ]);

        $charge = ScalifyPayService::chargeQris(
            $order->order_no,
            $order->total_amount,
            ['name' => $customer?->name ?? 'Pelanggan Top Up', 'email' => $order->email],
            [[
                'id'       => $product->sku_code ?: ('P' . $product->id),
                'name'     => mb_substr($product->name, 0, 50),
                'price'    => (int) round($order->total_amount),
                'quantity' => 1,
            ]],
            'gopay',
            self::PAY_MINUTES
        );

        if (empty($charge['success']) || empty($charge['data']['qr_image_url'])) {
            // Tamu: buang baris order. Pelanggan login: simpan sebagai gagal agar riwayat jujur.
            $customer ? $order->markAsFailed() : $order->forceDelete();

            return response()->json([
                'message' => $charge['message'] ?? 'Gagal membuat tagihan QRIS, silakan coba lagi.',
            ], 422);
        }

        $order->update([
            'payment_method'    => 'qris',
            'payment_reference' => $charge['data']['transaction_id'] ?? null,
            'qris_image_url'    => $charge['data']['qr_image_url'],
            'expires_at'        => now()->addMinutes(self::PAY_MINUTES),
        ]);

        return response()->json([
            'order_no'   => $order->order_no,
            'total'      => (float) $order->total_amount,
            'email'      => $order->email,
            'qr_url'     => $order->qris_image_url,
            'expires_at' => $order->expires_at->toIso8601String(),
        ], 201);
    }

    /** Polling status pembayaran dari modal QRIS. Hanya mengembalikan data minimal. */
    public function status(string $orderNo): JsonResponse
    {
        $order = Order::where('order_no', $orderNo)->firstOrFail();

        if ($order->isExpired()) {
            $order->markAsExpired();
        }

        return response()->json([
            'order_no'       => $order->order_no,
            'payment_status' => $order->payment_status,
            'is_paid'        => $order->isPaid(),
            'is_expired'     => $order->payment_status === Order::PAYMENT_EXPIRED,
            'is_failed'      => $order->payment_status === Order::PAYMENT_FAILED,
            'product_name'   => $order->product_name,
            'total'          => (float) $order->total_amount,
            'email'          => $order->email ? preg_replace('/(?<=.).(?=[^@]*@)/', '*', $order->email) : null,
        ]);
    }
}
