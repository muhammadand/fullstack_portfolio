<?php

namespace App\Services;

use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\DigitalProductCostHistory;
use App\Models\DigitalProductSyncLog;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Sinkronisasi katalog Digiflazz (price-list prepaid) ke tabel digital_products.
 *
 * - SKU baru        : disimpan dengan is_active = false (belum dijual).
 * - SKU lama        : hanya kolom supplier yang ditimpa; is_active tidak disentuh.
 * - SKU hilang      : ditandai is_missing = true, tidak dihapus.
 */
class DigitalProductSyncService
{
    public function sync(?int $userId = null): DigitalProductSyncLog
    {
        $log = DigitalProductSyncLog::create(['triggered_by' => $userId]);

        try {
            $result = DigiflazzService::getPriceList('prepaid');
            $items = $result['digiflazz_response']['data'] ?? null;

            if (!($result['success'] ?? false) || !is_array($items) || !array_is_list($items)) {
                $message = $result['message']
                    ?? $result['digiflazz_response']['data']['message']
                    ?? 'Respons price-list Digiflazz tidak valid.';

                throw new \RuntimeException($message);
            }

            $stats = DB::transaction(fn() => $this->process($items));
            TopupCatalogService::flush();

            $log->update($stats + [
                'status' => 'success',
                'finished_at' => now(),
            ]);
        } catch (\Throwable $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => Str::limit($e->getMessage(), 1000),
                'finished_at' => now(),
            ]);
        }

        return $log->fresh();
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array<string, int>
     */
    protected function process(array $items): array
    {
        $now = now();
        $stats = ['total_received' => 0, 'total_new' => 0, 'total_updated' => 0, 'total_cost_changed' => 0, 'total_missing' => 0];

        $existing = DigitalProduct::where('provider', 'digiflazz')->get()->keyBy('sku_code');
        $categories = DigitalProductCategory::all()->keyBy(fn($c) => mb_strtolower($c->name));
        $brands = DigitalProductBrand::all()->keyBy(fn($b) => $b->digital_product_category_id . '|' . mb_strtolower($b->name));
        $seen = [];

        foreach ($items as $item) {
            $sku = trim((string) ($item['buyer_sku_code'] ?? ''));
            if ($sku === '') {
                continue;
            }

            $stats['total_received']++;
            $seen[$sku] = true;

            $category = $this->resolveCategory($categories, (string) ($item['category'] ?? 'Lainnya'));
            $brand = $this->resolveBrand($brands, $category, (string) ($item['brand'] ?? 'Lainnya'));
            $cost = (float) ($item['price'] ?? 0);

            $supplier = [
                'name' => (string) ($item['product_name'] ?? $sku),
                'digital_product_brand_id' => $brand->id,
                'type' => $item['type'] ?? null,
                'cost_price' => $cost,
                'seller_name' => $item['seller_name'] ?? null,
                'buyer_product_status' => (bool) ($item['buyer_product_status'] ?? false),
                'seller_product_status' => (bool) ($item['seller_product_status'] ?? false),
                'unlimited_stock' => (bool) ($item['unlimited_stock'] ?? false),
                'stock' => (int) ($item['stock'] ?? 0),
                'multi' => (bool) ($item['multi'] ?? false),
                'start_cut_off' => $this->normalizeTime($item['start_cut_off'] ?? null),
                'end_cut_off' => $this->normalizeTime($item['end_cut_off'] ?? null),
                'description' => $item['desc'] ?? null,
                'raw_payload' => $item,
                'is_missing' => false,
                'last_synced_at' => $now,
            ];

            $product = $existing->get($sku);

            if (!$product) {
                DigitalProduct::create($supplier + [
                    'provider' => 'digiflazz',
                    'sku_code' => $sku,
                    'slug' => $this->uniqueSlug($sku),
                    'price' => 0,
                    'is_active' => false, // masuk katalog dulu, belum dijual
                ]);
                $stats['total_new']++;
                continue;
            }

            $oldCost = (float) $product->cost_price;
            $product->fill($supplier);

            // last_synced_at selalu berubah tiap sinkron, jangan dihitung sebagai perubahan data.
            if ($product->isDirty(array_keys(Arr::except($supplier, ['last_synced_at'])))) {
                $stats['total_updated']++;
            }

            if (abs($oldCost - $cost) > 0.001) {
                DigitalProductCostHistory::create([
                    'digital_product_id' => $product->id,
                    'old_cost' => $oldCost,
                    'new_cost' => $cost,
                    'changed_at' => $now,
                ]);
                $stats['total_cost_changed']++;
            }

            $product->save();
        }

        $stats['total_missing'] = DigitalProduct::where('provider', 'digiflazz')
            ->where('is_missing', false)
            ->whereNotIn('sku_code', array_keys($seen) ?: [''])
            ->update(['is_missing' => true]);

        return $stats;
    }

    protected function resolveCategory($categories, string $name): DigitalProductCategory
    {
        $lookup = mb_strtolower($name);

        if (!$categories->has($lookup)) {
            $base = Str::slug($name) ?: 'kategori';
            $slug = $base;
            $i = 1;
            while (DigitalProductCategory::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }

            $categories->put($lookup, DigitalProductCategory::create(['name' => $name, 'slug' => $slug]));
        }

        return $categories->get($lookup);
    }

    protected function resolveBrand($brands, DigitalProductCategory $category, string $name): DigitalProductBrand
    {
        $lookup = $category->id . '|' . mb_strtolower($name);

        if (!$brands->has($lookup)) {
            $brands->put($lookup, DigitalProductBrand::create([
                'digital_product_category_id' => $category->id,
                'name' => $name,
                'slug' => $this->uniqueBrandSlug($category->name, $name),
            ]));
        }

        return $brands->get($lookup);
    }

    protected function uniqueBrandSlug(string $category, string $name): string
    {
        $base = Str::slug($category . ' ' . $name) ?: 'brand';
        $slug = $base;
        $i = 1;
        while (DigitalProductBrand::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    protected function uniqueSlug(string $sku): string
    {
        $base = Str::slug($sku) ?: Str::random(8);
        $slug = $base;
        $i = 1;
        while (DigitalProduct::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    /** "0:10" -> "00:10:00" (Digiflazz tidak selalu memakai zero-padding). */
    protected function normalizeTime(?string $value): ?string
    {
        if (!$value || !preg_match('/^(\d{1,2}):(\d{2})/', $value, $m)) {
            return null;
        }

        return sprintf('%02d:%02d:00', (int) $m[1], (int) $m[2]);
    }
}
