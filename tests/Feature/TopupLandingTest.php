<?php

namespace Tests\Feature;

use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Services\TopupCatalogService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class TopupLandingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        TopupCatalogService::flush();
    }

    protected function category(string $name): DigitalProductCategory
    {
        return DigitalProductCategory::firstOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name]
        );
    }

    protected function brand(DigitalProductCategory $category, string $name, array $attrs = []): DigitalProductBrand
    {
        return DigitalProductBrand::create($attrs + [
            'digital_product_category_id' => $category->id,
            'name' => $name,
            'slug' => Str::slug($category->name . ' ' . $name) . '-' . uniqid(),
        ]);
    }

    protected function product(DigitalProductBrand $brand, array $attrs = []): DigitalProduct
    {
        $sku = 'tp-' . uniqid();

        return DigitalProduct::create($attrs + [
            'provider' => 'digiflazz',
            'sku_code' => $sku,
            'slug' => $sku,
            'name' => 'Item ' . $sku,
            'digital_product_brand_id' => $brand->id,
            'cost_price' => 1000,
            'is_active' => true,
        ]);
    }

    public function test_page_is_public_and_lists_only_games_brands_with_sellable_products(): void
    {
        $games = $this->category('Games');
        $pulsa = $this->category('Pulsa');

        $ml = $this->brand($games, 'Mobile Legends Zz');
        $this->product($ml);

        $ff = $this->brand($games, 'Free Fire Zz');
        $this->product($ff);

        $pulsaBrand = $this->brand($pulsa, 'Axis Zz');
        $this->product($pulsaBrand);

        $this->get(route('topup.index'))
            ->assertOk()
            ->assertSee('Top Up Game Favoritmu')
            ->assertSee('Mobile Legends Zz')
            ->assertSee('Free Fire Zz')
            ->assertDontSee('Axis Zz');
    }

    public function test_hides_brands_without_active_available_products_or_inactive_brands(): void
    {
        $games = $this->category('Games');

        $noProducts = $this->brand($games, 'Brand Kosong Zz');

        $inactiveProduct = $this->brand($games, 'Brand Nonaktif Produk Zz');
        $this->product($inactiveProduct, ['is_active' => false]);

        $missing = $this->brand($games, 'Brand Hilang Zz');
        $this->product($missing, ['is_missing' => true]);

        $disturbed = $this->brand($games, 'Brand Gangguan Zz');
        $this->product($disturbed, ['seller_product_status' => false]);

        $inactiveBrand = $this->brand($games, 'Brand Dimatikan Zz', ['is_active' => false]);
        $this->product($inactiveBrand);

        $ok = $this->brand($games, 'Brand Normal Zz');
        $this->product($ok);

        $this->get(route('topup.index'))
            ->assertOk()
            ->assertSee('Brand Normal Zz')
            ->assertDontSee('Brand Kosong Zz')
            ->assertDontSee('Brand Nonaktif Produk Zz')
            ->assertDontSee('Brand Hilang Zz')
            ->assertDontSee('Brand Gangguan Zz')
            ->assertDontSee('Brand Dimatikan Zz');
    }

    public function test_shows_empty_state_when_no_games_category(): void
    {
        DigitalProductCategory::where('slug', 'games')->delete();
        TopupCatalogService::flush();

        $this->get(route('topup.index'))
            ->assertOk()
            ->assertSee('Belum ada game tersedia');
    }

    public function test_catalog_only_selects_columns_needed_and_is_cached(): void
    {
        $games = $this->category('Games');
        $this->product($this->brand($games, 'Cache Brand Zz'));

        DB::enableQueryLog();
        TopupCatalogService::games();
        $first = collect(DB::getQueryLog())->pluck('query');
        DB::flushQueryLog();
        TopupCatalogService::games(); // dari cache
        $second = DB::getQueryLog();
        DB::disableQueryLog();

        $this->assertTrue($first->every(fn($q) => !str_contains($q, 'select *')));
        $this->assertTrue($first->contains(fn($q) => str_contains($q, 'select `name`, `slug`, `image` from `digital_product_brands`')));
        $this->assertCount(0, $second, 'Panggilan kedua harus dari cache, tanpa query.');
    }

    public function test_cache_is_flushed_when_admin_toggles_a_product(): void
    {
        $games = $this->category('Games');
        $product = $this->product($this->brand($games, 'Toggle Brand Zz'));

        $this->assertNotEmpty(TopupCatalogService::games()['brands']);

        $admin = \App\Models\User::first() ?? \App\Models\User::create([
            'name' => 'Admin Topup',
            'email' => 'admin_topup_' . uniqid() . '@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        \Livewire\Livewire::actingAs($admin)->test(\App\Livewire\Admin\DigitalProductIndex::class)
            ->call('toggle', $product->id);

        $slugs = collect(TopupCatalogService::games()['brands'])->pluck('name');
        $this->assertFalse($slugs->contains('Toggle Brand Zz'));
    }

    public function test_about_section_explains_the_page_and_uses_brand_name(): void
    {
        $this->get(route('topup.index'))
            ->assertOk()
            ->assertSee('Top</span> Indonesia', false)
            ->assertSee('Bayar dalam hitungan detik')
            ->assertSee('Satu QRIS untuk semua')
            ->assertSee('Layanan pelanggan ramah');
    }
}
