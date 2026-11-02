<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DigiflazzService
{
    /**
     * Get Base API URL dari Config.
     */
    public static function getBaseUrl(): string
    {
        return rtrim(config('services.digiflazz.url'), '/');
    }

    /**
     * Get Username Digiflazz dari Config.
     */
    public static function getUsername(): string
    {
        return (string) config('services.digiflazz.username');
    }

    /**
     * Get API Key Digiflazz dari Config.
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
        return md5(self::getUsername() . self::getApiKey() . $suffix);
    }

    /**
     * Helper terpusat untuk kirim HTTP POST ke server Digiflazz.
     */
    protected static function post(string $endpoint, array $payload, int $timeout = 30): array
    {
        $apiUrl = self::getBaseUrl() . '/' . ltrim($endpoint, '/');

        Log::info("Digiflazz {$endpoint} Request", [
            'url'     => $apiUrl,
            'payload' => $payload,
        ]);

        try {
            $response = Http::timeout($timeout)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ])
                ->post($apiUrl, $payload);

            $responseBody = $response->json() ?? $response->body();

            Log::info("Digiflazz {$endpoint} Response", [
                'status_code' => $response->status(),
                'response'    => $responseBody,
            ]);

            return [
                'success'            => $response->successful(),
                'http_status'        => $response->status(),
                'request_payload'    => $payload,
                'digiflazz_response' => $responseBody,
            ];
        } catch (\Throwable $e) {
            Log::error("Digiflazz {$endpoint} Error: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success'         => false,
                'http_status'     => 500,
                'message'         => 'Gagal menghubungi server Digiflazz: ' . $e->getMessage(),
                'request_payload' => $payload,
            ];
        }
    }

    /**
     * Cek Saldo Akun Digiflazz (Deposit).
     * Endpoint: POST /cek-saldo
     */
    public static function checkBalance(): array
    {
        return self::post('/cek-saldo', [
            'cmd'      => 'deposit',
            'username' => self::getUsername(),
            'sign'     => self::generateSign('depo'),
        ], 25);
    }

    /**
     * Request Tiket Deposit Digiflazz.
     * Endpoint: POST /deposit
     *
     * @param int $amount Nominal deposit
     * @param string $bank Nama bank tujuan (BCA, MANDIRI, BRI, BNI, Flip, ShopeePay)
     * @param string $ownerName Nama pemilik rekening pengirim
     */
    public static function requestDeposit(int $amount, string $bank, string $ownerName): array
    {
        return self::post('/deposit', [
            'username'   => self::getUsername(),
            'amount'     => $amount,
            'Bank'       => $bank,
            'owner_name' => $ownerName,
            'sign'       => self::generateSign('deposit'),
        ], 30);
    }

    /**
     * Ambil Daftar Produk / Harga (Price List).
     * Endpoint: POST /price-list
     *
     * @param string $cmd 'prepaid' atau 'pasca'
     * @param string|null $codeFilter Filter buyer_sku_code tertentu (opsional)
     * @param string|null $category Filter kategori produk (opsional)
     * @param string|null $brand Filter merek produk (opsional)
     */
    public static function getPriceList(
        string $cmd = 'prepaid',
        ?string $codeFilter = null,
        ?string $category = null,
        ?string $brand = null
    ): array {
        $payload = [
            'cmd'      => in_array(strtolower($cmd), ['pasca', 'postpaid']) ? 'pasca' : 'prepaid',
            'username' => self::getUsername(),
            'sign'     => self::generateSign('pricelist'),
        ];

        if (!empty($codeFilter)) {
            $payload['code'] = (string) $codeFilter;
        }

        if (!empty($category)) {
            $payload['category'] = (string) $category;
        }

        if (!empty($brand)) {
            $payload['brand'] = (string) $brand;
        }

        return self::post('/price-list', $payload, 60);
    }

    /**
     * Kirim Transaksi Prabayar / Top Up (Pulsa, Data, PLN, Game, E-Money, dll).
     * Endpoint: POST /transaction
     *
     * @param string $buyerSkuCode Kode produk buyer (contoh: xld25)
     * @param string $customerNo Nomor pelanggan / HP / ID Game / No Meter
     * @param string|null $refId Ref ID unik transaksi Anda (opsional, auto-generate jika null)
     * @param bool $testing True jika ingin mode sandbox/testing
     * @param int|null $maxPrice Limit harga maksimal (opsional)
     * @param string|null $cbUrl Callback webhook URL khusus transaksi ini (opsional)
     * @param bool $allowDot True jika customer_no boleh berisi titik (opsional)
     */
    public static function transaction(
        string $buyerSkuCode,
        string $customerNo,
        ?string $refId = null,
        bool $testing = false,
        ?int $maxPrice = null,
        ?string $cbUrl = null,
        bool $allowDot = false
    ): array {
        $refId = $refId ?: ('TRX-' . date('YmdHis') . '-' . strtoupper(Str::random(6)));
        $sign = self::generateSign($refId);

        $payload = [
            'username'       => self::getUsername(),
            'buyer_sku_code' => $buyerSkuCode,
            'customer_no'    => $customerNo,
            'ref_id'         => $refId,
            'sign'           => $sign,
        ];

        if ($testing || $buyerSkuCode === 'test') {
            $payload['testing'] = true;
        }

        if (!is_null($maxPrice)) {
            $payload['max_price'] = (int) $maxPrice;
        }

        if (!empty($cbUrl)) {
            $payload['cb_url'] = $cbUrl;
        }

        if ($allowDot) {
            $payload['allow_dot'] = true;
        }

        return self::post('/transaction', $payload, 45);
    }

    /**
     * Trigger tes kirim webhook (Ping Event) ke Digiflazz.
     * Endpoint: POST /report/hooks/{hook_id}/pings
     * Target: https://api.digiflazz.com/v1/report/hooks/{hook_id}/pings
     *
     * @param string $hookId ID webhook yang ingin ditest
     */
    public static function pingWebhook(string $hookId): array
    {
        return self::post("/report/hooks/{$hookId}/pings", [], 30);
    }

    /**
     * Simpan incoming Webhook / Callback dari Digiflazz ke database.
     * Merekam seluruh headers khusus (X-Digiflazz-Event, X-Hub-Signature, User-Agent)
     * dan full body JSON payload sebelum dieksekusi bisnis logiknya.
     */
    public static function saveWebhook(\Illuminate\Http\Request $request): \App\Models\DigiflazzWebhook
    {
        $rawPostData = $request->getContent();
        $payload = json_decode($rawPostData, true) ?: ($request->json()->all() ?: $request->all());

        $data = $payload['data'] ?? $payload;

        $event = $request->header('X-Digiflazz-Event') ?? $request->header('x-digiflazz-event');
        $signature = $request->header('X-Hub-Signature') ?? $request->header('x-hub-signature');
        $userAgent = $request->header('User-Agent') ?? $request->header('user-agent');

        // Verifikasi HMAC sha1 jika secret diisi di config (.env DIGIFLAZZ_WEBHOOK_SECRET)
        $secret = config('services.digiflazz.webhook_secret');
        $isValidSignature = null;
        if (!empty($secret) && !empty($signature)) {
            $expectedSignature = 'sha1=' . hash_hmac('sha1', $rawPostData, $secret);
            $isValidSignature = hash_equals($expectedSignature, $signature);
        }

        // Tangani identifier jika callback berupa ping/test hook
        $refId = $data['ref_id'] ?? (isset($data['hook_id']) ? ('HOOK-' . $data['hook_id']) : null);
        $status = $data['status'] ?? (isset($data['hook_id']) ? 'ping' : null);
        $message = $data['message'] ?? (isset($data['hook_id']) ? 'Webhook ping test event' : null);

        Log::info('Digiflazz Webhook Received', [
            'event'              => $event,
            'signature'          => $signature,
            'is_valid_signature' => $isValidSignature,
            'user_agent'         => $userAgent,
            'ref_id'             => $refId,
            'status'             => $status,
            'rc'                 => $data['rc'] ?? null,
            'sn'                 => $data['sn'] ?? null,
            'payload'            => $payload,
        ]);

        return \App\Models\DigiflazzWebhook::create([
            'event'              => $event,
            'signature'          => $signature,
            'is_valid_signature' => $isValidSignature,
            'user_agent'         => $userAgent,
            'ip_address'         => $request->ip(),
            'ref_id'             => $refId,
            'customer_no'        => $data['customer_no'] ?? null,
            'customer_name'      => $data['customer_name'] ?? null,
            'buyer_sku_code'     => $data['buyer_sku_code'] ?? null,
            'status'             => $status,
            'message'            => $message,
            'rc'                 => isset($data['rc']) ? (string) $data['rc'] : null,
            'sn'                 => $data['sn'] ?? null,
            'price'              => isset($data['price']) ? (float) $data['price'] : null,
            'buyer_last_saldo'   => isset($data['buyer_last_saldo']) ? (float) $data['buyer_last_saldo'] : null,
            'payload'            => $payload,
            'headers'            => $request->headers->all(),
            'is_processed'       => false,
        ]);
    }
}
