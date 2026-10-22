<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class GoogleMapsService
{
    /**
     * Parse Google Maps URL dan dapatkan Place ID beserta metadata lokasi & Write Review URL.
     *
     * @param string $url Short URL atau Resolved Full URL
     * @return array
     * @throws Exception
     */
    public function getPlaceDetailsFromUrl(string $url): array
    {
        $url = trim($url);

        // Jika URL sudah berupa link direct write review dengan placeid
        if (preg_match('/[?&]placeid=([a-zA-Z0-9_\-]+)/', $url, $matches)) {
            $placeId = $matches[1];
            return [
                'place_id'         => $placeId,
                'write_review_url' => "https://search.google.com/local/writereview?placeid={$placeId}",
                'latitude'         => null,
                'longitude'        => null,
                'cid'              => null,
                'resolved_url'     => $url,
            ];
        }

        $resolvedUrl = $this->resolveUrl($url);

        // 1. Ekstrak Lat & Long jika ada di URL
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
            // Cek apakah resolved url sudah membawa placeid
            if (preg_match('/[?&]placeid=([a-zA-Z0-9_\-]+)/', $resolvedUrl, $pMatches)) {
                $placeId = $pMatches[1];
                return [
                    'place_id'         => $placeId,
                    'write_review_url' => "https://search.google.com/local/writereview?placeid={$placeId}",
                    'latitude'         => $latitude,
                    'longitude'        => $longitude,
                    'cid'              => null,
                    'resolved_url'     => $resolvedUrl,
                ];
            }

            throw new Exception("Format Feature ID hex tidak ditemukan di URL Google Maps. Pastikan URL mengarah ke lokasi bisnis spesifik.");
        }

        $queryHex = $matches[1];   // contoh: 0x2e69f3f79a35f997
        $featureHex = $matches[2]; // contoh: 0x3877c5bc98573b28

        // 3. Konversi hex ke Google Place ID (ChIJ...)
        $placeId = $this->convertHexPairToPlaceId($queryHex, $featureHex);

        // 4. CID (Customer ID) dalam format desimal (opsional)
        $cidDecimal = base_convert(ltrim($featureHex, '0x'), 16, 10);

        // 5. Generate URL tulis review langsung
        $writeReviewUrl = "https://search.google.com/local/writereview?placeid={$placeId}";

        return [
            'place_id'         => $placeId,
            'write_review_url' => $writeReviewUrl,
            'latitude'         => $latitude,
            'longitude'        => $longitude,
            'cid'              => $cidDecimal,
            'resolved_url'     => $resolvedUrl,
        ];
    }

    /**
     * Konversi URL Google Maps apapun menjadi URL Google Write Review langsung.
     */
    public function convertToWriteReviewUrl(string $url): string
    {
        $details = $this->getPlaceDetailsFromUrl($url);
        return $details['write_review_url'];
    }

    /**
     * Resolve short URL Google Maps ke full URL via productmate.com API dengan fallback HTTP redirect.
     */
    public function resolveUrl(string $url): string
    {
        $url = trim($url);

        // Jika URL short maps (maps.app.goo.gl atau goo.gl/maps)
        if (str_contains($url, 'maps.app.goo.gl') || str_contains($url, 'goo.gl/maps')) {
            // 1. Coba hit API resolve-url Productmate
            try {
                $response = Http::timeout(10)
                    ->asJson()
                    ->post('https://productmate.com/api/resolve-url', [
                        'url' => $url,
                    ]);

                if ($response->successful()) {
                    $json = $response->json();
                    if (!empty($json['resolved_url'])) {
                        return $json['resolved_url'];
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Productmate resolve-url API failed: " . $e->getMessage());
            }

            // 2. Fallback native HTTP redirect jika Productmate API tidak merespons
            try {
                $response = Http::withoutRedirecting()->timeout(5)->get($url);
                $redirectUrl = $response->header('Location');

                if ($redirectUrl) {
                    return $redirectUrl;
                }
            } catch (\Exception $e) {
                Log::warning("Native resolve URL failed: " . $e->getMessage());
            }
        }

        return $url;
    }

    /**
     * Konversi pasangan 64-bit Hex Google ke Place ID resmi (Protobuf -> URL-safe Base64 ChIJ...).
     * Format Protobuf: Tag 1 (0x0A 0x12) + Tag Field 1 (0x09 + 8 bytes LE) + Tag Field 2 (0x11 + 8 bytes LE)
     */
    public function convertHexPairToPlaceId(string $queryHex, string $featureHex): string
    {
        // Bersihkan prefix 0x dan pad ke 16 karakter hex (8 byte)
        $qHex = str_pad(ltrim($queryHex, '0x'), 16, '0', STR_PAD_LEFT);
        $fHex = str_pad(ltrim($featureHex, '0x'), 16, '0', STR_PAD_LEFT);

        // Ubah hex ke byte biner (Little Endian uint64)
        $qBytes = strrev(hex2bin($qHex));
        $fBytes = strrev(hex2bin($fHex));

        // Format wire protobuf Google Place ID (ChIJ...):
        // Tag 1 (0x0A) + Length (0x12 = 18 bytes) + Sub-tag 1 (0x09) + qBytes (8B) + Sub-tag 2 (0x11) + fBytes (8B)
        $buffer = "\x0A\x12\x09" . $qBytes . "\x11" . $fBytes;

        // Base64 URL-safe tanpa padding '='
        $base64 = base64_encode($buffer);
        return rtrim(strtr($base64, '+/', '-_'), '=');
    }
}
