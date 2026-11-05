<?php

namespace Tests\Feature;

use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Services\DigitalProductSyncService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DigitalProductSyncCaseTest extends TestCase
{
    use DatabaseTransactions;

    protected function process(array $items): array
    {
        $svc = new DigitalProductSyncService();
        $m = new \ReflectionMethod($svc, 'process');

        return $m->invoke($svc, $items);
    }

    protected function item(string $sku, string $category, string $brand, int $price = 1000): array
    {
        return ['buyer_sku_code' => $sku, 'product_name' => $sku, 'category' => $category, 'brand' => $brand,
            'price' => $price, 'buyer_product_status' => true, 'seller_product_status' => true];
    }

    public function test_brand_and_category_matching_ignores_case_so_no_duplicate_entry(): void
    {
        $tag = uniqid();
        $cat = DigitalProductCategory::create(['name' => "Cat $tag", 'slug' => "cat-$tag"]);
        DigitalProductBrand::create(['digital_product_category_id' => $cat->id, 'name' => "Free Fire $tag", 'slug' => "ff-$tag"]);

        $stats = $this->process([
            $this->item("a-$tag", strtoupper($cat->name), strtoupper("Free Fire $tag")),
            $this->item("b-$tag", $cat->name, "free fire $tag"),
        ]);

        $this->assertSame(2, $stats['total_new']);
        $this->assertSame(1, DigitalProductBrand::where('digital_product_category_id', $cat->id)->count());
        $this->assertSame(1, DigitalProductCategory::where('name', $cat->name)->count());
    }

    public function test_unchanged_products_are_not_counted_as_updated(): void
    {
        $tag = uniqid();
        $items = [$this->item("u-$tag", "Cat $tag", "Brand $tag")];

        $this->process($items);
        $this->travel(10)->minutes(); // last_synced_at pasti berbeda
        $stats = $this->process($items);

        $this->assertSame(0, $stats['total_new']);
        $this->assertSame(0, $stats['total_updated']);

        $stats = $this->process([$this->item("u-$tag", "Cat $tag", "Brand $tag", 2000)]);
        $this->assertSame(1, $stats['total_updated']);
        $this->assertSame(1, $stats['total_cost_changed']);
        $this->assertSame(1, DigitalProduct::where('sku_code', "u-$tag")->count());
    }
}
