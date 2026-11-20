<?php

namespace App\Support;

use App\Models\Blog;
use App\Models\Career;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Log;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

/**
 * Pembuat sitemap.xml. File ditulis ulang otomatis setiap ada blog/portfolio/lowongan yang terbit,
 * berubah, atau dihapus (lihat App\Models\Concerns\RegeneratesSitemap), jadi Google selalu dapat
 * daftar URL terbaru tanpa perlu membuka /generate-sitemap secara manual.
 *
 * Tetap berupa file statis karena di shared hosting Apache menyajikan public/sitemap.xml langsung.
 * URL memakai APP_URL (bukan host request) agar tidak pernah tertulis domain ngrok/www yang salah.
 */
class SitemapBuilder
{
    /** [path, changefreq, priority] */
    private const STATIC_PAGES = [
        ['/', Url::CHANGE_FREQUENCY_DAILY, 1.0],
        ['/service', Url::CHANGE_FREQUENCY_WEEKLY, 0.8],
        ['/about', Url::CHANGE_FREQUENCY_MONTHLY, 0.7],
        ['/contact', Url::CHANGE_FREQUENCY_MONTHLY, 0.7],
        ['/layanan/scm', Url::CHANGE_FREQUENCY_MONTHLY, 0.8],
        ['/layanan/template-cv', Url::CHANGE_FREQUENCY_WEEKLY, 0.9],
        ['/s/blogs', Url::CHANGE_FREQUENCY_DAILY, 0.9],
        ['/s/portfolio', Url::CHANGE_FREQUENCY_WEEKLY, 0.9],
        ['/s/careers', Url::CHANGE_FREQUENCY_WEEKLY, 0.8],
    ];

    public static function path(): string
    {
        $path = config('services.sitemap.path');
        if (!$path) {
            return public_path('sitemap.xml');
        }

        return str_starts_with($path, '/') ? $path : base_path($path);
    }

    public static function build(): Sitemap
    {
        $sitemap = Sitemap::create();
        $latestBlog = Blog::published()->max('updated_at');

        foreach (self::STATIC_PAGES as [$path, $freq, $priority]) {
            // Indeks blog ikut "berubah" saat ada artikel baru.
            $modified = in_array($path, ['/', '/s/blogs'], true) && $latestBlog ? $latestBlog : now();
            $sitemap->add(Url::create(self::url($path))
                ->setLastModificationDate(\Illuminate\Support\Carbon::parse($modified))
                ->setChangeFrequency($freq)
                ->setPriority($priority));
        }

        Blog::published()->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->get(['slug', 'updated_at', 'published_at', 'featured_image'])
            ->each(function (Blog $blog) use ($sitemap) {
                $url = Url::create(self::url("/s/blog/{$blog->slug}"))
                    ->setLastModificationDate($blog->updated_at ?? $blog->published_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8);
                if ($blog->featured_image) {
                    $url->addImage(self::url('/storage/' . $blog->featured_image));
                }
                $sitemap->add($url);
            });

        Portfolio::active()->get(['slug', 'updated_at'])->each(fn ($p) => $sitemap->add(
            Url::create(self::url("/s/portfolio/{$p->slug}"))
                ->setLastModificationDate($p->updated_at ?? now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8)
        ));

        Career::where('is_active', 1)->get(['slug', 'updated_at'])->each(fn ($c) => $sitemap->add(
            Url::create(self::url("/s/careers/{$c->slug}"))
                ->setLastModificationDate($c->updated_at ?? now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7)
        ));

        return $sitemap;
    }

    public static function write(): string
    {
        $path = self::path();
        self::build()->writeToFile($path);

        return $path;
    }

    /** Dipanggil dari event model: gagal menulis sitemap tidak boleh menggagalkan simpan artikel. */
    public static function regenerateQuietly(): void
    {
        try {
            self::write();
        } catch (\Throwable $e) {
            Log::warning('Gagal menulis ulang sitemap.xml: ' . $e->getMessage());
        }
    }

    private static function url(string $path): string
    {
        return rtrim((string) config('app.url'), '/') . $path;
    }
}
