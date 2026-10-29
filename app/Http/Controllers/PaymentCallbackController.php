<?php

namespace App\Http\Controllers;

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

            return response()->json([
                'success' => true,
                'message' => 'Payment callback stored successfully.',
                'data' => [
                    'callback_id' => $callback->id,
                    'order_number' => $orderNumber,
                    'transaction_id' => $transactionId,
                    'transaction_status' => $transactionStatus,
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
