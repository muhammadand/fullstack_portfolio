<?php

namespace Tests\Feature;

use App\Mail\TopupOrderStatusMail;
use App\Models\Affiliate;
use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\Order;
use App\Models\PriceLevel;
use App\Models\Wallet;
use App\Services\TopupCatalogService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class PartnerPlnAndGameOrderTest extends TestCase
{
    use DatabaseTransactions;

    protected Affiliate $affiliate;
    protected Wallet $wallet;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.digiflazz.webhook_secret' => '']);
        Mail::fake();
        TopupCatalogService::flush();
        Http::swap(new \Illuminate\Http\Client\Factory());
        Http::fake(['*/transaction' => Http::response(['data' => ['status' => 'Pending', 'rc' => '03', 'sn' => '', 'message' => 'Pending']])]);
        Http::preventStrayRequests();

        $partner = PriceLevel::firstOrCreate(['code' => PriceLevel::PARTNER], ['name' => 'Partner', 'margin_type' => 'percent', 'margin_value' => 2]);
        PriceLevel::firstOrCreate(['code' => PriceLevel::RETAIL], ['name' => 'Retail', 'margin_type' => 'percent', 'margin_value' => 5, 'is_default' => true]);

        $this->affiliate = Affiliate::create([
            'name' => 'Seller', 'email' => 's_' . uniqid() . '@scalify.id', 'password' => bcrypt('password123'),
            'affiliate_code' => 'SL' . rand(10000, 99999), 'status' => 'approved',
        ]);
        $this->affiliate->forceFill(['price_level_id' => $partner->id])->save();
        $this->wallet = $this->affiliate->getOrCreateWallet();
        $this->wallet->forceFill(['balance' => 200000, 'status' => 'active'])->save();
    }

    protected function tearDown(): void
    {
        TopupCatalogService::flush();
        parent::tearDown();
    }

    protected function product(string $catSlug, string $catName, string $brandName, string $name, int $cost, ?string $brandSlug = null): DigitalProduct
    {
        $cat = DigitalProductCategory::firstOrCreate(['slug' => $catSlug], ['name' => $catName]);
        $cat->forceFill(['is_active' => true])->save();
        $brand = DigitalProductBrand::create([
            'digital_product_category_id' => $cat->id, 'name' => $brandName . ' ' . uniqid(),
            'slug' => $brandSlug ?? Str::slug($brandName) . '-' . uniqid(), 'is_active' => true,
        ]);
        $sku = $catSlug . '-' . uniqid();

        return DigitalProduct::create([
            'provider' => 'digiflazz', 'sku_code' => $sku, 'slug' => $sku, 'name' => $name,
            'digital_product_brand_id' => $brand->id, 'cost_price' => $cost, 'is_active' => true,
        ]);
    }

    // --- Token PLN -----------------------------------------------------------------------------------

    public function test_pln_page_asks_for_meter_number_without_operator_detection(): void
    {
        $this->product('pln', 'PLN', 'PLN', 'PLN 20.000', 20000);

        $this->actingAs($this->affiliate, 'affiliate')->get(route('affiliate.ppob.pln'))
            ->assertOk()->assertSee('Token PLN')->assertSee('Nomor Meter / ID Pelanggan')
            ->assertSee('PLN 20.000')->assertDontSee('Cek operator dari nomor HP');
    }

    public function test_pln_order_keeps_meter_number_and_shows_token_on_success(): void
    {
        $product = $this->product('pln', 'PLN', 'PLN', 'PLN 20.000', 20000);

        // Nomor meter diawali 8/62 tidak boleh diubah jadi format HP 08xx.
        $this->actingAs($this->affiliate, 'affiliate')->post(route('affiliate.ppob.pln.order'), [
            'product_id' => $product->id, 'customer_no' => '8123 4567 8901', 'idempotency_key' => (string) Str::uuid(),
        ])->assertRedirect();

        $order = Order::where('affiliate_id', $this->affiliate->id)->latest('id')->firstOrFail();
        $this->assertSame('812345678901', $order->customer_no);
        $this->assertSame(Order::SOURCE_PLN, $order->source);
        $this->assertStringStartsWith('PLN-', $order->order_no);
        $this->assertEquals(200000 - 20400, (float) $this->wallet->fresh()->balance);

        $this->postJson('/api/digiflazz/webhook', ['data' => [
            'ref_id' => $order->order_no, 'buyer_sku_code' => $order->sku_code, 'status' => 'Sukses', 'rc' => '00',
            'message' => 'Sukses', 'sn' => '1234-5678-9012-3456-7890/BUDI/R1/900VA/14,5',
        ]])->assertOk();

        $this->actingAs($this->affiliate, 'affiliate')->get(route('affiliate.ppob.orders.show', $order->order_no))
            ->assertOk()->assertSee('Token Listrik')->assertSee('1234-5678-9012-3456-7890', false)->assertSee('Nomor Meter');
    }

    // --- Top up game ---------------------------------------------------------------------------------

    public function test_game_list_and_detail_show_partner_price_and_account_fields(): void
    {
        $product = $this->product('games', 'Games', 'Mobile Legends', '86 Diamond', 20000, 'ml-' . uniqid());
        $slug = $product->brand->slug;

        $this->actingAs($this->affiliate, 'affiliate')->get(route('affiliate.ppob.games'))
            ->assertOk()->assertSee('Top Up Game')->assertSee(route('affiliate.ppob.game', $slug), false);

        $this->actingAs($this->affiliate, 'affiliate')->get(route('affiliate.ppob.game', $slug))
            ->assertOk()->assertSee('86 Diamond')->assertSee('User ID')->assertSee('Zone ID')
            ->assertSee('Rp 20.400'); // modal + 2% (partner)
    }

    public function test_game_order_saves_account_and_debits_wallet(): void
    {
        $product = $this->product('games', 'Games', 'Mobile Legends', '86 Diamond', 20000, 'ml-' . uniqid());

        $this->actingAs($this->affiliate, 'affiliate')->post(route('affiliate.ppob.game.order', $product->brand->slug), [
            'product_id' => $product->id, 'account' => ['user_id' => '12345678', 'zone_id' => '1234'], 'idempotency_key' => (string) Str::uuid(),
        ])->assertRedirect();

        $order = Order::where('affiliate_id', $this->affiliate->id)->latest('id')->firstOrFail();
        $this->assertSame(Order::SOURCE_TOPUP_GAME, $order->source);
        $this->assertSame(Order::PAYMENT_METHOD_WALLET, $order->payment_method);
        $this->assertSame('123456781234', $order->customer_no);
        $this->assertSame(['user_id' => '12345678', 'zone_id' => '1234'], $order->account_data);
        $this->assertEquals(200000 - 20400, (float) $this->wallet->fresh()->balance);
        Http::assertSent(fn ($r) => str_contains($r->url(), '/transaction') && $r['customer_no'] === '123456781234');

        $this->actingAs($this->affiliate, 'affiliate')->get(route('affiliate.ppob.orders.show', $order->order_no))
            ->assertOk()->assertSee('User Id')->assertSee('12345678')->assertSee(route('affiliate.ppob.games'), false);
    }

    public function test_game_order_rejects_invalid_id_and_product_from_other_game(): void
    {
        $ml = $this->product('games', 'Games', 'Mobile Legends', '86 Diamond', 20000, 'ml-' . uniqid());
        $other = $this->product('games', 'Games', 'Free Fire', '100 Diamond', 15000, 'ff-' . uniqid());
        $as = $this->actingAs($this->affiliate, 'affiliate');

        $as->post(route('affiliate.ppob.game.order', $ml->brand->slug), [
            'product_id' => $ml->id, 'account' => ['user_id' => '12345678', 'zone_id' => 'abc'], 'idempotency_key' => (string) Str::uuid(),
        ])->assertSessionHasErrors('account.zone_id');

        $as->post(route('affiliate.ppob.game.order', $ml->brand->slug), [
            'product_id' => $other->id, 'account' => ['user_id' => '12345678', 'zone_id' => '1234'], 'idempotency_key' => (string) Str::uuid(),
        ])->assertSessionHas('error', 'Nominal tidak tersedia, silakan pilih yang lain.');

        $this->assertSame(0, Order::where('affiliate_id', $this->affiliate->id)->count());
        $this->assertEquals(200000, (float) $this->wallet->fresh()->balance);
    }

    public function test_failed_game_order_is_refunded_and_email_links_to_game_page(): void
    {
        $product = $this->product('games', 'Games', 'Mobile Legends', '86 Diamond', 20000, 'ml-' . uniqid());
        $this->actingAs($this->affiliate, 'affiliate')->post(route('affiliate.ppob.game.order', $product->brand->slug), [
            'product_id' => $product->id, 'account' => ['user_id' => '12345678', 'zone_id' => '1234'], 'idempotency_key' => (string) Str::uuid(),
        ]);
        $order = Order::where('affiliate_id', $this->affiliate->id)->latest('id')->firstOrFail();

        $this->postJson('/api/digiflazz/webhook', ['data' => [
            'ref_id' => $order->order_no, 'buyer_sku_code' => $order->sku_code, 'status' => 'Gagal', 'rc' => '40', 'message' => 'Gagal', 'sn' => '',
        ]])->assertOk();

        $this->assertNotNull($order->fresh()->refunded_at);
        $this->assertEquals(200000, (float) $this->wallet->fresh()->balance);
        Mail::assertSent(TopupOrderStatusMail::class, fn ($m) => $m->event === 'failed' && $m->meta()['cta_url'] === route('affiliate.ppob.games'));
    }
}
