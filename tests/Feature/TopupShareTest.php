<?php

namespace Tests\Feature;

use App\Models\Affiliate;
use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\PriceLevel;
use App\Services\TopupCatalogService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TopupShareTest extends TestCase
{
    use DatabaseTransactions;

    protected DigitalProductBrand $brand;

    protected function setUp(): void
    {
        parent::setUp();
        TopupCatalogService::flush();
        PriceLevel::firstOrCreate(['code' => PriceLevel::RETAIL], ['name' => 'Retail', 'margin_type' => 'percent', 'margin_value' => 5, 'is_default' => true]);

        $cat = DigitalProductCategory::firstOrCreate(['slug' => 'games'], ['name' => 'Games']);
        $cat->forceFill(['is_active' => true])->save();
        $this->brand = DigitalProductBrand::create([
            'digital_product_category_id' => $cat->id, 'name' => 'Mobile Legends Share ' . uniqid(), 'slug' => 'ml-share-' . uniqid(), 'is_active' => true,
        ]);
        foreach ([[1650, '5 Diamond'], [3500, '10 Diamond']] as [$cost, $name]) {
            $sku = 'shr-' . uniqid();
            DigitalProduct::create(['provider' => 'digiflazz', 'sku_code' => $sku, 'slug' => $sku, 'name' => $name,
                'digital_product_brand_id' => $this->brand->id, 'cost_price' => $cost, 'is_active' => true]);
        }
    }

    protected function tearDown(): void
    {
        TopupCatalogService::flush();
        parent::tearDown();
    }

    public function test_game_page_has_share_button_with_caption_and_all_targets(): void
    {
        $html = $this->get(route('topup.show', $this->brand->slug))->assertOk()->getContent();
        $url = route('topup.show', $this->brand->slug);

        $this->assertStringContainsString('data-share-button', $html);
        $this->assertStringContainsString('Bagikan ke teman', $html);
        $this->assertStringContainsString('Top up ' . $this->brand->name . ' kini lebih mudah di Scalify.', $html);
        $this->assertStringContainsString('Harga mulai Rp 1.733', $html); // termurah: 1.650 + 5% retail
        $this->assertStringContainsString('x-teleport="body"', $html);    // panel tidak tertutup konten halaman
        $this->assertDoesNotMatchRegularExpression('/[\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}]/u', strip_tags(substr($html, strpos($html, 'data-share-caption'), 600))); // tanpa emoji

        foreach (['whatsapp', 'telegram', 'facebook', 'threads', 'x', 'instagram', 'tiktok', 'copy'] as $target) {
            $this->assertStringContainsString('data-share-target="' . $target . '"', $html, "target $target");
        }
        $this->assertStringContainsString('https://wa.me/?text=', $html);
        $this->assertStringContainsString('https://t.me/share/url?url=' . rawurlencode($url), $html);
        $this->assertStringContainsString('https://www.threads.net/intent/post?text=', $html);
        $this->assertStringContainsString('navigator.share', $html); // lembar berbagi bawaan iPhone/Android

        // Preview link (Open Graph) menyebut harga termurah.
        $this->assertStringContainsString('mulai Rp 1.733. Otomatis 24 jam', $html);
        $this->assertStringNotContainsString('?ref=', $html); // pengunjung biasa: tanpa referral
    }

    public function test_logged_in_partner_shares_link_with_referral_code(): void
    {
        $partner = Affiliate::create([
            'name' => 'Partner Share', 'email' => 'ps_' . uniqid() . '@x.id', 'password' => bcrypt('x'),
            'affiliate_code' => 'SHARE' . rand(1000, 9999), 'status' => 'approved',
        ]);

        $html = $this->actingAs($partner, 'affiliate')->get(route('topup.show', $this->brand->slug))->assertOk()->getContent();

        $this->assertStringContainsString(rawurlencode(route('topup.show', $this->brand->slug) . '?ref=' . $partner->affiliate_code), $html);
    }
}
