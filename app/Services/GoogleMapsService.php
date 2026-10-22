<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class GoogleMapsService
{
    /**
     * Parse Google Maps URL dan dapatkan Place ID beserta metadata lokasi.
     *
     * @param string $url Short URL atau Resolved Full URL
     * @return array
     * @throws Exception
     */
    public function getPlaceDetailsFromUrl(string $url): array
    {
        $resolvedUrl = $this->resolveUrl($url);

        // 1. Ekstrak Lat & Long
        $latitude = null;
        $longitude = null;
        if (preg_match('/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/', $resolvedUrl, $matches)) {
            $latitude = (float) $matches[1];
            $longitude = (float) $matches[2];
        } elseif (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $resolvedUrl, $matches)) {
            $latitude = (float) $matches[1];
            $longitude = (float) $matches[2];
        }

        // 2. Ekstrak pasangan Hex: !1s0x...:0x...
        if (!preg_match('/!1s(0x[0-9a-fA-F]+):(0x[0-9a-fA-F]+)/', $resolvedUrl, $matches)) {
            throw new Exception("Format Feature ID hex tidak ditemukan di URL.");
        }

        $queryHex = $matches[1];   // contoh: 0x2e69f3f79a35f997
        $featureHex = $matches[2]; // contoh: 0x3877c5bc98573b28

        // 3. Konversi hex ke Google Place ID (ChIJ...)
        $placeId = $this->convertHexPairToPlaceId($queryHex, $featureHex);

        // 4. CID (Customer ID) dalam format desimal (opsional, sering dipakai link review)
        $cidDecimal = base_convert(ltrim($featureHex, '0x'), 16, 10);

        return [
            'place_id'     => $placeId,
            'latitude'     => $latitude,
            'longitude'    => $longitude,
            'cid'          => $cidDecimal,
            'resolved_url' => $resolvedUrl,
        ];
    }

    /**
     * Resolve short URL Google Maps ke full URL.
     */
    private function resolveUrl(string $url): string
    {
        if (str_contains($url, 'maps.app.goo.gl') || str_contains($url, 'goo.gl/maps')) {
            $response = Http::withoutRedirecting()->get($url);
            $redirectUrl = $response->header('Location');

            if ($redirectUrl) {
                return $redirectUrl;
            }
        }

        return $url;
    }

    /**
     * Konversi pasangan 64-bit Hex Google ke Place ID (Protobuf -> URL-safe Base64).
     */
    private function convertHexPairToPlaceId(string $queryHex, string $featureHex): string
    {
        // Bersihkan prefix 0x dan pad ke 16 karakter hex (8 byte)
        $qHex = str_pad(ltrim($queryHex, '0x'), 16, '0', STR_PAD_LEFT);
        $fHex = str_pad(ltrim($featureHex, '0x'), 16, '0', STR_PAD_LEFT);

        // Ubah hex ke byte biner (Little Endian uint64)
        $qBytes = strrev(hex2bin($qHex));
        $fBytes = strrev(hex2bin($fHex));

        // Format wire protobuf Google Place ID:
        // Tag 1 (0x0A = field 1, length-delimited) + Length (0x10 = 16 bytes) + qBytes + fBytes
        $buffer = "\x0A\x10" . $qBytes . $fBytes;

        // Base64 URL-safe tanpa padding '='
        $base64 = base64_encode($buffer);
        return rtrim(strtr($base64, '+/', '-_'), '=');
    }
}
