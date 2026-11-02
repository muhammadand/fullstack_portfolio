<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DigiflazzService
{
    /**
     * Get Base API URL.
     */
    public static function getBaseUrl(): string
    {
        return rtrim(config('services.digiflazz.url', 'https://api.digiflazz.com/v1'), '/');
    }

    /**
     * Get Username Digiflazz.
     */
    public static function getUsername(): string
    {
        return (string) config('services.digiflazz.username', 'tuwumiWXAdqg');
    }

    /**
     * Get Production / Development API Key.
     */
    public static function getApiKey(): string
    {
        return (string) config('services.digiflazz.api_key', '');
    }

    /**
     * Generate MD5 signature standard Digiflazz.
     * sign = md5(username + apiKey + suffix)
     */
    public static function generateSign(string $suffix): string
    {
        $username = self::getUsername();
        $apiKey = self::getApiKey();

        return md5($username . $apiKey . $suffix);
    }

    /**
     * Cek Saldo Akun Digiflazz (Deposit).
     * Endpoint: POST /cek-saldo
     */
    public static function checkBalance(): array
    {
        $url = self::getBaseUrl() . '/cek-saldo';
        $username = self::getUsername();
        $sign = self::generateSign('depo');

        $payload = [
            'cmd'      => 'deposit',
            'username' => $username,
            'sign'     => $sign,
        ];

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ])
                ->post($url, $payload);

            $body = $response->json() ?? [];

            Log::info('Digiflazz Check Balance Response', [
                'status' => $response->status(),
                'body'   => $body,
            ]);

            return [
                'success'     => $response->successful(),
                'http_status' => $response->status(),
                'data'        => $body['data'] ?? $body,
            ];
        } catch (\Throwable $e) {
            Log::error('Digiflazz checkBalance error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Gagal menghubungi server Digiflazz: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Ambil Daftar Produk / Harga (Price List).
     * Endpoint: POST /price-list
     *
     * @param string $cmd 'prepaid' atau 'pasca'
     * @param string|null $codeFilter Filter buyer_sku_code tertentu (opsional)
     */
    public static function getPriceList(string $cmd = 'prepaid', ?string $codeFilter = null): array
    {
        $url = self::getBaseUrl() . '/price-list';
        $username = self::getUsername();
        $sign = self::generateSign('pricelist');

        $payload = [
            'cmd'      => in_array($cmd, ['pasca', 'postpaid']) ? 'pasca' : 'prepaid',
            'username' => $username,
            'sign'     => $sign,
        ];

        if (!empty($codeFilter)) {
            $payload['code'] = $codeFilter;
        }

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ])
                ->post($url, $payload);

            $body = $response->json() ?? [];

            return [
                'success'     => $response->successful(),
                'http_status' => $response->status(),
                'data'        => $body['data'] ?? $body,
            ];
        } catch (\Throwable $e) {
            Log::error('Digiflazz getPriceList error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Gagal mengambil daftar harga: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Kirim Transaksi Prabayar (Pulsa, Data, PLN, Game, E-Money, dll).
     * Endpoint: POST /transaction
     */
    public static function transaction(
        string $buyerSkuCode,
        string $customerNo,
        ?string $refId = null,
        bool $testing = false,
        ?int $maxPrice = null,
        ?string $cbUrl = null
    ): array {
        $url = self::getBaseUrl() . '/transaction';
        $username = self::getUsername();
        $refId = $refId ?: ('TRX-' . date('YmdHis') . '-' . strtoupper(Str::random(5)));
        $sign = self::generateSign($refId);

        $payload = [
            'username'       => $username,
            'buyer_sku_code' => $buyerSkuCode,
            'customer_no'    => $customerNo,
            'ref_id'         => $refId,
            'sign'           => $sign,
        ];

        if ($testing || $buyerSkuCode === 'test') {
            $payload['testing'] = true;
        }

        if (!is_null($maxPrice)) {
            $payload['max_price'] = $maxPrice;
        }

        if (!empty($cbUrl)) {
            $payload['cb_url'] = $cbUrl;
        }

        Log::info('Digiflazz Transaction Request', [
            'url'     => $url,
            'payload' => $payload,
        ]);

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ])
                ->post($url, $payload);

            $body = $response->json() ?? [];

            Log::info('Digiflazz Transaction Response', [
                'http_status' => $response->status(),
                'response'    => $body,
            ]);

            return [
                'success'         => $response->successful(),
                'http_status'     => $response->status(),
                'request_payload' => $payload,
                'data'            => $body['data'] ?? $body,
            ];
        } catch (\Throwable $e) {
            Log::error('Digiflazz transaction error: ' . $e->getMessage());

            return [
                'success'         => false,
                'message'         => 'Gangguan transaksi Digiflazz: ' . $e->getMessage(),
                'request_payload' => $payload,
            ];
        }
    }
}

