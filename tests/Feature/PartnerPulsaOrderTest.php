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
use App\Models\WalletMutation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class PartnerPulsaOrderTest extends TestCase
{
    use DatabaseTransactions;

    protected Affiliate $affiliate;
    protected Wallet $wallet;
    protected DigitalProduct $product;
    protected float $price;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.digiflazz.webhook_secret' => '']);
        Mail::fake();
        $this->fakeDigiflazz('Pending');

        $partner = PriceLevel::firstOrCreate(
            ['code' => PriceLevel::PARTNER],
            ['name' => 'Partner (Scalify)', 'margin_type' => 'percent', 'margin_value' => 2]
        );
        PriceLevel::firstOrCreate(
            ['code' => PriceLevel::RETAIL],
            ['name' => 'Retail', 'margin_type' => 'percent', 'margin_value' => 5, 'is_default' => true]
        );

        $this->affiliate = Affiliate::firstOrCreate(
            ['email' => 'pulsa_buyer@scalify.id'],
            ['name' => 'Pulsa Buyer', 'password' => bcrypt('password123'), 'affiliate_code' => 'PBUY' . rand(100, 999), 'status' => 'approved']
        );
        $this->affiliate->forceFill(['status' => 'approved', 'price_level_id' => $partner->id])->save();

        $this->wallet = $this->affiliate->getOrCreateWallet();
        $this->wallet->forceFill(['balance' => 50000, 'status' => 'active'])->save();

        $category = DigitalProductCategory::firstOrCreate(['slug' => 'pulsa'], ['name' => 'Pulsa']);
        $category->forceFill(['is_active' => true])->save();
        $brand = DigitalProductBrand::create([
            'digital_product_category_id' => $category->id,
            'name' => 'Telkomsel Test ' . uniqid(), // unik: DB lokal bisa sudah punya brand Telkomsel
            'slug' => 'pulsa-telkomsel-' . uniqid(),
            'is_active' => true,
        ]);
        $sku = 'tsel5-' . uniqid();
        $this->product = DigitalProduct::create([
            'provider' => 'digiflazz', 'sku_code' => $sku, 'slug' => $sku, 'name' => 'Telkomsel 5.000',
            'digital_product_brand_id' => $brand->id, 'cost_price' => 5100, 'is_active' => true,
        ]);
        $this->price = $partner->applyMargin(5100);
    }

    protected function fakeDigiflazz(string $status): void
    {
        Http::swap(new \Illuminate\Http\Client\Factory());
        Http::fake(['*/transaction' => Http::response(['data' => [
            'ref_id' => 'x', 'status' => $status, 'rc' => '03', 'sn' => '', 'message' => "Transaksi $status",
        ]])]);
        Http::preventStrayRequests();
    }

    protected function order(array $over = [])
    {
        return $this->actingAs($this->affiliate, 'affiliate')->post(route('affiliate.ppob.pulsa.order'), array_merge([
            'product_id' => $this->product->id,
            'customer_no' => '+62 812-3456-7890',
            'idempotency_key' => (string) Str::uuid(),
        ], $over));
    }

    protected function digiflazzWebhook(string $refId, string $status)
    {
        return $this->postJson('/api/digiflazz/webhook', ['data' => [
            'ref_id' => $refId, 'status' => $status, 'rc' => $status === 'Sukses' ? '00' : '40',
            'sn' => $status === 'Sukses' ? 'SN-PULSA' : '', 'message' => "Transaksi $status",
            'buyer_sku_code' => $this->product->sku_code, 'customer_no' => '081234567890',
        ]]);
    }

    protected function latestOrder(): Order
    {
        return Order::where('affiliate_id', $this->affiliate->id)->latest('id')->firstOrFail();
    }

    public function test_checkout_debits_wallet_saves_order_and_sends_to_digiflazz(): void
    {
        $response = $this->order();
        $order = $this->latestOrder();

        $response->assertRedirect(route('affiliate.ppob.orders.show', $order->order_no));
        $this->assertStringStartsWith('PL-', $order->order_no);
        $this->assertSame(Order::SOURCE_PULSA, $order->source);
        $this->assertSame(Order::PAYMENT_METHOD_WALLET, $order->payment_method);
        $this->assertSame(Order::PAYMENT_PAID, $order->payment_status);
        $this->assertSame(Order::STATUS_PROCESSING, $order->status);
        $this->assertSame('081234567890', $order->customer_no);
        $this->assertEquals($this->price, (float) $order->total_amount);
        $this->assertSame($order->order_no, $order->provider_ref_id);

        $this->assertEquals(50000 - $this->price, (float) $this->wallet->fresh()->balance);
        $debit = WalletMutation::where('reference_type', Order::class)->where('reference_id', $order->id)->sole();
        $this->assertSame('DEBIT', $debit->type);
        $this->assertSame('PPOB_ORDER', $debit->category);
        $this->assertSame($debit->mutation_no, $order->payment_reference);

        // Format kirim sama dengan top up: buyer_sku_code, customer_no, ref_id = order_no.
        Http::assertSent(fn ($r) => str_contains($r->url(), '/transaction')
            && $r['buyer_sku_code'] === $this->product->sku_code
            && $r['customer_no'] === '081234567890'
            && $r['ref_id'] === $order->order_no);

        $this->assertSame(
            [OrderEvent::ORDER_CREATED, OrderEvent::WALLET_DEBITED, OrderEvent::PROVIDER_SENT],
            $order->events()->pluck('event')->all()
        );
        $created = $order->events()->first();
        $this->assertSame(OrderEvent::ACTOR_AFFILIATE, $created->actor_type);
        $this->assertSame($this->affiliate->id, $created->actor_id);
        $this->assertNotNull($created->ip_address);
        $this->assertTrue(OrderEvent::verifyChain($order->id));

        $this->get(route('affiliate.ppob.orders.show', $order->order_no))
            ->assertOk()->assertSee('Sedang Diproses')->assertSee($order->order_no);
    }

    public function test_insufficient_balance_creates_no_order(): void
    {
        $this->wallet->forceFill(['balance' => 1000])->save();

        $this->order()->assertRedirect()->assertSessionHas('error', 'Saldo tidak cukup. Isi saldo dulu ya.');

        $this->assertSame(0, Order::where('affiliate_id', $this->affiliate->id)->count());
        $this->assertEquals(1000, (float) $this->wallet->fresh()->balance);
        Http::assertNothingSent();
    }

    public function test_double_submit_with_same_key_creates_one_order_and_one_debit(): void
    {
        $key = (string) Str::uuid();
        $this->order(['idempotency_key' => $key]);
        $this->order(['idempotency_key' => $key]);

        $this->assertSame(1, Order::where('affiliate_id', $this->affiliate->id)->count());
        $this->assertEquals(50000 - $this->price, (float) $this->wallet->fresh()->balance);
    }

    public function test_number_from_other_operator_is_not_blocked(): void
    {
        $this->order(['customer_no' => '085712345678'])->assertSessionMissing('error');

        $this->assertSame('085712345678', $this->latestOrder()->customer_no);
    }

    public function test_success_webhook_completes_order_and_sends_email_without_refund(): void
    {
        $this->order();
        $order = $this->latestOrder();

        $this->digiflazzWebhook($order->order_no, 'Sukses')->assertOk();
        $order->refresh();

        $this->assertSame(Order::STATUS_SUCCESS, $order->status);
        $this->assertSame('SN-PULSA', $order->sn);
        $this->assertNull($order->refunded_at);
        $this->assertEquals(50000 - $this->price, (float) $this->wallet->fresh()->balance);

        Mail::assertSent(TopupOrderStatusMail::class, fn ($m) => $m->event === 'success'
            && $m->hasTo('pulsa_buyer@scalify.id')
            && $m->meta()['title'] === 'Pulsa Berhasil');
        $this->assertContains(OrderEvent::NOTIFICATION_SENT, $order->events()->pluck('event')->all());
        $this->assertTrue(OrderEvent::verifyChain($order->id));
    }

    public function test_failed_webhook_refunds_wallet_once_and_records_history(): void
    {
        $this->order();
        $order = $this->latestOrder();

        $this->digiflazzWebhook($order->order_no, 'Gagal')->assertOk();
        $this->digiflazzWebhook($order->order_no, 'Gagal')->assertOk(); // webhook ulang tidak boleh refund lagi
        $order->refresh();

        $this->assertSame(Order::STATUS_FAILED, $order->status);
        $this->assertNotNull($order->refunded_at);
        $this->assertEquals(50000, (float) $this->wallet->fresh()->balance);

        $mutations = WalletMutation::where('reference_type', Order::class)->where('reference_id', $order->id)->orderBy('id')->get();
        $this->assertSame(['DEBIT', 'CREDIT'], $mutations->pluck('type')->all());
        $this->assertSame('PPOB_REFUND', $mutations[1]->category);

        $events = $order->events()->get();
        $this->assertSame(1, $events->where('event', OrderEvent::WALLET_REFUNDED)->count());
        $refund = $events->firstWhere('event', OrderEvent::WALLET_REFUNDED);
        $this->assertSame($mutations[1]->id, $refund->wallet_mutation_id);
        $this->assertSame(OrderEvent::ACTOR_DIGIFLAZZ, $refund->actor_type);
        $this->assertTrue(OrderEvent::verifyChain($order->id));

        Mail::assertSent(TopupOrderStatusMail::class, 1);
        Mail::assertSent(TopupOrderStatusMail::class, fn ($m) => $m->event === 'failed'
            && str_contains($m->meta()['message'], 'sudah dikembalikan'));

        $this->actingAs($this->affiliate, 'affiliate')
            ->get(route('affiliate.ppob.orders.show', $order->order_no))
            ->assertOk()->assertSee('sudah dikembalikan ke wallet');
    }

    public function test_audit_log_is_append_only_and_tampering_is_detected(): void
    {
        $this->order();
        $order = $this->latestOrder();
        $event = $order->events()->first();

        try {
            $event->update(['amount' => 1]);
            $this->fail('Update OrderEvent seharusnya ditolak.');
        } catch (\LogicException) {
        }

        try {
            $event->delete();
            $this->fail('Delete OrderEvent seharusnya ditolak.');
        } catch (\LogicException) {
        }

        DB::table('order_events')->where('id', $event->id)->update(['amount' => 1]);
        $this->assertFalse(OrderEvent::verifyChain($order->id));
    }

    public function test_partner_cannot_view_other_partners_order(): void
    {
        $this->order();
        $order = $this->latestOrder();

        $other = Affiliate::create([
            'name' => 'Other', 'email' => 'other_' . uniqid() . '@scalify.id', 'password' => bcrypt('x'),
            'affiliate_code' => 'OTH' . rand(1000, 9999), 'status' => 'approved',
        ]);

        $this->actingAs($other, 'affiliate')
            ->get(route('affiliate.ppob.orders.show', $order->order_no))
            ->assertNotFound();
    }
}
