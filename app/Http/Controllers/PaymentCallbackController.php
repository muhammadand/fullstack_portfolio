<?php

namespace App\Http\Controllers;

use App\Models\GoogleCardOrder;
use App\Models\PaymentCallback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    /**
     * Handle incoming webhook notification from Midtrans or other payment gateways.
     * Hanya mencatat dan menyimpan seluruh respons mentah ke tabel payment_callbacks.
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $payload = $request->all();

        Log::info('Payment Webhook Received', [
            'payload' => $payload,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            // Ekstraksi parameter utama (mendukung Midtrans maupun gateway umum)
            $orderNumber = $request->input('order_id', $request->input('order_number'));
            $transactionId = $request->input('transaction_id', $request->input('id'));
            $transactionStatus = $request->input('transaction_status', $request->input('status'));
            $statusCode = $request->input('status_code');
            $grossAmount = $request->input('gross_amount');
            $signatureKey = $request->input('signature_key');

            if (empty($orderNumber)) {
                Log::warning('Payment Webhook rejected: missing order_number or order_id', ['payload' => $payload]);
                return response()->json([
                    'success' => false,
                    'message' => 'Order identifier is missing.',
                ], 422);
            }

            // Opsional verifikasi signature Midtrans SHA-512 jika MIDTRANS_SERVER_KEY diset
            $serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
            if (!empty($serverKey) && !empty($signatureKey) && !empty($statusCode) && !empty($grossAmount)) {
                $expectedSignature = hash('sha512', $orderNumber . $statusCode . $grossAmount . $serverKey);
                if (!hash_equals($expectedSignature, $signatureKey)) {
                    Log::warning("Payment Webhook: Invalid signature for Order #{$orderNumber}");
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid signature key.',
                    ], 403);
                }
            }

            // Simpan seluruh data callback ke database
            $callback = PaymentCallback::create([
                'order_number' => (string) $orderNumber,
                'transaction_id' => $transactionId ? (string) $transactionId : null,
                'transaction_status' => $transactionStatus ? (string) $transactionStatus : null,
                'raw_response' => $payload,
            ]);

            // Sinkronisasi status Google Review Card Order jika order_number cocok (bisa order_id internal, midtrans_order_id, atau transaction_id)
            $cardOrder = GoogleCardOrder::where('order_id', $orderNumber)
                ->orWhere(function ($q) use ($orderNumber, $transactionId) {
                    if (!empty($transactionId)) {
                        $q->where('transaction_id', $transactionId);
                    }
                    if (!empty($orderNumber)) {
                        $q->orWhere('raw_response->midtrans_order_id', $orderNumber)
                          ->orWhere('raw_response->payment_details->order_id', $orderNumber);
                    }
                })
                ->first();
            $createdCard = null;
            if ($cardOrder && in_array(strtolower((string) $transactionStatus), ['settlement', 'capture', 'success', 'paid'])) {
                $createdCard = $cardOrder->markAsPaid($transactionId, $payload);
                Log::info("GoogleCardOrder #{$orderNumber} paid! Created & activated ReviewCard: {$createdCard->serial_number} with Google Review URL: {$createdCard->google_review_url}");
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment callback stored successfully.',
                'data' => [
                    'callback_id' => $callback->id,
                    'order_number' => $orderNumber,
                    'transaction_id' => $transactionId,
                    'transaction_status' => $transactionStatus,
                    'order_updated' => (bool) $cardOrder,
                    'review_card' => $createdCard ? [
                        'id' => $createdCard->id,
                        'serial_number' => $createdCard->serial_number,
                        'slug' => $createdCard->slug,
                        'scan_url' => $createdCard->scan_url,
                        'google_review_url' => $createdCard->google_review_url,
                    ] : null,
                ],
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Payment Webhook Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'payload' => $payload,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error while processing webhook: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Alias method for webhook handler.
     */
    public function webhook(Request $request): JsonResponse
    {
        return $this->handleWebhook($request);
    }
}
