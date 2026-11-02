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
        // Ambil credentials langsung dari config (tanpa perlu input parameter)
        $username = config('services.digiflazz.username');
        $apiKey = config('services.digiflazz.api_key');

        // Formula resmi signature Digiflazz: md5(username + apiKey + "depo")
        $sign = md5($username . $apiKey . 'depo');

        // Susun payload otomatis ke Digiflazz
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
}
