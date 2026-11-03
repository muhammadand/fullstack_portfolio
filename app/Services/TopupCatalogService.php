<?php

namespace App\Services;

use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use Illuminate\Support\Facades\Cache;

/**
 * Data katalog untuk landing page top up customer.
 * Hanya mengambil kolom yang dipakai UI dan di-cache agar halaman cepat dimuat.
 */
class TopupCatalogService
{
    public const CACHE_KEY = 'topup.catalog.games.v1';
    public const CACHE_TTL = 300; // detik
    public const CATEGORY_SLUG = 'games';

    /**
     * @return array{category: array{name: string, slug: string}, brands: array<int, array{name: string, slug: string, logo: ?string}>}|null
     */
    public static function games(): ?array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $category = DigitalProductCategory::where('slug', self::CATEGORY_SLUG)
                ->where('is_active', true)
                ->first(['id', 'name', 'slug']);

            if (!$category) {
                return null;
            }

            // Hanya brand aktif yang punya minimal satu produk yang bisa dijual.
            $brands = DigitalProductBrand::where('digital_product_category_id', $category->id)
                ->where('is_active', true)
                ->whereExists(fn ($q) => $q->selectRaw('1')
                    ->from('digital_products')
                    ->whereColumn('digital_products.digital_product_brand_id', 'digital_product_brands.id')
                    ->where('digital_products.provider', 'digiflazz')
                    ->where('digital_products.is_active', true)
                    ->where('digital_products.is_missing', false)
                    ->where('digital_products.buyer_product_status', true)
                    ->where('digital_products.seller_product_status', true))
                ->orderBy('display_order')
                ->orderBy('name')
                ->get(['name', 'slug', 'logo'])
                ->map(fn ($b) => ['name' => $b->name, 'slug' => $b->slug, 'logo' => $b->logo])
                ->all();

            return [
                'category' => ['name' => $category->name, 'slug' => $category->slug],
                'brands' => $brands,
            ];
        });
    }

    /** Panggil setiap kali produk/brand/kategori berubah agar landing page tidak menampilkan data basi. */
    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
