<?php

namespace App\Http\Controllers\ProdukDigital;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DigiflazzController extends Controller
{
    /**
     * Endpoint untuk testing transaksi ke https://api.digiflazz.com/v1/transaction
     *
     * Mendukung default test payload dari user jika tidak ada input:
     * {
     *     "username": "tuwumiWXAdqg",
     *     "buyer_sku_code": "test",
     *     "customer_no": "087800001233",
     *     "ref_id": "some1d",
     *     "sign": "a47659b5af3b52fb57d4b8a3c069b11b"
     * }
     */
    public function testTransaction(Request $request): JsonResponse
    {
        $username = $request->input('username', config('services.digiflazz.username', 'tuwumiWXAdqg'));
        $apiKey = $request->input('api_key', config('services.digiflazz.api_key', ''));
        $buyerSkuCode = $request->input('buyer_sku_code', 'test');
        $customerNo = $request->input('customer_no', '087800001233');
        $refId = $request->input('ref_id', 'some1d');

        // Jika user mengirimkan 'sign' secara eksplisit, gunakan itu.
        // Jika tidak dan api_key tersedia, generate: md5(username + apiKey + ref_id).
        // Jika tidak ada keduanya, gunakan default sign contoh testing.
        if ($request->filled('sign')) {
            $sign = $request->input('sign');
        } elseif (!empty($apiKey)) {
            $sign = md5($username . $apiKey . $refId);
        } else {
            $sign = 'a47659b5af3b52fb57d4b8a3c069b11b';
        }

        $payload = [
            'username' => $username,
            'buyer_sku_code' => $buyerSkuCode,
            'customer_no' => $customerNo,
            'ref_id' => $refId,
            'sign' => $sign,
        ];

        // Tambahkan testing mode jika diminta atau jika sku code adalah 'test'
        if ($request->has('testing')) {
            $payload['testing'] = filter_var($request->input('testing'), FILTER_VALIDATE_BOOLEAN);
        } elseif ($buyerSkuCode === 'test') {
            $payload['testing'] = true;
        }

        // Opsional max_price jika ada
        if ($request->filled('max_price')) {
            $payload['max_price'] = (int) $request->input('max_price');
        }

        // Opsional callback url jika ada
        if ($request->filled('cb_url')) {
            $payload['cb_url'] = $request->input('cb_url');
        }

        $apiUrl = config('services.digiflazz.url', 'https://api.digiflazz.com/v1') . '/transaction';

        Log::info('Digiflazz Test Transaction Request', [
            'url' => $apiUrl,
            'payload' => $payload,
        ]);

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($apiUrl, $payload);

            $responseBody = $response->json() ?? $response->body();

            Log::info('Digiflazz Test Transaction Response', [
                'status_code' => $response->status(),
                'response' => $responseBody,
            ]);

            return response()->json([
                'success' => $response->successful(),
                'http_status' => $response->status(),
                'request_payload' => $payload,
                'digiflazz_response' => $responseBody,
            ], $response->status());
        } catch (\Throwable $e) {
            Log::error('Digiflazz Test Transaction Exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'payload' => $payload,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghubungi server Digiflazz: ' . $e->getMessage(),
                'request_payload' => $payload,
            ], 500);
        }
    }

    /**
     * Endpoint dinamis untuk memproses transaksi Digiflazz secara terprogram.
     */
    public function transaction(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'buyer_sku_code' => 'required|string',
            'customer_no' => 'required|string',
            'ref_id' => 'nullable|string',
            'testing' => 'nullable|boolean',
            'max_price' => 'nullable|integer',
            'cb_url' => 'nullable|url',
        ]);

        $username = config('services.digiflazz.username', env('DIGIFLAZZ_USERNAME', 'tuwumiWXAdqg'));
        $apiKey = config('services.digiflazz.api_key', env('DIGIFLAZZ_API_KEY', ''));
        $refId = $validated['ref_id'] ?? ('TRX-' . strtoupper(Str::random(10)));

        if (empty($apiKey) && !$request->filled('sign')) {
            return response()->json([
                'success' => false,
                'message' => 'DIGIFLAZZ_API_KEY belum dikonfigurasi di .env atau parameter sign tidak disertakan.',
            ], 422);
        }

        $sign = $request->input('sign', md5($username . $apiKey . $refId));

        $payload = [
            'username' => $username,
            'buyer_sku_code' => $validated['buyer_sku_code'],
            'customer_no' => $validated['customer_no'],
            'ref_id' => $refId,
            'sign' => $sign,
        ];

        if (isset($validated['testing'])) {
            $payload['testing'] = (bool) $validated['testing'];
        }

        if (isset($validated['max_price'])) {
            $payload['max_price'] = (int) $validated['max_price'];
        }

        if (isset($validated['cb_url'])) {
            $payload['cb_url'] = $validated['cb_url'];
        }

        $apiUrl = config('services.digiflazz.url', 'https://api.digiflazz.com/v1') . '/transaction';

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($apiUrl, $payload);

            return response()->json([
                'success' => $response->successful(),
                'http_status' => $response->status(),
                'data' => $response->json() ?? $response->body(),
            ], $response->status());
        } catch (\Throwable $e) {
            Log::error('Digiflazz Transaction Exception: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Koneksi ke gateway Digiflazz bermasalah: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Endpoint untuk cek saldo akun Digiflazz (cmd: deposit)
     */
    public function checkBalance(Request $request): JsonResponse
    {
        $username = config('services.digiflazz.username', env('DIGIFLAZZ_USERNAME', 'tuwumiWXAdqg'));
        $apiKey = $request->input('api_key', config('services.digiflazz.api_key', env('DIGIFLAZZ_API_KEY', '')));

        if (empty($apiKey) && !$request->filled('sign')) {
            return response()->json([
                'success' => false,
                'message' => 'DIGIFLAZZ_API_KEY belum dikonfigurasi di .env atau parameter sign tidak disertakan.',
            ], 422);
        }

        $sign = $request->input('sign', md5($username . $apiKey . 'depo'));

        $payload = [
            'cmd' => 'deposit',
            'username' => $username,
            'sign' => $sign,
        ];

        $apiUrl = config('services.digiflazz.url', 'https://api.digiflazz.com/v1') . '/cek-saldo';

        try {
            $response = Http::timeout(20)->post($apiUrl, $payload);

            return response()->json([
                'success' => $response->successful(),
                'http_status' => $response->status(),
                'data' => $response->json() ?? $response->body(),
            ], $response->status());
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

