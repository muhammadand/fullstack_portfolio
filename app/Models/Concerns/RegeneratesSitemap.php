<?php

namespace App\Models\Concerns;

use App\Support\SitemapBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * Tulis ulang sitemap.xml saat record publik dibuat, berubah, atau dihapus.
 * Perubahan yang hanya menyentuh penghitung (view_count, link_clicks) diabaikan,
 * karena increment() juga memicu event "updated" di setiap kunjungan halaman.
 *
 * Hanya untuk dipakai di model Eloquent (@mixin memberi tahu editor/Intelephense soal created(), updated(), dst).
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait RegeneratesSitemap
{
    /** Kolom yang tidak memengaruhi sitemap. */
    protected static array $sitemapIgnoredColumns = ['view_count', 'views_count', 'link_clicks', 'updated_at', 'is_rewarded'];

    public static function bootRegeneratesSitemap(): void
    {
        static::created(fn () => SitemapBuilder::regenerateQuietly());
        static::deleted(fn () => SitemapBuilder::regenerateQuietly());

        static::updated(function (Model $model) {
            $relevant = array_diff(array_keys($model->getChanges()), static::$sitemapIgnoredColumns);
            if ($relevant !== []) {
                SitemapBuilder::regenerateQuietly();
            }
        });
    }
}
