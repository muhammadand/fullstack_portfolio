<?php

namespace Tests\Feature;

use App\Mail\TopupOrderStatusMail;
use App\Models\Affiliate;
use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\PriceLevel;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class PartnerPaketDataOrderTest extends TestCase
{
    use DatabaseTransactions;

    protected Affiliate $affiliate;
    protected Wallet $wallet;
    protected DigitalProduct $dataProduct;
    protected DigitalProduct $pulsaProduct;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.digiflazz.webhook_secret' => '']);
        Mail::fake();
        Http::swap(new \Illuminate\Http\Client\Factory());
        Http::fake(['*/transaction' => Http::response(['data' => ['status' => 'Pending', 'rc' => '03', 'sn' => '', 'message' => 'Pending']])]);
        Http::preventStrayRequests();

        $partner = PriceLevel::firstOrCreate(['code' => PriceLevel::PARTNER], ['name' => 'Partner', 'margin_type' => 'percent', 'margin_value' => 2]);
        PriceLevel::firstOrCreate(['code' => PriceLevel::RETAIL], ['name' => 'Retail', 'margin_type' => 'percent', 'margin_value' => 5, 'is_default' => true]);

        $this->affiliate = Affiliate::create([
            'name' => 'Data Seller', 'email' => 'data_' . uniqid() . '@scalify.id', 'password' => bcrypt('password123'),
            'affiliate_code' => 'DATA' . rand(1000, 9999), 'status' => 'approved',
        ]);
        $this->affiliate->forceFill(['price_level_id' => $partner->id])->save();
        $this->wallet = $this->affiliate->getOrCreateWallet();
        $this->wallet->forceFill(['balance' => 100000, 'status' => 'active'])->save();

        $this->dataProduct = $this->product('data', 'Data', 'Telkomsel Data 10GB', 'Kuota 10GB berlaku 30 hari', 25000);
        $this->pulsaProduct = $this->product('pulsa', 'Pulsa', 'Telkomsel 10.000', null, 10100);
    }

    protected function product(string $slug, string $catName, string $name, ?string $desc, int $cost): DigitalProduct
    {
        $cat = DigitalProductCategory::firstOrCreate(['slug' => $slug], ['name' => $catName]);
        $cat->forceFill(['is_active' => true])->save();
        $brand = DigitalProductBrand::create([
            'digital_product_category_id' => $cat->id, 'name' => 'Telkomsel ' . uniqid(), 'slug' => $slug . '-tsel-' . uniqid(), 'is_active' => true,
        ]);
        $sku = $slug . '-' . uniqid();

        return DigitalProduct::create([
            'provider' => 'digiflazz', 'sku_code' => $sku, 'slug' => $sku, 'name' => $name, 'description' => $desc,
            'digital_product_brand_id' => $brand->id, 'cost_price' => $cost, 'is_active' => true,
        ]);
    }

    protected function order(array $over = [])
    {
        return $this->actingAs($this->affiliate, 'affiliate')->post(route('affiliate.ppob.paket_data.order'), array_merge([
            'product_id' => $this->dataProduct->id, 'customer_no' => '081234567890', 'idempotency_key' => (string) Str::uuid(),
        ], $over));
    }

    public function test_page_lists_data_products_with_description_and_partner_price(): void
    {
        $this->actingAs($this->affiliate, 'affiliate')->get(route('affiliate.ppob.paket_data'))
            ->assertOk()
            ->assertSee('Paket Data')
            ->assertSee('Telkomsel Data 10GB')
            ->assertSee('Kuota 10GB berlaku 30 hari')
            ->assertSee('Rp 25.500')                       // harga partner = modal + 2%
            ->assertSee(route('affiliate.ppob.paket_data.order'), false)
            ->assertDontSee('Telkomsel 10.000');           // produk pulsa tidak ikut tampil
    }

    public function test_checkout_creates_paket_data_order_and_debits_wallet(): void
    {
        $this->order()->assertRedirect();
        $order = Order::where('affiliate_id', $this->affiliate->id)->latest('id')->firstOrFail();

        $this->assertSame(Order::SOURCE_PAKET_DATA, $order->source);
        $this->assertStringStartsWith('PL-', $order->order_no);
        $this->assertEquals(25500, (float) $order->total_amount);
        $this->assertEquals(100000 - 25500, (float) $this->wallet->fresh()->balance);
        Http::assertSent(fn ($r) => str_contains($r->url(), '/transaction') && $r['buyer_sku_code'] === $this->dataProduct->sku_code);
        $this->assertTrue(OrderEvent::verifyChain($order->id));

        $this->actingAs($this->affiliate, 'affiliate')->get(route('affiliate.ppob.orders.show', $order->order_no))
            ->assertOk()->assertSee(route('affiliate.ppob.paket_data'), false);
    }

    public function test_pulsa_product_cannot_be_bought_from_paket_data_endpoint(): void
    {
        $this->order(['product_id' => $this->pulsaProduct->id])->assertSessionHas('error', 'Produk tidak ditemukan atau sedang tidak dijual.');

        $this->assertSame(0, Order::where('affiliate_id', $this->affiliate->id)->count());
        $this->assertEquals(100000, (float) $this->wallet->fresh()->balance);
    }

    public function test_failed_data_order_is_refunded_and_email_links_back_to_paket_data(): void
    {
        $this->order();
        $order = Order::where('affiliate_id', $this->affiliate->id)->latest('id')->firstOrFail();

        $this->postJson('/api/digiflazz/webhook', ['data' => [
            'ref_id' => $order->order_no, 'buyer_sku_code' => $order->sku_code, 'status' => 'Gagal', 'rc' => '40', 'message' => 'Gagal', 'sn' => '',
        ]])->assertOk();

        $this->assertNotNull($order->fresh()->refunded_at);
        $this->assertEquals(100000, (float) $this->wallet->fresh()->balance);
        Mail::assertSent(TopupOrderStatusMail::class, fn ($m) => $m->event === 'failed'
            && str_starts_with($m->meta()['title'], 'Paket Data Gagal')
            && $m->meta()['cta_url'] === route('affiliate.ppob.paket_data'));
    }

    public function test_guest_is_redirected(): void
    {
        $this->get(route('affiliate.ppob.paket_data'))->assertRedirect(route('affiliate.login'));
    }
}
