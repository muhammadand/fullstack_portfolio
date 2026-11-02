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
     * Endpoint lokal: POST /api/digiflazz/cek-saldo
     * Target: https://api.digiflazz.com/v1/cek-saldo
     *
     * Format Request Payload ke Digiflazz:
     * {
     *     "cmd": "deposit",
     *     "username": "tuwumiWXAdqg",
     *     "sign": "740b00a1b8784e028cc8078edf66d12b"
     * }
     */
    public function checkBalance(Request $request): JsonResponse
    {
        // 1. Ambil data dari request atau gunakan default config / test credentials
        $cmd = $request->input('cmd', 'deposit');
        $username = $request->input('username', config('services.digiflazz.username', env('DIGIFLAZZ_USERNAME', 'tuwumiWXAdqg')));
        $apiKey = $request->input('api_key', config('services.digiflazz.api_key', env('DIGIFLAZZ_API_KEY', '')));

        // 2. Tentukan 'sign'
        // Jika client mengirim 'sign', gunakan langsung.
        // Jika tidak tapi ada 'api_key', hitung otomatis: md5(username + apiKey + 'depo')
        // Jika keduanya kosong, gunakan default test signature
        if ($request->filled('sign')) {
            $sign = $request->input('sign');
        } elseif (!empty($apiKey)) {
            $sign = md5($username . $apiKey . 'depo');
        } else {
            $sign = '740b00a1b8784e028cc8078edf66d12b';
        }

        // 3. Susun payload sesuai spesifikasi Digiflazz
        $payload = [
            'cmd'      => $cmd,
            'username' => $username,
            'sign'     => $sign,
        ];

        $apiUrl = rtrim(config('services.digiflazz.url', env('DIGIFLAZZ_URL', 'https://api.digiflazz.com/v1')), '/') . '/cek-saldo';

        Log::info('Digiflazz Cek Saldo Request', [
            'url'     => $apiUrl,
            'payload' => $payload,
        ]);

        try {
            // 4. Kirim request POST ke https://api.digiflazz.com/v1/cek-saldo
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
}
