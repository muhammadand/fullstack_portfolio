<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScalifyPayService
{
    public const MODE_SANDBOX = 'sandbox';
    public const MODE_PRODUCTION = 'production';
    public const MODE_SETTING_KEY = 'scalify_pay.mode';

    /** Mode aktif: pilihan admin (app_settings) -> SCALIFY_PAY_MODE -> otomatis dari key yang tersedia. */
    public static function mode(): string
    {
        $mode = \App\Models\AppSetting::get(self::MODE_SETTING_KEY) ?: config('services.scalify_pay.mode');

        if (!in_array($mode, [self::MODE_SANDBOX, self::MODE_PRODUCTION], true)) {
            $mode = self::getApiKey(self::MODE_PRODUCTION) === '' && self::getApiKey(self::MODE_SANDBOX) !== ''
                ? self::MODE_SANDBOX
                : self::MODE_PRODUCTION;
        }

        return $mode;
    }

    public static function isProduction(): bool
    {
        return self::mode() === self::MODE_PRODUCTION;
    }

    /** Base URL untuk mode tertentu (default: mode aktif). */
    public static function getBaseUrl(?string $mode = null): string
    {
        return rtrim((string) config('services.scalify_pay.base_urls.' . ($mode ?? self::mode()), ''), '/');
    }

    /** API key untuk mode tertentu (default: mode aktif). Key hanya dari .env, tidak pernah ditulis di kode. */
    public static function getApiKey(?string $mode = null): string
    {
        return (string) config('services.scalify_pay.api_keys.' . ($mode ?? self::mode()), '');
    }

    /**
     * Send charge request to Scalify Pay Gateway (/payments/charge).
     *
     * @param array $payload Full payload according to Scalify Pay / Midtrans Core spec
     * @return array Standardized result array
     */
    public static function charge(array $payload): array
    {
        $url = self::getBaseUrl() . '/payments/charge';
        $apiKey = self::getApiKey();

        Log::info('ScalifyPay Charge Request', [
            'url'          => $url,
            'order_id'     => $payload['order_id'] ?? null,
            'amount'       => $payload['amount'] ?? null,
            'payment_type' => $payload['payment_type'] ?? null,
        ]);

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'X-API-Key'    => $apiKey,
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ])
                ->post($url, $payload);

            $body = $response->json() ?? [];

            Log::info('ScalifyPay Charge Response', [
                'status_code' => $response->status(),
                'response'    => $body,
            ]);

            if ($response->successful()) {
                $data = $body['data'] ?? $body;
                $paymentDetails = is_array($data['payment_details'] ?? null) ? $data['payment_details'] : [];
                $actions = $paymentDetails['actions'] ?? ($data['actions'] ?? []);

                // Ambil URL QR Code langsung dari actions (name: generate-qr-code)
                $qrImageUrl = null;
                if (is_array($actions)) {
                    foreach ($actions as $act) {
                        if (($act['name'] ?? '') === 'generate-qr-code') {
                            $qrImageUrl = $act['url'];
                            break;
                        }
                    }
                    if (!$qrImageUrl && !empty($actions[0]['url'])) {
                        $qrImageUrl = $actions[0]['url'];
                    }
                }

                return [
                    'success' => true,
                    'message' => $body['message'] ?? 'Pembayaran berhasil diinisialisasi.',
                    'data' => [
                        'order_id'       => $data['order_id'] ?? ($payload['order_id'] ?? ''),
                        'transaction_id' => $paymentDetails['transaction_id'] ?? ($data['transaction_id'] ?? null),
                        'qr_image_url'   => $qrImageUrl,
                        'amount'         => (int) ($data['amount'] ?? ($payload['amount'] ?? 0)),
                        'status'         => $data['status'] ?? ($paymentDetails['transaction_status'] ?? 'pending'),
                    ],
                ];
            }

            $errorMessage = $body['message'] ?? ('HTTP ' . $response->status() . ' - Gagal memproses pembayaran.');
            Log::warning('ScalifyPay Charge Error: ' . $errorMessage, ['body' => $body]);

            return [
                'success'     => false,
                'message'     => $errorMessage,
                'http_status' => $response->status(),
                'raw'         => $body,
            ];
        } catch (\Throwable $e) {
            Log::error('ScalifyPay Charge Exception: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Gangguan koneksi ke gateway Scalify Pay: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Helper khusus untuk charge QRIS Dinamis.
     *
     * @param string $orderId Kode unik pesanan
     * @param int|float $amount Nominal pembayaran
     * @param array $customer Data pelanggan ['name' => ..., 'email' => ..., 'phone' => ...]
     * @param array $itemDetails Daftar produk
     * @param string|null $acquirer e.g. 'gopay', 'airpay shopee', etc.
     * @param int $expiryMinutes Batas waktu pembayaran (default 30 menit)
     * @return array
     */
    public static function chargeQris(
        string $orderId,
        $amount,
        array $customer = [],
        array $itemDetails = [],
        ?string $acquirer = 'gopay',
        int $expiryMinutes = 30
    ): array {
        $firstName = $customer['first_name'] ?? $customer['name'] ?? 'Pelanggan';
        $lastName = $customer['last_name'] ?? null;
        $email = $customer['email'] ?? null;
        $phone = $customer['phone'] ?? null;

        $items = !empty($itemDetails) ? $itemDetails : [
            [
                'id' => 'ITEM-01',
                'name' => 'Pesanan ' . $orderId,
                'price' => (int) round($amount),
                'quantity' => 1,
            ]
        ];

        $payload = [
            'order_id' => $orderId,
            'amount' => (int) round($amount),
            'payment_type' => 'qris',
            'qris' => [
                'acquirer' => $acquirer ?: 'gopay',
            ],
            'customer' => [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
            ],
            'item_details' => $items,
            'metadata' => [
                'channel' => 'web_checkout',
            ],
            'expiry_minutes' => $expiryMinutes,
        ];

        return self::charge($payload);
    }
}
