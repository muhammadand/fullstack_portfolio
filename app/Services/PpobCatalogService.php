<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\DigitalProduct;
use App\Models\DigitalProductCategory;
use App\Models\PriceLevel;
use Illuminate\Support\Str;

/**
 * Katalog PPOB (pulsa, paket data, PLN) untuk halaman partner, dengan harga level partner.
 * Tidak di-cache karena harga & jam cut-off harus selalu akurat; query dibatasi satu kategori
 * dan hanya kolom yang dipakai UI.
 */
class PpobCatalogService
{
    /**
     * @return array{
     *     level: array{name: string},
     *     operators: array<int, array{slug: string, name: string, image: ?string, color: string, prefixes: array<int, string>, products: array<int, array{id: int, name: string, price: float, retail_price: float, profit: float, available: bool}>}>
     * }
     */
    public static function catalog(string $type, Affiliate $affiliate): array
    {
        $level = self::levelFor($affiliate);
        $empty = ['level' => ['name' => $level?->name ?? 'Partner'], 'operators' => []];

        // 1) Kategori berdasarkan slug (mis. "pulsa").
        $category = DigitalProductCategory::where('slug', config("ppob.categories.$type", $type))
            ->where('is_active', true)
            ->first(['id']);

        if (!$category) {
            return $empty;
        }

        // 2) Brand milik kategori -> 3) produk per digital_product_brand_id -> 4) harga per level dari digital_product_prices.
        //    Eager load = 3 query total (brands, products, prices), bukan query per brand/produk.
        $brands = $category->brands()
            ->where('is_active', true)
            ->orderBy('display_order')
            ->orderBy('name')
            ->with(['products' => fn ($q) => $q->sellable()
                ->select(['id', 'digital_product_brand_id', 'name', 'cost_price', 'start_cut_off', 'end_cut_off'])
                ->with('priceOverrides:id,digital_product_id,price_level_id,selling_price')])
            ->get(['id', 'digital_product_category_id', 'name', 'slug', 'image']);

        if ($brands->isEmpty()) {
            return $empty;
        }

        $retail = PriceLevel::retail();

        $operators = [];
        foreach ($brands as $brand) {
            $products = $brand->products
                ->map(function (DigitalProduct $p) use ($brand, $level, $retail) {
                    $price = $level ? $p->priceFor($level) : (float) $p->cost_price;
                    $retailPrice = $retail ? $p->priceFor($retail) : $price;

                    return [
                        'id' => $p->id,
                        'name' => self::shortName($p->name, $brand->name),
                        'price' => $price,
                        'retail_price' => $retailPrice,
                        'profit' => max(0, $retailPrice - $price),
                        'available' => !$p->isInCutOff(),
                    ];
                })
                ->sortBy('price')
                ->values()
                ->all();

            if (!$products) {
                continue;
            }

            $meta = self::operatorMeta($brand->name);
            $operators[] = [
                'slug' => $brand->slug,
                'name' => $brand->name,
                'image' => $brand->image,
                'color' => $meta['color'],
                'prefixes' => $meta['prefixes'],
                'products' => $products,
            ];
        }

        return ['level' => $empty['level'], 'operators' => $operators];
    }

    /**
     * Produk yang boleh dibeli untuk jenis PPOB tertentu: brand & kategori aktif, produk sellable.
     * (Jam cut-off dicek terpisah lewat isSellable() saat checkout.)
     */
    public static function findProduct(string $type, int $productId): ?DigitalProduct
    {
        $slug = config("ppob.categories.$type", $type);

        return DigitalProduct::sellable()
            ->whereKey($productId)
            ->whereHas('brand', fn ($q) => $q->where('is_active', true)
                ->whereHas('category', fn ($c) => $c->where('slug', $slug)->where('is_active', true)))
            ->with(['brand:id,name', 'priceOverrides:id,digital_product_id,price_level_id,selling_price'])
            ->first();
    }

    /** Level harga partner: milik affiliate, fallback ke level "partner", lalu retail. */
    public static function levelFor(Affiliate $affiliate): ?PriceLevel
    {
        return $affiliate->priceLevel
            ?? PriceLevel::where('code', PriceLevel::PARTNER)->first()
            ?? PriceLevel::retail();
    }

    /** Info operator (prefix nomor & warna) dari config/ppob.php berdasarkan nama brand. */
    public static function operatorMeta(string $brandName): array
    {
        $name = mb_strtolower($brandName);

        foreach (config('ppob.operators') as $operator) {
            foreach ($operator['match'] as $needle) {
                if (str_contains($name, $needle)) {
                    return $operator;
                }
            }
        }

        return ['key' => Str::slug($brandName), 'prefixes' => [], 'color' => 'text-slate-300'];
    }

    /** "Telkomsel 5.000" -> "5.000" agar kartu ringkas; nama asli dipakai jika hasilnya kosong. */
    public static function shortName(string $productName, string $brandName): string
    {
        $short = trim(preg_replace('/^' . preg_quote($brandName, '/') . '\s*[-:]?\s*/i', '', $productName));

        return $short !== '' ? $short : $productName;
    }
}
