<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Lindungi endpoint internal Digiflazz (cek saldo, price list, deposit, transaksi).
 * Pemanggil wajib mengirim token dari .env DIGIFLAZZ_INTERNAL_TOKEN lewat header
 * "X-Internal-Token: <token>" atau "Authorization: Bearer <token>".
 * Token kosong di .env = semua permintaan ditolak (fail closed).
 */
class DigiflazzInternalToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) config('services.digiflazz.internal_token');
        $given = (string) ($request->header('X-Internal-Token') ?: $request->bearerToken());

        if ($expected === '' || $given === '' || !hash_equals($expected, $given)) {
            Log::warning('Akses endpoint Digiflazz internal ditolak.', [
                'path'       => $request->path(),
                'ip'         => $request->ip(),
                'user_agent' => mb_substr((string) $request->userAgent(), 0, 255),
                'reason'     => $expected === '' ? 'token_not_configured' : ($given === '' ? 'token_missing' : 'token_invalid'),
            ]);

            return response()->json([
                'success' => false,
                'message' => $expected === ''
                    ? 'Endpoint dinonaktifkan: DIGIFLAZZ_INTERNAL_TOKEN belum diatur di server.'
                    : 'Unauthorized. Kirim header X-Internal-Token yang valid.',
            ], 401);
        }

        return $next($request);
    }
}
