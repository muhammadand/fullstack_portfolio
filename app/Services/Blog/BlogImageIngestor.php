<?php

namespace App\Services\Blog;

use Closure;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Simpan gambar utama artikel yang dikirim lewat API publik, dari salah satu bentuk:
 *   - file upload (multipart)
 *   - URL http(s)          -> diunduh server
 *   - base64 / data URI    -> "data:image/png;base64,..." atau base64 mentah
 *
 * Isi file selalu dicek sebagai gambar asli (bukan dari nama/header), maks 5 MB, jpg/png/webp/gif.
 * Unduhan URL dilindungi dari SSRF: hanya http(s), host harus ber-IP publik, IP dikunci saat koneksi
 * (anti DNS rebinding), tanpa redirect, ada batas waktu & ukuran.
 * Disimpan seperti upload admin: disk "public", folder blog_images/.
 */
class BlogImageIngestor
{
    public const DIRECTORY = 'blog_images';
    public const MAX_BYTES = 5 * 1024 * 1024;

    private const EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];

    /** @var Closure(string): array<string> host -> daftar IP (bisa diganti di test) */
    private Closure $resolver;

    public function __construct(?Closure $resolver = null)
    {
        $this->resolver = $resolver ?? fn (string $host) => gethostbynamel($host) ?: [];
    }

    /**
     * @return string path relatif di disk public (mis. blog_images/abc.jpg)
     * @throws InvalidArgumentException pesan aman untuk ditampilkan ke pengirim API
     */
    public function store(UploadedFile|string $image): string
    {
        $bytes = match (true) {
            $image instanceof UploadedFile => $this->fromUpload($image),
            preg_match('#^https?://#i', trim($image)) === 1 => $this->fromUrl(trim($image)),
            default => $this->fromBase64($image),
        };

        $ext = $this->detectExtension($bytes);
        $path = self::DIRECTORY . '/' . Str::random(40) . '.' . $ext;

        Storage::disk('public')->put($path, $bytes);

        return $path;
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function fromUpload(UploadedFile $file): string
    {
        if (!$file->isValid()) {
            throw new InvalidArgumentException('Upload gambar gagal.');
        }
        if ($file->getSize() > self::MAX_BYTES) {
            throw new InvalidArgumentException('Ukuran gambar maksimal 5 MB.');
        }

        return (string) file_get_contents($file->getRealPath());
    }

    private function fromBase64(string $value): string
    {
        $value = trim($value);
        if (preg_match('#^data:image/[a-z0-9.+-]+;base64,#i', $value, $m)) {
            $value = substr($value, strlen($m[0]));
        }

        // base64 4/3 lebih besar dari aslinya: tolak sebelum decode agar hemat memori.
        if (strlen($value) > (int) ceil(self::MAX_BYTES * 4 / 3) + 4) {
            throw new InvalidArgumentException('Ukuran gambar maksimal 5 MB.');
        }

        $bytes = base64_decode(preg_replace('/\s+/', '', $value), true);
        if ($bytes === false || $bytes === '') {
            throw new InvalidArgumentException('Gambar harus berupa file, URL http(s), atau base64 yang valid.');
        }

        return $bytes;
    }

    private function fromUrl(string $url): string
    {
        $parts = parse_url($url);
        $scheme = strtolower($parts['scheme'] ?? '');
        $host = $parts['host'] ?? '';

        if (!in_array($scheme, ['http', 'https'], true) || $host === '' || isset($parts['user']) || isset($parts['pass'])) {
            throw new InvalidArgumentException('URL gambar tidak valid.');
        }

        $host = trim($host, '[]');
        $ips = filter_var($host, FILTER_VALIDATE_IP) ? [$host] : ($this->resolver)($host);
        if ($ips === [] || collect($ips)->contains(fn ($ip) => !$this->isPublicIp($ip))) {
            throw new InvalidArgumentException('URL gambar harus mengarah ke server publik.');
        }

        $port = $parts['port'] ?? ($scheme === 'https' ? 443 : 80);
        $pinnedIp = str_contains($ips[0], ':') ? "[{$ips[0]}]" : $ips[0];

        try {
            $response = Http::withOptions([
                'allow_redirects' => false,
                'connect_timeout' => 5,
                'timeout'         => 15,
                // Kunci koneksi ke IP yang sudah dicek (cegah DNS rebinding ke IP internal).
                'curl'            => [CURLOPT_RESOLVE => ["{$host}:{$port}:{$pinnedIp}"]],
                'on_headers'      => function ($res) {
                    if ((int) $res->getHeaderLine('Content-Length') > self::MAX_BYTES) {
                        throw new \RuntimeException('too_large');
                    }
                },
                'progress'        => function ($total, $downloaded) {
                    if ($downloaded > self::MAX_BYTES) {
                        throw new \RuntimeException('too_large');
                    }
                },
            ])->get($url);
        } catch (\Throwable $e) {
            throw new InvalidArgumentException(str_contains($e->getMessage(), 'too_large')
                ? 'Ukuran gambar maksimal 5 MB.'
                : 'Gambar dari URL tidak bisa diunduh.');
        }

        if (!$response->successful()) {
            throw new InvalidArgumentException("Gambar dari URL tidak bisa diunduh (HTTP {$response->status()}).");
        }

        $bytes = $response->body();
        if (strlen($bytes) > self::MAX_BYTES) {
            throw new InvalidArgumentException('Ukuran gambar maksimal 5 MB.');
        }

        return $bytes;
    }

    private function detectExtension(string $bytes): string
    {
        if (strlen($bytes) > self::MAX_BYTES) {
            throw new InvalidArgumentException('Ukuran gambar maksimal 5 MB.');
        }

        $info = @getimagesizefromstring($bytes);
        $mime = $info['mime'] ?? null;

        if (!$mime || !isset(self::EXTENSIONS[$mime])) {
            throw new InvalidArgumentException('File bukan gambar yang didukung (jpg, png, webp, gif).');
        }

        return self::EXTENSIONS[$mime];
    }

    private function isPublicIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false;
    }
}
