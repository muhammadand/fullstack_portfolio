<?php

namespace Tests\Feature;

use App\Livewire\Admin\DigitalProductIndex;
use App\Models\DigitalProduct;
use App\Models\DigitalProductCostHistory;
use App\Models\PriceLevel;
use App\Models\User;
use App\Services\DigitalProductSyncService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class AdminDigitalCatalogTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::first() ?? User::create([
            'name' => 'Admin Catalog Test',
            'email' => 'admin_catalog_' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }

    protected function item(array $override = []): array
    {
        return array_merge([
            'product_name' => 'Axis 10.000',
            'category' => 'Pulsa',
            'brand' => 'AXIS',
            'type' => 'Umum',
            'seller_name' => 'AG***',
            'price' => 10992,
            'buyer_sku_code' => 'zz-test-ax10',
            'buyer_product_status' => true,
            'seller_product_status' => true,
            'unlimited_stock' => true,
            'stock' => 0,
            'multi' => true,
            'start_cut_off' => '23:40',
            'end_cut_off' => '0:10',
            'desc' => 'Reguler',
        ], $override);
    }

    protected function fakePriceList(array $items): void
    {
        // Reset factory agar stub baru tidak tertimpa stub lama.
        Http::swap(new \Illuminate\Http\Client\Factory());
        Http::fake(['*' => Http::response(['data' => $items], 200)]);
    }

    public function test_sync_stores_new_products_as_inactive_with_mapped_fields(): void
    {
        $this->fakePriceList([$this->item()]);

        $log = app(DigitalProductSyncService::class)->sync($this->admin->id);

        $this->assertSame('success', $log->status);
        $this->assertSame(1, $log->total_new);

        $product = DigitalProduct::where('sku_code', 'zz-test-ax10')->firstOrFail();
        $this->assertSame('digiflazz', $product->provider);
        $this->assertFalse($product->is_active);
        $this->assertSame('10992.00', $product->cost_price);
        $this->assertSame('00:10:00', $product->end_cut_off);
        $this->assertSame('AXIS', $product->brand->name);
        $this->assertSame('Reguler', $product->description);
    }

    public function test_resync_keeps_is_active_and_records_cost_change(): void
    {
        $this->fakePriceList([$this->item()]);
        app(DigitalProductSyncService::class)->sync();

        $product = DigitalProduct::where('sku_code', 'zz-test-ax10')->firstOrFail();
        $product->update(['is_active' => true]);

        $this->fakePriceList([$this->item(['price' => 11500])]);
        $log = app(DigitalProductSyncService::class)->sync();

        $this->assertSame(1, $log->total_cost_changed);
        $this->assertSame(0, $log->total_new);

        $product->refresh();
        $this->assertTrue($product->is_active);
        $this->assertSame('11500.00', $product->cost_price);
        $this->assertSame(1, DigitalProductCostHistory::where('digital_product_id', $product->id)->count());
    }

    public function test_sku_missing_from_pricelist_is_flagged_not_deleted(): void
    {
        $this->fakePriceList([$this->item(), $this->item(['buyer_sku_code' => 'zz-test-ax20', 'product_name' => 'Axis 20.000'])]);
        app(DigitalProductSyncService::class)->sync();

        $this->fakePriceList([$this->item()]);
        app(DigitalProductSyncService::class)->sync();

        $this->assertTrue(DigitalProduct::where('sku_code', 'zz-test-ax20')->firstOrFail()->is_missing);
        $this->assertFalse(DigitalProduct::where('sku_code', 'zz-test-ax10')->firstOrFail()->is_missing);
    }

    public function test_invalid_response_marks_log_failed_and_changes_nothing(): void
    {
        Http::fake(['*' => Http::response(['data' => ['rc' => '83', 'message' => 'Limit pengecekan price list']], 200)]);

        $log = app(DigitalProductSyncService::class)->sync();

        $this->assertSame('failed', $log->status);
        $this->assertNotEmpty($log->error_message);
        $this->assertSame(0, DigitalProduct::where('provider', 'digiflazz')->where('sku_code', 'zz-test-ax10')->count());
    }

    public function test_cut_off_crossing_midnight_and_price_levels(): void
    {
        $product = new DigitalProduct([
            'cost_price' => 10000,
            'start_cut_off' => '23:40:00',
            'end_cut_off' => '00:10:00',
        ]);

        $this->assertTrue($product->isInCutOff(Carbon::parse('2026-11-03 23:50:00')));
        $this->assertTrue($product->isInCutOff(Carbon::parse('2026-11-04 00:05:00')));
        $this->assertFalse($product->isInCutOff(Carbon::parse('2026-11-03 12:00:00')));

        $product->setRelation('priceOverrides', collect());
        $retail = PriceLevel::where('code', 'retail')->firstOrFail();
        $partner = PriceLevel::where('code', 'partner')->firstOrFail();
        $this->assertSame(10500.0, $product->priceFor($retail));
        $this->assertSame(10200.0, $product->priceFor($partner));
    }

    public function test_page_lists_digiflazz_catalog_and_toggle_works(): void
    {
        $this->fakePriceList([$this->item()]);
        app(DigitalProductSyncService::class)->sync();
        $product = DigitalProduct::where('sku_code', 'zz-test-ax10')->firstOrFail();

        $this->actingAs($this->admin)->get(route('admin.digital_products.index', ['q' => 'zz-test-ax10']))
            ->assertOk()
            ->assertSee('Axis 10.000')
            ->assertSee('Belum aktif');

        Livewire::actingAs($this->admin)->test(DigitalProductIndex::class)
            ->set('search', 'zz-test-ax10')
            ->assertSee('Axis 10.000')
            ->call('toggle', $product->id)
            ->assertSee('diaktifkan');

        $this->assertTrue($product->fresh()->is_active);
    }

    public function test_page_filters_by_status_and_brand(): void
    {
        $this->fakePriceList([
            $this->item(['product_name' => 'Axis Aktif Filter']),
            $this->item(['buyer_sku_code' => 'zz-test-tsel', 'brand' => 'TELKOMSEL', 'product_name' => 'Telkomsel Filter']),
        ]);
        app(DigitalProductSyncService::class)->sync();
        DigitalProduct::where('sku_code', 'zz-test-ax10')->update(['is_active' => true]);

        Livewire::actingAs($this->admin)->test(DigitalProductIndex::class)
            ->set('search', 'Filter')
            ->set('status', 'active')
            ->assertSee('Axis Aktif Filter')
            ->assertDontSee('Telkomsel Filter')
            ->set('status', '')
            ->set('brand', (string) DigitalProduct::where('sku_code', 'zz-test-tsel')->value('digital_product_brand_id'))
            ->assertSee('Telkomsel Filter')
            ->assertDontSee('Axis Aktif Filter');
    }

    public function test_lynk_tab_hides_digiflazz_products_and_vice_versa(): void
    {
        $this->fakePriceList([$this->item(['product_name' => 'Produk Khusus Digiflazz Hidden'])]);
        app(DigitalProductSyncService::class)->sync();
        DigitalProduct::create([
            'name' => 'Produk Lynk Only', 'slug' => 'lynk-only-' . uniqid(), 'lynk_slug' => 'lk1',
            'price' => 1000, 'is_active' => true,
        ]);

        Livewire::actingAs($this->admin)->test(DigitalProductIndex::class)
            ->set('provider', 'lynk')
            ->assertSee('Produk Lynk Only')
            ->assertDontSee('Produk Khusus Digiflazz Hidden')
            ->set('provider', 'digiflazz')
            ->assertSee('Produk Khusus Digiflazz Hidden')
            ->assertDontSee('Produk Lynk Only');
    }

    public function test_sync_button_runs_service_and_shows_summary(): void
    {
        $this->fakePriceList([$this->item()]);

        Livewire::actingAs($this->admin)->test(DigitalProductIndex::class)
            ->call('sync')
            ->assertSee('Sinkronisasi selesai')
            ->assertSet('error', null);

        $this->assertSame('success', \App\Models\DigitalProductSyncLog::latest('id')->value('status'));
    }

    public function test_sync_failure_is_shown_to_admin(): void
    {
        Http::swap(new \Illuminate\Http\Client\Factory());
        Http::fake(['*' => Http::response(['data' => ['rc' => '83', 'message' => 'Limit pengecekan price list']], 200)]);

        Livewire::actingAs($this->admin)->test(DigitalProductIndex::class)
            ->call('sync')
            ->assertSee('Sinkronisasi gagal');
    }

    public function test_queries_only_select_columns_needed_by_ui(): void
    {
        $this->fakePriceList([$this->item()]);
        app(DigitalProductSyncService::class)->sync();

        \DB::enableQueryLog();
        Livewire::actingAs($this->admin)->test(DigitalProductIndex::class)->assertOk();
        $queries = collect(\DB::getQueryLog())->pluck('query')->filter(fn ($q) => str_contains($q, 'from `digital_products`'));
        \DB::disableQueryLog();

        $this->assertTrue($queries->isNotEmpty());
        $this->assertTrue($queries->every(fn ($q) => !str_contains($q, 'select * from `digital_products`') && !str_contains($q, '`raw_payload`')));
    }
}
