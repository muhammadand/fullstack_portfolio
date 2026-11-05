<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\Order;
use App\Services\TopupCatalogService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TopupCheckoutTest extends TestCase
{
    use DatabaseTransactions;

    protected DigitalProductBrand $brand;
    protected DigitalProduct $product;

    protected function setUp(): void
    {
        parent::setUp();
        TopupCatalogService::flush();
        $this->fakeGateway();

        $cat = DigitalProductCategory::firstOrCreate(['slug' => 'games'], ['name' => 'Games']);
        $this->brand = DigitalProductBrand::create([
            'digital_product_category_id' => $cat->id,
            'name' => 'Mobile Legends Test ' . uniqid(),
            'slug' => 'ml-' . uniqid(),
        ]);
        $sku = 'ck-' . uniqid();
        $this->product = DigitalProduct::create([
            'provider' => 'digiflazz', 'sku_code' => $sku, 'slug' => $sku, 'name' => '86 Diamond',
            'digital_product_brand_id' => $this->brand->id, 'cost_price' => 20000, 'is_active' => true,
        ]);
    }

    protected function fakeGateway(bool $ok = true): void
    {
        Http::swap(new \Illuminate\Http\Client\Factory());
        Http::fake(['*/payments/charge' => $ok
            ? Http::response(['data' => [
                'transaction_id' => 'trx-123', 'status' => 'pending',
                'payment_details' => ['actions' => [['name' => 'generate-qr-code', 'url' => 'https://qr.test/abc.png']]],
            ]])
            : Http::response(['message' => 'Gateway down'], 500)]);
    }

    protected function webhook(string $orderNo, string $status, $amount = null)
    {
        return $this->postJson('/api/webhook/payment', array_filter([
            'order_id' => $orderNo, 'transaction_id' => 'trx-123', 'transaction_status' => $status, 'gross_amount' => $amount,
        ], fn ($v) => $v !== null));
    }

    protected function payload(array $over = []): array
    {
        return $over + [
            'product_id' => $this->product->id,
            'account' => ['user_id' => '12345678', 'zone_id' => '1234'],
            'email' => 'Budi@Example.com',
            'note' => 'cepat ya',
        ];
    }

    public function test_checkout_saves_pending_order_with_email_and_server_side_price(): void
    {
        $res = $this->postJson(route('topup.checkout', $this->brand->slug), $this->payload(['price' => 1]))
            ->assertCreated();

        $order = Order::where('order_no', $res->json('order_no'))->firstOrFail();

        $this->assertSame('budi@example.com', $order->email);
        $this->assertSame('123456781234', $order->customer_no);
        $this->assertSame(['user_id' => '12345678', 'zone_id' => '1234'], $order->account_data);
        $this->assertSame(Order::STATUS_PENDING, $order->status);
        $this->assertSame(Order::PAYMENT_UNPAID, $order->payment_status);
        $this->assertSame('86 Diamond', $order->product_name);
        $this->assertGreaterThan(1, (float) $order->total_amount); // harga klien diabaikan
        $this->assertNull($order->customer_id);
        $this->assertSame('https://qr.test/abc.png', $res->json('qr_url'));
        $this->assertSame('trx-123', $order->payment_reference);
        $this->assertNotNull($order->expires_at);
        Http::assertSent(fn ($r) => $r['payment_type'] === 'qris' && $r['qris']['acquirer'] === 'gopay' && $r['order_id'] === $order->order_no);
    }

    public function test_failed_charge_deletes_guest_order_but_keeps_failed_record_for_customer(): void
    {
        $this->fakeGateway(false);
        $before = Order::withTrashed()->count();

        $this->postJson(route('topup.checkout', $this->brand->slug), $this->payload())->assertStatus(422);
        $this->assertSame($before, Order::withTrashed()->count());

        $c = Customer::create(['name' => 'Rina', 'email' => 'f_' . uniqid() . '@example.com', 'password' => 'secret123']);
        $this->actingAs($c, 'customer')->postJson(route('topup.checkout', $this->brand->slug), $this->payload())->assertStatus(422);
        $this->assertSame(Order::PAYMENT_FAILED, $c->orders()->first()->payment_status);
    }

    public function test_webhook_marks_order_paid_idempotently_and_status_endpoint_reflects_it(): void
    {
        $no = $this->postJson(route('topup.checkout', $this->brand->slug), $this->payload())->json('order_no');

        $this->getJson(route('topup.order.status', $no))->assertOk()->assertJson(['is_paid' => false]);

        $this->webhook($no, 'settlement')->assertOk();
        $this->webhook($no, 'settlement')->assertOk();

        $order = Order::where('order_no', $no)->first();
        $this->assertSame(Order::PAYMENT_PAID, $order->payment_status);
        $this->assertSame(Order::STATUS_PROCESSING, $order->status);
        $this->assertNotNull($order->paid_at);

        $this->getJson(route('topup.order.status', $no))->assertJson(['is_paid' => true, 'email' => 'b***@example.com']);
    }

    public function test_webhook_with_wrong_amount_does_not_mark_paid_and_expire_works(): void
    {
        $no = $this->postJson(route('topup.checkout', $this->brand->slug), $this->payload())->json('order_no');

        $this->webhook($no, 'settlement', 100)->assertOk();
        $this->assertSame(Order::PAYMENT_UNPAID, Order::where('order_no', $no)->first()->payment_status);

        $this->webhook($no, 'expire')->assertOk();
        $this->assertSame(Order::PAYMENT_EXPIRED, Order::where('order_no', $no)->first()->payment_status);
    }

    public function test_email_is_optional(): void
    {
        $res = $this->postJson(route('topup.checkout', $this->brand->slug), $this->payload(['email' => null]))
            ->assertCreated();

        $this->assertNull(Order::where('order_no', $res->json('order_no'))->first()->email);
    }

    public function test_logged_in_customer_is_attached_to_order(): void
    {
        $c = Customer::create(['name' => 'Siti', 'email' => 'o_' . uniqid() . '@example.com', 'password' => 'secret123']);

        $res = $this->actingAs($c, 'customer')
            ->postJson(route('topup.checkout', $this->brand->slug), $this->payload())->assertCreated();

        $this->assertSame($c->id, Order::where('order_no', $res->json('order_no'))->first()->customer_id);
    }

    public function test_validation_rejects_bad_email_bad_id_and_unknown_product(): void
    {
        $url = route('topup.checkout', $this->brand->slug);

        $this->postJson($url, $this->payload(['email' => 'bukan-email']))->assertJsonValidationErrors('email');
        $this->postJson($url, $this->payload(['account' => ['user_id' => 'abc', 'zone_id' => '1234']]))
            ->assertJsonValidationErrors('account.user_id');
        $this->postJson($url, $this->payload(['product_id' => 999999]))->assertJsonValidationErrors('product_id');
    }

    public function test_unknown_game_returns_404_and_form_shows_email_field(): void
    {
        $this->postJson(route('topup.checkout', 'tidak-ada'), $this->payload())->assertNotFound();

        $this->get(route('topup.show', $this->brand->slug))
            ->assertOk()->assertSee('Email Struk', false);
    }
}
