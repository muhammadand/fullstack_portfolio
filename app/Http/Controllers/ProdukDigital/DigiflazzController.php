<?php

namespace App\Http\Controllers\ProdukDigital;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DigiflazzController extends Controller
{
    /**
     * Endpoint API Cek Saldo Akun Digiflazz
     * Endpoint lokal: GET / POST /api/digiflazz/cek-saldo
     * Target: https://api.digiflazz.com/v1/cek-saldo
     */
    public function checkBalance(Request $request): JsonResponse
    {
        $username = config('services.digiflazz.username');
        $apiKey = config('services.digiflazz.api_key');
        $sign = md5($username . $apiKey . 'depo');
        $payload = [
            'cmd'      => 'deposit',
            'username' => $username,
            'sign'     => $sign,
        ];

        $apiUrl = rtrim(config('services.digiflazz.url'), '/') . '/cek-saldo';

        Log::info('Digiflazz Cek Saldo Request', [
            'url'     => $apiUrl,
            'payload' => $payload,
        ]);

        try {
            $response = Http::timeout(25)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ])
                ->post($apiUrl, $payload);

            $responseBody = $response->json() ?? $response->body();

            Log::info('Digiflazz Cek Saldo Response', [
                'status_code' => $response->status(),
                'response'    => $responseBody,
            ]);
            return response()->json([
                'success'            => $response->successful(),
                'http_status'        => $response->status(),
                'request_payload'    => $payload,
                'digiflazz_response' => $responseBody,
            ], $response->status());
        } catch (\Throwable $e) {
            Log::error('Digiflazz Cek Saldo Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success'         => false,
                'message'         => 'Gagal menghubungi server Digiflazz: ' . $e->getMessage(),
                'request_payload' => $payload,
            ], 500);
        }
    }

    /**
     * Endpoint API Get Price List Digiflazz (Daftar Harga Produk)
     * Endpoint lokal: POST /api/digiflazz/price-list
     * Target: https://api.digiflazz.com/v1/price-list
     *
     * Format Request Payload ke Digiflazz:
     * {
     *   "cmd": "prepaid", // 'prepaid' atau 'pasca'
     *   "username": "...",
     *   "sign": "md5(username + apiKey + 'pricelist')",
     *   "code": "xld10" // opsional: jika ingin cek 1 produk saja
     * }
     */
    public function getPrice(Request $request): JsonResponse
    {
        $cmd = $request->input('cmd');
        $username = config('services.digiflazz.username');
        $apiKey = config('services.digiflazz.api_key');
        $sign = md5($username . $apiKey . 'pricelist');
        $payload = [
            'cmd'      => $cmd,
            'username' => $username,
            'sign'     => $sign,
        ];
        if ($request->filled('code')) {
            $payload['code'] = $request->input('code');
        }
        $apiUrl = rtrim(config('services.digiflazz.url'), '/') . '/price-list';

        Log::info('Digiflazz Get Price List Request', [
            'url'     => $apiUrl,
            'payload' => $payload,
        ]);
        try {
            $response = Http::timeout(60)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ])
                ->post($apiUrl, $payload);

            $responseBody = $response->json() ?? $response->body();

            return response()->json([
                'success'            => $response->successful(),
                'http_status'        => $response->status(),
                'request_payload'    => $payload,
                'digiflazz_response' => $responseBody,
            ], $response->status());
        } catch (\Throwable $e) {
            Log::error('Digiflazz Get Price List Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success'         => false,
                'message'         => 'Gagal menghubungi server Digiflazz: ' . $e->getMessage(),
                'request_payload' => $payload,
            ], 500);
        }
    }
}
