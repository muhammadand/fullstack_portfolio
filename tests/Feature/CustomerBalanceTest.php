<?php

namespace Tests\Feature;

use App\Mail\TopupOrderStatusMail;
use App\Models\Customer;
use App\Models\CustomerBalanceMutation;
use App\Models\CustomerWithdrawal;
use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CustomerBalanceTest extends TestCase
{
    use DatabaseTransactions;

    protected Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.digiflazz.webhook_secret' => '']);
        Mail::fake();

        $this->customer = Customer::create([
            'name' => 'Rina Gamer', 'email' => 'rina_' . uniqid() . '@example.com', 'password' => 'secret123', 'source' => 'topup',
        ]);
    }

    protected function paidOrder(array $over = []): Order
    {
        $cat = DigitalProductCategory::firstOrCreate(['slug' => 'games'], ['name' => 'Games']);
        $brand = DigitalProductBrand::create(['digital_product_category_id' => $cat->id, 'name' => 'ML ' . uniqid(), 'slug' => 'ml-' . uniqid()]);
        $sku = 'cb-' . uniqid();
        $product = DigitalProduct::create(['provider' => 'digiflazz', 'sku_code' => $sku, 'slug' => $sku, 'name' => '86 Diamond',
            'digital_product_brand_id' => $brand->id, 'cost_price' => 20000, 'is_active' => true]);

        return Order::create($over + [
            'order_no' => Order::generateOrderNo(), 'customer_id' => $this->customer->id, 'digital_product_id' => $product->id,
            'customer_no' => '12345678', 'email' => $this->customer->email, 'product_name' => '86 Diamond', 'sku_code' => $sku,
            'cost_price' => 20000, 'price' => 21000, 'total_amount' => 21000,
            'status' => Order::STATUS_PROCESSING, 'payment_status' => Order::PAYMENT_PAID, 'paid_at' => now(),
            'provider_ref_id' => 'x',
        ]);
    }

    protected function failWebhook(Order $order)
    {
        return $this->postJson('/api/digiflazz/webhook', ['data' => [
            'ref_id' => $order->order_no, 'buyer_sku_code' => $order->sku_code, 'customer_no' => $order->customer_no,
            'status' => 'Gagal', 'rc' => '40', 'message' => 'Transaksi Gagal', 'sn' => '',
        ]]);
    }

    protected function fundedCustomer(float $amount): void
    {
        $order = $this->paidOrder(['total_amount' => $amount, 'price' => $amount]);
        $this->failWebhook($order)->assertOk();
        $this->assertEquals($amount, (float) $this->customer->fresh()->balance);
    }

    protected function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'adm_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => 'admin']);
    }

    // --- Refund ---------------------------------------------------------------------------------------

    public function test_failed_paid_order_of_logged_in_customer_is_refunded_to_balance_once(): void
    {
        $order = $this->paidOrder();

        $this->failWebhook($order)->assertOk();
        $this->failWebhook($order)->assertOk(); // webhook ulang tidak boleh refund lagi

        $order->refresh();
        $this->assertSame(Order::STATUS_FAILED, $order->status);
        $this->assertNotNull($order->refunded_at);
        $this->assertEquals(21000, (float) $this->customer->fresh()->balance);

        $mutations = CustomerBalanceMutation::where('customer_id', $this->customer->id)->get();
        $this->assertCount(1, $mutations);
        $this->assertSame(CustomerBalanceMutation::ORDER_REFUND, $mutations[0]->category);
        $this->assertSame(Order::class, $mutations[0]->reference_type);
        $this->assertEquals(0, (float) $mutations[0]->balance_before);
        $this->assertEquals(21000, (float) $mutations[0]->balance_after);

        $refund = $order->events()->where('event', OrderEvent::WALLET_REFUNDED)->sole();
        $this->assertSame('customer_balance', $refund->context['target']);
        $this->assertTrue(OrderEvent::verifyChain($order->id));

        Mail::assertSent(TopupOrderStatusMail::class, fn ($m) => $m->event === 'failed'
            && str_contains($m->meta()['message'], 'saldo akun kamu')
            && $m->meta()['cta_label'] === 'Lihat Saldo');
    }

    public function test_guest_order_is_not_refunded_automatically(): void
    {
        $order = $this->paidOrder(['customer_id' => null]);

        $this->failWebhook($order)->assertOk();

        $this->assertNull($order->fresh()->refunded_at);
        $this->assertSame(0, CustomerBalanceMutation::where('reference_type', Order::class)->where('reference_id', $order->id)->count());
    }

    public function test_unpaid_order_is_not_refunded(): void
    {
        $order = $this->paidOrder(['payment_status' => Order::PAYMENT_UNPAID, 'paid_at' => null]);

        app(\App\Services\CustomerBalanceService::class)->refundOrder($order->fresh(), 'test');

        $this->assertEquals(0, (float) $this->customer->fresh()->balance);
    }

    // --- Penarikan customer ---------------------------------------------------------------------------

    public function test_customer_requests_withdrawal_with_two_percent_fee(): void
    {
        $this->fundedCustomer(100000);

        $this->actingAs($this->customer->fresh(), 'customer')->get(route('customer.account'))
            ->assertOk()->assertSee('Rp 100.000')->assertSee('Tarik ke E-Wallet');

        $this->actingAs($this->customer->fresh(), 'customer')->post(route('customer.withdraw.store'), [
            'amount' => 100000, 'ewallet' => 'DANA', 'account_no' => '0812-3456-7890', 'account_name' => 'Rina',
        ])->assertRedirect(route('customer.account'))->assertSessionHas('success');

        $w = CustomerWithdrawal::where('customer_id', $this->customer->id)->sole();
        $this->assertEquals(100000, (float) $w->amount);
        $this->assertEquals(2000, (float) $w->fee);
        $this->assertEquals(98000, (float) $w->net_amount);
        $this->assertSame('081234567890', $w->account_no);
        $this->assertSame(CustomerWithdrawal::STATUS_PENDING, $w->status);
        $this->assertEquals(0, (float) $this->customer->fresh()->balance); // saldo ditahan

        $this->assertSame(CustomerBalanceMutation::WITHDRAWAL,
            CustomerBalanceMutation::where('customer_id', $this->customer->id)->latest('id')->value('category'));

        // Penarikan kedua ditolak selama yang pertama masih diproses.
        $this->actingAs($this->customer->fresh(), 'customer')->get(route('customer.withdraw'))->assertRedirect(route('customer.account'));
    }

    public function test_withdrawal_validation_and_balance_checks(): void
    {
        $this->fundedCustomer(21000);
        $as = $this->actingAs($this->customer->fresh(), 'customer');

        $as->post(route('customer.withdraw.store'), ['amount' => 5000, 'ewallet' => 'DANA', 'account_no' => '081234567890', 'account_name' => 'R'])
            ->assertSessionHasErrors('amount');
        $as->post(route('customer.withdraw.store'), ['amount' => 20000, 'ewallet' => 'BCA', 'account_no' => '081234567890', 'account_name' => 'R'])
            ->assertSessionHasErrors('ewallet');
        $as->post(route('customer.withdraw.store'), ['amount' => 20000, 'ewallet' => 'OVO', 'account_no' => '12', 'account_name' => 'R'])
            ->assertSessionHasErrors('account_no');
        $as->post(route('customer.withdraw.store'), ['amount' => 50000, 'ewallet' => 'OVO', 'account_no' => '081234567890', 'account_name' => 'R'])
            ->assertSessionHas('error', 'Saldo tidak cukup.');

        $this->assertSame(0, CustomerWithdrawal::where('customer_id', $this->customer->id)->count());
        $this->assertEquals(21000, (float) $this->customer->fresh()->balance);
    }

    public function test_guest_cannot_access_account_or_withdraw(): void
    {
        $this->get(route('customer.account'))->assertRedirect();
        $this->post(route('customer.withdraw.store'), ['amount' => 20000])->assertRedirect();
    }

    // --- Admin ----------------------------------------------------------------------------------------

    public function test_admin_completes_withdrawal_once(): void
    {
        $this->fundedCustomer(50000);
        $this->actingAs($this->customer->fresh(), 'customer')->post(route('customer.withdraw.store'), [
            'amount' => 50000, 'ewallet' => 'GoPay', 'account_no' => '081234567890', 'account_name' => 'Rina',
        ]);
        $w = CustomerWithdrawal::where('customer_id', $this->customer->id)->sole();
        $admin = $this->admin();

        $this->actingAs($admin)->get(route('admin.customer_withdrawals.index'))
            ->assertOk()->assertSee($w->withdrawal_no)->assertSee('Rp 49.000')->assertSee('081234567890');

        $this->actingAs($admin)->post(route('admin.customer_withdrawals.complete', $w), ['transfer_reference' => 'GOPAY-123'])
            ->assertSessionHas('success');
        $this->actingAs($admin)->post(route('admin.customer_withdrawals.complete', $w))->assertSessionHas('error');
        $this->actingAs($admin)->post(route('admin.customer_withdrawals.reject', $w), ['reason' => 'x'])->assertSessionHas('error');

        $w->refresh();
        $this->assertSame(CustomerWithdrawal::STATUS_COMPLETED, $w->status);
        $this->assertSame('GOPAY-123', $w->transfer_reference);
        $this->assertSame($admin->id, $w->processed_by);
        $this->assertEquals(0, (float) $this->customer->fresh()->balance); // tidak ada saldo kembali
    }

    public function test_admin_rejects_withdrawal_and_balance_returns(): void
    {
        $this->fundedCustomer(30000);
        $this->actingAs($this->customer->fresh(), 'customer')->post(route('customer.withdraw.store'), [
            'amount' => 30000, 'ewallet' => 'OVO', 'account_no' => '081234567890', 'account_name' => 'Rina',
        ]);
        $w = CustomerWithdrawal::where('customer_id', $this->customer->id)->sole();
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.customer_withdrawals.reject', $w), [])->assertSessionHasErrors('reason');
        $this->actingAs($admin)->post(route('admin.customer_withdrawals.reject', $w), ['reason' => 'Nomor OVO tidak terdaftar'])
            ->assertSessionHas('success');

        $this->assertSame(CustomerWithdrawal::STATUS_REJECTED, $w->fresh()->status);
        $this->assertEquals(30000, (float) $this->customer->fresh()->balance);
        $this->assertSame(CustomerBalanceMutation::WITHDRAWAL_REVERSAL,
            CustomerBalanceMutation::where('customer_id', $this->customer->id)->latest('id')->value('category'));

        $this->actingAs($this->customer->fresh(), 'customer')->get(route('customer.account'))
            ->assertOk()->assertSee('Nomor OVO tidak terdaftar');
    }

    public function test_admin_page_requires_login(): void
    {
        $this->get(route('admin.customer_withdrawals.index'))->assertRedirect(route('login'));
    }

    public function test_balance_mutations_are_append_only(): void
    {
        $this->fundedCustomer(21000);
        $m = CustomerBalanceMutation::where('customer_id', $this->customer->id)->firstOrFail();

        $this->expectException(\LogicException::class);
        $m->update(['amount' => 1]);
    }
}
