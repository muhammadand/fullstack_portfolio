<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QrisPaymentService
{
    /**
     * Default Fallback API Key provided for Scalify Pay
     */
    protected const DEFAULT_API_KEY = 'pk_live_demo1234_sk_live_demo_store_secret_99887766';
    protected const DEFAULT_URL = 'http://pay.scalifyintellegence.my.id/api/v1/qris/dynamic';

    /**
     * Request dynamic QRIS payload from third-party payment gateway.
     *
     * @param string $orderId Unique order identifier
     * @param int|float $amount Nominal amount in IDR
     * @param array $customer Optional customer details ['name' => ..., 'email' => ..., 'phone' => ...]
     * @param string $provider Payment provider, defaults to DANA
     * @return array
     */
    public static function createDynamicQris(
        string $orderId,
        $amount,
        array $customer = [],
        string $provider = 'DANA'
    ): array {
        $url = config('services.qris.url', env('SCALIFY_QRIS_URL', self::DEFAULT_URL));
        $apiKey = config('services.qris.api_key', env('SCALIFY_QRIS_API_KEY', self::DEFAULT_API_KEY));

        if (empty($apiKey)) {
            $apiKey = self::DEFAULT_API_KEY;
        }

        $payload = [
            'order_id' => $orderId,
            'amount' => (int) round($amount),
            'provider' => $provider,
            'customer' => [
                'name' => $customer['name'] ?? null,
                'email' => $customer['email'] ?? null,
                'phone' => $customer['phone'] ?? null,
            ],
        ];

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'X-API-Key' => $apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($url, $payload);

            if ($response->successful()) {
                $body = $response->json();
                $data = $body['data'] ?? $body;

                return [
                    'success' => true,
                    'message' => $body['message'] ?? 'QRIS Dinamis berhasil dibuat.',
                    'data' => [
                        'id' => $data['id'] ?? null,
                        'order_id' => $data['order_id'] ?? $orderId,
                        'merchant_name' => $data['merchant_name'] ?? 'Scalify',
                        'provider' => $data['provider'] ?? $provider,
                        'base_amount' => (int) ($data['base_amount'] ?? $amount),
                        'unique_code' => (int) ($data['unique_code'] ?? 0),
                        'total_amount' => (int) ($data['total_amount'] ?? $amount),
                        'currency' => $data['currency'] ?? 'IDR',
                        'status' => $data['status'] ?? 'pending',
                        'qris_payload' => $data['qris_payload'] ?? '',
                        'expires_at' => $data['expires_at'] ?? now()->addMinutes(30)->toIso8601String(),
                    ],
                ];
            }

            Log::warning('QrisPaymentService error [' . $response->status() . ']: ' . $response->body());

            return [
                'success' => false,
                'message' => 'Gagal membuat QRIS: ' . ($response->json('message') ?? 'HTTP Error ' . $response->status()),
                'raw' => $response->json() ?? $response->body(),
            ];
        } catch (\Throwable $e) {
            Log::error('QrisPaymentService exception: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Terjadi gangguan koneksi ke server QRIS: ' . $e->getMessage(),
            ];
        }
    }
}
