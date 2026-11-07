<?php

namespace Tests\Feature;

use App\Models\Affiliate;
use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\PriceLevel;
use App\Services\PpobCatalogService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AffiliatePulsaPageTest extends TestCase
{
    use DatabaseTransactions;

    protected Affiliate $affiliate;
    protected PriceLevel $partner;
    protected DigitalProductBrand $brand;

    protected function setUp(): void
    {
        parent::setUp();

        $this->partner = PriceLevel::firstOrCreate(
            ['code' => PriceLevel::PARTNER],
            ['name' => 'Partner (Scalify)', 'margin_type' => 'percent', 'margin_value' => 2]
        );
        PriceLevel::firstOrCreate(
            ['code' => PriceLevel::RETAIL],
            ['name' => 'Retail', 'margin_type' => 'percent', 'margin_value' => 5, 'is_default' => true]
        );

        $this->affiliate = Affiliate::firstOrCreate(
            ['email' => 'pulsa_partner@scalify.id'],
            [
                'name' => 'Pulsa Partner',
                'password' => bcrypt('password123'),
                'affiliate_code' => 'PULSA' . rand(100, 999),
                'status' => 'approved',
            ]
        );
        $this->affiliate->forceFill(['status' => 'approved', 'price_level_id' => $this->partner->id])->save();

        $category = DigitalProductCategory::firstOrCreate(['slug' => 'pulsa'], ['name' => 'Pulsa']);
        $category->forceFill(['is_active' => true])->save();

        $this->brand = DigitalProductBrand::create([
            'digital_product_category_id' => $category->id,
            'name' => 'TELKOMSEL ' . strtoupper(uniqid()),
            'slug' => 'pulsa-telkomsel-' . uniqid(),
            'is_active' => true,
        ]);
    }

    protected function makeProduct(string $name, float $cost, array $extra = []): DigitalProduct
    {
        $sku = 'tsel-' . uniqid();

        return DigitalProduct::create(array_merge([
            'provider' => 'digiflazz', 'sku_code' => $sku, 'slug' => $sku, 'name' => $name,
            'digital_product_brand_id' => $this->brand->id, 'cost_price' => $cost, 'is_active' => true,
        ], $extra));
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('affiliate.ppob.pulsa'))->assertRedirect(route('affiliate.login'));
    }

    public function test_affiliate_sees_pulsa_products_with_partner_price(): void
    {
        $p5 = $this->makeProduct($this->brand->name . ' 5.000', 5100);
        $p10 = $this->makeProduct($this->brand->name . ' 10.000', 10050);
        $this->makeProduct($this->brand->name . ' 20.000 Nonaktif', 20000, ['is_active' => false]);

        $response = $this->actingAs($this->affiliate, 'affiliate')->get(route('affiliate.ppob.pulsa'));

        $response->assertOk();
        $response->assertViewIs('affiliate.ppob.pulsa');
        $response->assertSee('data-operator="' . $this->brand->slug . '"', false);
        $response->assertSeeInOrder(['5.000', '10.000']); // nama dipendekkan & urut harga termurah
        $response->assertDontSee('Nonaktif');

        $partnerPrice = 'Rp ' . number_format($this->partner->applyMargin(5100), 0, ',', '.');
        $response->assertSee($partnerPrice);
        $response->assertSee('data-product-id="' . $p10->id . '"', false);
        $response->assertSee($this->partner->name);
    }

    public function test_manual_price_override_is_used_for_partner_level(): void
    {
        $product = $this->makeProduct($this->brand->name . ' 25.000', 24800);
        $product->priceOverrides()->create(['price_level_id' => $this->partner->id, 'selling_price' => 24999]);

        $catalog = PpobCatalogService::catalog('pulsa', $this->affiliate->fresh());
        $operator = collect($catalog['operators'])->firstWhere('slug', $this->brand->slug);

        $this->assertSame(24999.0, $operator['products'][0]['price']);
        $this->assertSame('25.000', $operator['products'][0]['name']);
        $this->assertContains('0812', $operator['prefixes']);
    }

    public function test_empty_state_when_no_products(): void
    {
        $this->actingAs($this->affiliate, 'affiliate')
            ->get(route('affiliate.ppob.pulsa'))
            ->assertOk();

        $catalog = PpobCatalogService::catalog('pulsa', $this->affiliate);
        $this->assertNull(collect($catalog['operators'])->firstWhere('slug', $this->brand->slug));
    }

    public function test_pulsa_menu_item_links_to_page(): void
    {
        $this->actingAs($this->affiliate, 'affiliate')
            ->get(route('affiliate.menu'))
            ->assertSee(route('affiliate.ppob.pulsa'), false);
    }
}
