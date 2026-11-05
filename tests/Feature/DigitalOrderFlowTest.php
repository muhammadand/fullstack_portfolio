<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\DigiflazzWebhook;
use App\Models\Order;
use App\Models\User;
use App\Services\TopupCatalogService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Client\Request as HttpRequest;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Alur lengkap order produk digital, tanpa menyentuh API sungguhan (semua HTTP keluar di-fake):
 *
 *   customer daftar -> buat order -> bayar QRIS (webhook pay.scalify) -> kirim ke Digiflazz
 *   -> webhook Digiflazz -> status order berubah.
 */
class DigitalOrderFlowTest extends TestCase
{
    use DatabaseTransactions;

    /** @var array<int, string> urutan panggilan HTTP keluar: charge | transaction */
    protected array $calls = [];

    protected function setUp(): void
    {
        parent::setUp();
        TopupCatalogService::flush();
        config(['services.digiflazz.webhook_secret' => '']); // .env lokal bisa berisi secret

        Http::swap(new \Illuminate\Http\Client\Factory());
        Http::fake([
            '*/payments/charge' => function (HttpRequest $r) {
                $this->calls[] = 'charge';

                return Http::response(['data' => [
                    'transaction_id' => 'trx-' . $r['order_id'],
                    'payment_details' => ['actions' => [['name' => 'generate-qr-code', 'url' => 'https://qr.test/qr.png']]],
                ]]);
            },
            '*/transaction' => function (HttpRequest $r) {
                $this->calls[] = 'transaction';

                // Balasan langsung Digiflazz: biasanya Pending. Hasil akhir datang lewat webhook.
                return Http::response(['data' => [
                    'ref_id' => $r['ref_id'], 'customer_no' => $r['customer_no'], 'buyer_sku_code' => $r['buyer_sku_code'],
                    'status' => 'Pending', 'rc' => '03', 'sn' => '', 'message' => 'Transaksi Pending',
                ]]);
            },
        ]);
        Http::preventStrayRequests();
    }

    protected function product(string $category, string $brandName, string $name, int $cost, ?string $slug = null): DigitalProduct
    {
        $cat = DigitalProductCategory::firstOrCreate(['slug' => $slug ?? 'games'], ['name' => $category]);
        $brand = DigitalProductBrand::create([
            'digital_product_category_id' => $cat->id, 'name' => $brandName . ' ' . uniqid(), 'slug' => 'b-' . uniqid(),
        ]);
        $sku = 'flow-' . uniqid();

        return DigitalProduct::create([
            'provider' => 'digiflazz', 'sku_code' => $sku, 'slug' => $sku, 'name' => $name,
            'digital_product_brand_id' => $brand->id, 'cost_price' => $cost, 'is_active' => true,
        ]);
    }

    protected function payWebhook(string $orderNo, string $status = 'settlement', $amount = null)
    {
        return $this->postJson('/api/webhook/payment', array_filter([
            'order_id' => $orderNo, 'transaction_id' => 'trx-' . $orderNo, 'transaction_status' => $status, 'gross_amount' => $amount,
        ], fn ($v) => $v !== null));
    }

    protected function digiflazzWebhook(Order $order, string $status, array $over = [])
    {
        return $this->postJson('/api/digiflazz/webhook', ['data' => array_merge([
            'ref_id' => $order->order_no, 'buyer_sku_code' => $order->sku_code, 'customer_no' => $order->customer_no,
            'status' => $status, 'rc' => $status === 'Sukses' ? '00' : '40', 'message' => "Transaksi $status",
            'sn' => $status === 'Sukses' ? 'SN-' . strtoupper(substr($order->order_no, -6)) : '',
        ], $over)]);
    }

    // ---------------------------------------------------------------------------------------------------
    // Top up game: dari customer mendaftar sampai status order berubah
    // ---------------------------------------------------------------------------------------------------

