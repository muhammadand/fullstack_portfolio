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
        config(['services.digiflazz.webhook_secret' => '']); // .env lokal bisa berisi secret; tes tanda tangan mengaturnya sendiri
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
        Http::fake([
            '*/payments/charge' => $ok
                ? Http::response(['data' => [
                    'transaction_id' => 'trx-123', 'status' => 'pending',
                    'payment_details' => ['actions' => [['name' => 'generate-qr-code', 'url' => 'https://qr.test/abc.png']]],
                ]])
                : Http::response(['message' => 'Gateway down'], 500),
            // Webhook lunas akan memanggil Digiflazz: tes tidak boleh menembak API sungguhan.
            '*/transaction' => Http::response(['data' => ['status' => 'Sukses', 'sn' => 'SN-DEFAULT', 'message' => 'ok']]),
        ]);
        Http::preventStrayRequests();
    }

    protected function fakeDigiflazz(string $status = 'Sukses', string $sn = 'SN-123456'): void
    {
        Http::swap(new \Illuminate\Http\Client\Factory());
        Http::fake([
            '*/payments/charge' => Http::response(['data' => [
                'transaction_id' => 'trx-123', 'status' => 'pending',
                'payment_details' => ['actions' => [['name' => 'generate-qr-code', 'url' => 'https://qr.test/abc.png']]],
            ]]),
            '*/transaction' => Http::response(['data' => [
                'ref_id' => 'x', 'status' => $status, 'rc' => $status === 'Sukses' ? '00' : '03', 'sn' => $sn, 'message' => "Transaksi $status",
            ]]),
        ]);
    }

    protected function paidOrderNo(): string
    {
        $no = $this->postJson(route('topup.checkout', $this->brand->slug), $this->payload())->json('order_no');
        $this->webhook($no, 'settlement')->assertOk();

        return $no;
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
        $this->assertSame(Order::STATUS_PROCESSING, $order->status); // lunas -> dikirim ke Digiflazz, hasil akhir lewat webhook Digiflazz
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

    public function test_webhook_paid_sends_once_to_digiflazz_and_polling_status_never_does(): void
    {
        $this->fakeDigiflazz('Sukses');
        $no = $this->postJson(route('topup.checkout', $this->brand->slug), $this->payload())->json('order_no');

        $this->getJson(route('topup.order.status', $no))->assertOk();
        Http::assertNotSent(fn ($r) => str_contains($r->url(), '/transaction')); // belum lunas

        $this->webhook($no, 'settlement')->assertOk();
        $this->webhook($no, 'settlement')->assertOk(); // webhook diulang gateway
        $this->getJson(route('topup.order.status', $no))->assertOk()->assertJson(['is_paid' => true]);
        $this->getJson(route('topup.order.status', $no))->assertOk();

        Http::assertSentCount(2); // 1x charge QRIS + tepat 1x transaction Digiflazz
    }

    protected function digiflazzWebhook(string $refId, string $status, array $over = [])
    {
        return $this->postJson('/api/digiflazz/webhook', ['data' => array_merge([
            'ref_id' => $refId, 'status' => $status, 'rc' => $status === 'Sukses' ? '00' : ($status === 'Pending' ? '03' : '40'),
            'sn' => $status === 'Sukses' ? 'SN-FINAL' : '', 'message' => "Transaksi $status",
            'buyer_sku_code' => $this->product->sku_code, 'customer_no' => '123456781234',
        ], $over)]);
    }

    public function test_digiflazz_payload_uses_sku_code_customer_no_and_order_no_and_status_stays_processing(): void
    {
        $this->fakeDigiflazz('Sukses', 'SN-777'); // balasan langsung dari transaction
        $no = $this->paidOrderNo();

        Http::assertSent(fn ($r) => str_contains($r->url(), '/transaction')
            && $r['buyer_sku_code'] === $this->product->sku_code
            && $r['customer_no'] === '123456781234'
            && $r['ref_id'] === $no);

        // Status BUKAN dari balasan langsung: tetap processing sampai webhook Digiflazz datang.
        $order = Order::where('order_no', $no)->first();
        $this->assertSame(Order::STATUS_PROCESSING, $order->status);
        $this->assertSame('SN-777', $order->sn);
        $this->assertSame($no, $order->provider_ref_id);
        $this->assertNull($order->completed_at);
        $this->assertSame(Order::PAYMENT_PAID, $order->payment_status);
    }

    public function test_digiflazz_webhook_sets_final_status_success_failed_and_pending(): void
    {
        $this->fakeDigiflazz('Pending', '');
        $ok = $this->paidOrderNo();
        $bad = $this->paidOrderNo();
        $wait = $this->paidOrderNo();

        $this->digiflazzWebhook($wait, 'Pending')->assertOk();
        $this->assertSame(Order::STATUS_PROCESSING, Order::where('order_no', $wait)->first()->status);

        $this->digiflazzWebhook($ok, 'Sukses')->assertOk();
        $o = Order::where('order_no', $ok)->first();
        $this->assertSame(Order::STATUS_SUCCESS, $o->status);
        $this->assertSame('SN-FINAL', $o->sn);
        $this->assertNotNull($o->completed_at);

        $this->digiflazzWebhook($bad, 'Gagal')->assertOk();
        $f = Order::where('order_no', $bad)->first();
        $this->assertSame(Order::STATUS_FAILED, $f->status);
        $this->assertSame(Order::PAYMENT_PAID, $f->payment_status);

        $this->assertTrue(\App\Models\DigiflazzWebhook::where('ref_id', $ok)->latest('id')->first()->is_processed);
    }

    public function test_final_status_is_not_overwritten_by_late_or_duplicate_webhooks(): void
    {
        $this->fakeDigiflazz('Pending', '');
        $no = $this->paidOrderNo();

        $this->digiflazzWebhook($no, 'Sukses')->assertOk();
        $this->digiflazzWebhook($no, 'Gagal')->assertOk();   // terlambat/salah urutan
        $this->digiflazzWebhook($no, 'Pending')->assertOk();

        $this->assertSame(Order::STATUS_SUCCESS, Order::where('order_no', $no)->first()->status);
    }

    public function test_digiflazz_webhook_ignores_unpaid_orders_other_modules_pings_and_sku_mismatch(): void
    {
        $this->fakeDigiflazz('Pending', '');
        $unpaid = $this->postJson(route('topup.checkout', $this->brand->slug), $this->payload())->json('order_no');
        $this->digiflazzWebhook($unpaid, 'Sukses')->assertOk();
        $this->assertSame(Order::STATUS_PENDING, Order::where('order_no', $unpaid)->first()->status);

        $this->digiflazzWebhook('GRC-XYZ', 'Sukses')->assertOk();
        $this->postJson('/api/digiflazz/webhook', ['hook_id' => 'abc'])->assertOk();

        $paid = $this->paidOrderNo();
        $this->digiflazzWebhook($paid, 'Sukses', ['buyer_sku_code' => 'sku-lain'])->assertOk();
        $this->assertSame(Order::STATUS_PROCESSING, Order::where('order_no', $paid)->first()->status);
    }

    public function test_digiflazz_webhook_requires_valid_signature_when_secret_is_set(): void
    {
        config(['services.digiflazz.webhook_secret' => 'rahasia']);
        $this->fakeDigiflazz('Pending', '');
        $no = $this->paidOrderNo();

        $this->digiflazzWebhook($no, 'Sukses')->assertOk(); // tanpa signature
        $this->assertSame(Order::STATUS_PROCESSING, Order::where('order_no', $no)->first()->status);

        $body = json_encode(['data' => ['ref_id' => $no, 'status' => 'Sukses', 'sn' => 'SN-SIGNED', 'buyer_sku_code' => $this->product->sku_code]]);
        $sig = 'sha1=' . hash_hmac('sha1', $body, 'rahasia');
        $this->call('POST', '/api/digiflazz/webhook', [], [], [], [
            'CONTENT_TYPE' => 'application/json', 'HTTP_X_HUB_SIGNATURE' => $sig, 'HTTP_ACCEPT' => 'application/json',
        ], $body)->assertOk();

        $this->assertSame(Order::STATUS_SUCCESS, Order::where('order_no', $no)->first()->status);
    }

    public function test_unreadable_reply_releases_claim_and_repeated_webhook_retries(): void
    {
        $this->fakeDigiflazz('Sukses');
        $no = $this->postJson(route('topup.checkout', $this->brand->slug), $this->payload())->json('order_no');

        // Balasan Digiflazz tidak valid saat webhook pertama.
        Http::swap(new \Illuminate\Http\Client\Factory());
        Http::fake(['*/transaction' => Http::response('gateway error', 502)]);
        Http::preventStrayRequests();
        $this->webhook($no, 'settlement')->assertOk();

        $order = Order::where('order_no', $no)->first();
        $this->assertSame(Order::PAYMENT_PAID, $order->payment_status);
        $this->assertNull($order->provider_ref_id);
        $this->assertSame(Order::STATUS_PROCESSING, $order->status);

        // Gateway mengulang webhook, Digiflazz sudah pulih: dikirim ulang dan sukses.
        Http::swap(new \Illuminate\Http\Client\Factory());
        Http::fake(['*/transaction' => Http::response(['data' => ['status' => 'Sukses', 'sn' => 'SN-OK', 'message' => 'ok']])]);
        Http::preventStrayRequests();
        $this->webhook($no, 'settlement')->assertOk();

        $order->refresh();
        $this->assertSame(Order::STATUS_PROCESSING, $order->status); // hasil akhir menunggu webhook Digiflazz
        $this->assertSame('SN-OK', $order->sn);
        $this->assertSame($no, $order->provider_ref_id);
    }

    public function test_expired_or_failed_payment_webhook_never_sends_to_digiflazz(): void
    {
        $this->fakeDigiflazz('Sukses');
        $no = $this->postJson(route('topup.checkout', $this->brand->slug), $this->payload())->json('order_no');

        $this->webhook($no, 'expire')->assertOk();
        $this->webhook($no, 'settlement', 100)->assertOk(); // nominal tidak cocok

        Http::assertNotSent(fn ($r) => str_contains($r->url(), '/transaction'));
    }
}
