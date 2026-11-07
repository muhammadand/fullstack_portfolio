<?php

namespace App\Services;

use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\PriceLevel;
use Illuminate\Support\Facades\Cache;

/**
 * Data katalog untuk landing page top up customer.
 * Hanya mengambil kolom yang dipakai UI dan di-cache agar halaman cepat dimuat.
 */
class TopupCatalogService
{
    public const CACHE_KEY = 'topup.catalog.games.v2';
    public const CACHE_TTL = 300; // detik
    public const CATEGORY_SLUG = 'games';

    /**
     * @return array{category: array{name: string, slug: string}, brands: array<int, array{name: string, slug: string, image: ?string}>}|null
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
                ->get(['name', 'slug', 'image'])
                ->map(fn ($b) => ['name' => $b->name, 'slug' => $b->slug, 'image' => $b->image])
                ->all();

            return [
                'category' => ['name' => $category->name, 'slug' => $category->slug],
                'brands' => $brands,
            ];
        });
    }

    /**
     * Detail satu game beserta daftar produknya (harga level retail). Tidak di-cache karena
     * jam cut-off dan harga harus selalu akurat; query dibatasi satu brand.
     *
     * @return array{brand: array{name: string, slug: string, image: ?string, category: string}, form: array, products: array<int, array{id: int, name: string, price: float, available: bool}>}|null
     */
    public static function game(string $slug): ?array
    {
        $brand = DigitalProductBrand::where('slug', $slug)
            ->where('is_active', true)
            ->whereHas('category', fn ($q) => $q->where('slug', self::CATEGORY_SLUG)->where('is_active', true))
            ->first(['id', 'name', 'slug', 'image']);

        if (!$brand) {
            return null;
        }

        $level = PriceLevel::retail();

        $products = DigitalProduct::sellable()
            ->where('digital_product_brand_id', $brand->id)
            ->with('priceOverrides:id,digital_product_id,price_level_id,selling_price')
            ->get(['id', 'name', 'cost_price', 'start_cut_off', 'end_cut_off'])
            ->map(function ($p) use ($level) {
                $price = $level ? $p->priceFor($level) : (float) $p->cost_price;

                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => $price,
                    'available' => !$p->isInCutOff() && $price > 0,
                ];
            })
            ->sortBy('price')
            ->values()
            ->all();

        if (!$products) {
            return null;
        }

        return [
            'brand' => ['name' => $brand->name, 'slug' => $brand->slug, 'image' => $brand->image],
            'form' => self::formFor($brand->name),
            'products' => $products,
        ];
    }

    /** Field input yang dibutuhkan sebuah game (lihat config/topup_games.php). */
    public static function formFor(string $brandName): array
    {
        $name = mb_strtolower($brandName);

        foreach (config('topup_games.rules') as $rule) {
            foreach ($rule['match'] as $needle) {
                if (str_contains($name, $needle)) {
                    return ['fields' => $rule['fields'], 'hint' => $rule['hint']];
                }
            }
        }

        return config('topup_games.default');
    }

    /** Panggil setiap kali produk/brand/kategori berubah agar landing page tidak menampilkan data basi. */
    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