    public function test_full_lifecycle_from_customer_registration_to_digiflazz_webhook(): void
    {
        $product = $this->product('Games', 'Mobile Legends Flow', '86 Diamond', 20000);
        $brand = $product->brand;

        // 1. Customer mendaftar (sumber: top up) dan otomatis login.
        $email = 'flow_' . uniqid() . '@example.com';
        $this->post(route('customer.register.post'), ['name' => 'Budi Gamers', 'email' => $email, 'password' => 'secret123'])
            ->assertRedirect(route('topup.index'));
        $customer = Customer::where('email', $email)->firstOrFail();
        $this->assertSame(Customer::SOURCE_TOPUP, $customer->source);
        $this->assertAuthenticatedAs($customer, 'customer');

        // 2. Membuka halaman game lalu checkout: order dibuat (pending / belum bayar), tagihan QRIS terbit.
        $this->get(route('topup.show', $brand->slug))->assertOk();
        $res = $this->postJson(route('topup.checkout', $brand->slug), [
            'product_id' => $product->id, 'account' => ['user_id' => '12345678', 'zone_id' => '1234'],
            'email' => 'struk@example.com', 'note' => 'cepat ya',
        ])->assertCreated();

        $orderNo = $res->json('order_no');
        $this->assertStringStartsWith('TP-', $orderNo);
        $this->assertSame('https://qr.test/qr.png', $res->json('qr_url'));
        $this->assertSame(['charge'], $this->calls);

        $order = Order::where('order_no', $orderNo)->firstOrFail();
        $this->assertSame($customer->id, $order->customer_id);
        $this->assertSame(Order::STATUS_PENDING, $order->status);
        $this->assertSame(Order::PAYMENT_UNPAID, $order->payment_status);
        $this->assertSame('123456781234', $order->customer_no);
        $this->assertSame('struk@example.com', $order->email);

        // 3. Belum bayar: riwayat customer menampilkan "Menunggu", dan belum ada yang dikirim ke Digiflazz.
        $this->getJson(route('topup.order.status', $orderNo))->assertJson(['is_paid' => false]);
        $this->get(route('customer.account'))->assertOk()->assertSee($orderNo)->assertSee('Menunggu');
        $this->assertNotContains('transaction', $this->calls);

        // 4. Pembayaran lunas (webhook pay.scalify): order dibayar dan LANGSUNG dikirim ke Digiflazz.
        $this->payWebhook($orderNo)->assertOk()->assertJsonPath('data.digital_order.payment_status', 'paid');
        $this->assertSame(['charge', 'transaction'], $this->calls);

        Http::assertSent(fn (HttpRequest $r) => str_contains($r->url(), '/transaction')
            && $r['buyer_sku_code'] === $product->sku_code   // dari order.sku_code
            && $r['customer_no'] === '123456781234'           // dari order.customer_no
            && $r['ref_id'] === $orderNo);                    // dari order.order_no

        $order->refresh();
        $this->assertSame(Order::PAYMENT_PAID, $order->payment_status);
        $this->assertNotNull($order->paid_at);
        $this->assertSame($orderNo, $order->provider_ref_id);
        $this->assertSame(Order::STATUS_PROCESSING, $order->status, 'Status bukan dari balasan langsung, tunggu webhook Digiflazz.');

        // 5. Polling modal QRIS melihat lunas, tanpa mengirim ulang ke Digiflazz.
        $this->getJson(route('topup.order.status', $orderNo))->assertJson(['is_paid' => true]);
        $this->get(route('customer.account'))->assertSee('Diproses');
        $this->assertSame(['charge', 'transaction'], $this->calls);

        // 6. Webhook pay.scalify diulang gateway: tidak mengirim ulang ke Digiflazz.
        $this->payWebhook($orderNo)->assertOk();
        $this->assertSame(['charge', 'transaction'], $this->calls);

        // 7. Webhook Digiflazz "Sukses": status order menjadi success, lengkap dengan SN.
        $this->digiflazzWebhook($order, 'Sukses')->assertOk();

        $order->refresh();
        $this->assertSame(Order::STATUS_SUCCESS, $order->status);
        $this->assertSame(Order::PAYMENT_PAID, $order->payment_status);
        $this->assertSame('SN-' . strtoupper(substr($orderNo, -6)), $order->sn);
        $this->assertNotNull($order->completed_at);
        $this->assertTrue(DigiflazzWebhook::where('ref_id', $orderNo)->latest('id')->first()->is_processed);

        // 8. Customer dan admin sama-sama melihat "Berhasil".
        $this->get(route('customer.account'))->assertSee('Berhasil');
        $admin = User::create(['name' => 'Admin', 'email' => 'adm_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => 'admin']);
        $this->actingAs($admin)->get(route('admin.topup_orders.show', $order))->assertOk()->assertSee('Berhasil')->assertSee($order->sn);

        // 9. Webhook Digiflazz yang telat/dobel tidak mengubah hasil akhir; total panggilan Digiflazz tetap satu.
        $this->digiflazzWebhook($order, 'Gagal')->assertOk();
        $this->assertSame(Order::STATUS_SUCCESS, $order->fresh()->status);
        $this->assertSame(['charge', 'transaction'], $this->calls);
    }

    public function test_full_lifecycle_failure_path_keeps_payment_paid_and_marks_order_failed(): void
    {
        $product = $this->product('Games', 'Free Fire Flow', '70 Diamond', 10000);
        $res = $this->postJson(route('topup.checkout', $product->brand->slug), [
            'product_id' => $product->id, 'account' => ['player_id' => '987654321'],
        ])->assertCreated();

        $order = Order::where('order_no', $res->json('order_no'))->firstOrFail();
        $this->assertNull($order->customer_id); // tamu

        $this->payWebhook($order->order_no)->assertOk();
        $this->digiflazzWebhook($order, 'Gagal', ['message' => 'ID tujuan salah'])->assertOk();

        $order->refresh();
        $this->assertSame(Order::STATUS_FAILED, $order->status);
        $this->assertSame(Order::PAYMENT_PAID, $order->payment_status);
        $this->assertSame('ID tujuan salah', $order->provider_message);
        $this->assertNull($order->completed_at);
    }

    // ---------------------------------------------------------------------------------------------------
    // Scalable: pulsa, listrik, dll. memakai alur & payload yang sama (hanya awalan nomor order yang beda)
    // ---------------------------------------------------------------------------------------------------

    public static function otherProductTypes(): array
    {
        return [
            'pulsa'  => ['PL-',  'Pulsa', 'Telkomsel 10.000', 'pulsa', '081234567890'],
            'listrik' => ['PLN-', 'PLN', 'Token PLN 20.000', 'pln', '32123456789'],
        ];
    }

    /** @dataProvider otherProductTypes */
    public function test_other_product_types_use_the_same_payload_and_status_flow(string $prefix, string $category, string $name, string $slug, string $customerNo): void
    {
        $product = $this->product($category, $category, $name, 10000, $slug);
        $order = Order::create([
            'order_no' => Order::generateOrderNo($prefix), 'digital_product_id' => $product->id,
            'customer_no' => $customerNo, 'product_name' => $name, 'sku_code' => $product->sku_code,
            'cost_price' => 10000, 'price' => 11500, 'total_amount' => 11500,
        ]);
        $this->assertStringStartsWith($prefix, $order->order_no);

        // Nominal tidak cocok: tidak dikirim.
        $this->payWebhook($order->order_no, 'settlement', 1)->assertOk();
        $this->assertSame([], $this->calls);

        // Lunas: payload identik dengan top up game (sku_code, customer_no, order_no).
        $this->payWebhook($order->order_no, 'settlement', 11500)->assertOk();
        $this->assertSame(['transaction'], $this->calls);
        Http::assertSent(fn (HttpRequest $r) => $r['buyer_sku_code'] === $product->sku_code
            && $r['customer_no'] === $customerNo && $r['ref_id'] === $order->order_no);

        $this->assertSame(Order::STATUS_PROCESSING, $order->fresh()->status);

        // Webhook Digiflazz menentukan status akhir.
        $this->digiflazzWebhook($order, 'Sukses')->assertOk();
        $order->refresh();
        $this->assertSame(Order::STATUS_SUCCESS, $order->status);
        $this->assertNotEmpty($order->sn);
        $this->assertSame(['transaction'], $this->calls);
    }

    public function test_unknown_order_prefix_is_rejected_when_generating(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Order::generateOrderNo('XX-');
    }

    public function test_order_prefixes_are_recognized_for_payment_and_digiflazz_routing(): void
    {
        foreach (array_keys(Order::ORDER_NO_PREFIXES) as $prefix) {
            $this->assertTrue(Order::hasKnownPrefix($prefix . '20261105-ABC123'));
        }
        foreach (['GCO-123', 'RVN-123', 'DEP-123', 'HOOK-1', ''] as $other) {
            $this->assertFalse(Order::hasKnownPrefix($other));
        }
    }

    // ---------------------------------------------------------------------------------------------------
    // Webhook pembayaran yang gagal / kedaluwarsa
    // ---------------------------------------------------------------------------------------------------

    public static function failedPaymentStatuses(): array
    {
        return ['deny' => ['deny'], 'cancel' => ['cancel'], 'failure' => ['failure'], 'failed' => ['failed']];
    }

    protected function checkoutOrder(): Order
    {
        $product = $this->product('Games', 'Free Fire Fail', '70 Diamond', 10000);
        $res = $this->postJson(route('topup.checkout', $product->brand->slug), [
            'product_id' => $product->id, 'account' => ['player_id' => '987654321'],
        ])->assertCreated();

        return Order::where('order_no', $res->json('order_no'))->firstOrFail();
    }

    /** @dataProvider failedPaymentStatuses */
    public function test_failed_payment_webhook_marks_order_failed_and_never_reaches_digiflazz(string $gatewayStatus): void
    {
        $order = $this->checkoutOrder();

        $this->payWebhook($order->order_no, $gatewayStatus)->assertOk()->assertJsonPath('data.digital_order.payment_status', 'failed');

        $order->refresh();
        $this->assertSame(Order::PAYMENT_FAILED, $order->payment_status);
        $this->assertSame(Order::STATUS_FAILED, $order->status);
        $this->assertNull($order->provider_ref_id);
        $this->assertSame(['charge'], $this->calls, 'Pembayaran gagal tidak boleh memicu Digiflazz.');

        // Browser pembeli diberi tahu (modal "Pembayaran Gagal"), bukan menunggu sampai QR habis.
        $this->getJson(route('topup.order.status', $order->order_no))
            ->assertJson(['is_paid' => false, 'is_expired' => false, 'is_failed' => true]);

        // Webhook Digiflazz untuk order ini (tidak semestinya ada) tidak membuatnya berhasil.
        $this->digiflazzWebhook($order, 'Sukses')->assertOk();
        $this->assertSame(Order::STATUS_FAILED, $order->fresh()->status);
    }

    public function test_expired_payment_webhook_marks_order_expired_and_status_endpoint_reports_it(): void
    {
        $order = $this->checkoutOrder();

        $this->payWebhook($order->order_no, 'expire')->assertOk();

        $order->refresh();
        $this->assertSame(Order::PAYMENT_EXPIRED, $order->payment_status);
        $this->assertSame(Order::STATUS_EXPIRED, $order->status);
        $this->assertSame(['charge'], $this->calls);
        $this->getJson(route('topup.order.status', $order->order_no))->assertJson(['is_expired' => true, 'is_failed' => false]);
    }

    public function test_failed_or_expired_webhook_arriving_after_payment_never_downgrades_a_paid_order(): void
    {
        $order = $this->checkoutOrder();
        $this->payWebhook($order->order_no)->assertOk();

        foreach (['deny', 'cancel', 'expire'] as $late) {
            $this->payWebhook($order->order_no, $late)->assertOk();
        }

        $order->refresh();
        $this->assertSame(Order::PAYMENT_PAID, $order->payment_status);
        $this->assertSame(Order::STATUS_PROCESSING, $order->status);
        $this->assertSame(['charge', 'transaction'], $this->calls);
    }

    public function test_money_received_after_expiry_still_fulfils_the_order(): void
    {
        $order = $this->checkoutOrder();
        $this->payWebhook($order->order_no, 'expire')->assertOk();

        // Pembeli membayar tepat di batas waktu; gateway tetap mengirim settlement.
        $this->payWebhook($order->order_no, 'settlement')->assertOk();

        $order->refresh();
        $this->assertSame(Order::PAYMENT_PAID, $order->payment_status);
        $this->assertSame(Order::STATUS_PROCESSING, $order->status);
        $this->assertSame(['charge', 'transaction'], $this->calls);
    }

    public function test_pending_payment_webhook_changes_nothing(): void
    {
        $order = $this->checkoutOrder();

        $this->payWebhook($order->order_no, 'pending')->assertOk();

        $order->refresh();
        $this->assertSame(Order::PAYMENT_UNPAID, $order->payment_status);
        $this->assertSame(Order::STATUS_PENDING, $order->status);
        $this->assertSame(['charge'], $this->calls);
    }

    public function test_digiflazz_failure_after_payment_marks_order_failed_while_payment_stays_paid(): void
    {
        $order = $this->checkoutOrder();
        $this->payWebhook($order->order_no)->assertOk();

        $this->digiflazzWebhook($order, 'Gagal', ['rc' => '44', 'message' => 'Saldo supplier tidak cukup'])->assertOk();

        $order->refresh();
        $this->assertSame(Order::STATUS_FAILED, $order->status);
        $this->assertSame(Order::PAYMENT_PAID, $order->payment_status); // perlu refund/tindak lanjut manual
        $this->assertSame('Saldo supplier tidak cukup', $order->provider_message);
    }
}
