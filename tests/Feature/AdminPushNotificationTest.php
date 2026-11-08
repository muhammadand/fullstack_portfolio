<?php

namespace Tests\Feature;

use App\Models\Affiliate;
use App\Models\Customer;
use App\Models\CustomerWithdrawal;
use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\Order;
use App\Models\User;
use App\Notifications\AdminActivityNotification;
use App\Services\AdminNotifier;
use App\Services\CustomerBalanceService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdminPushNotificationTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutDefer(); // jalankan kiriman push langsung, bukan setelah response
        config(['services.admin_push.enabled' => true]); // default dimatikan saat test (phpunit.xml)
        Notification::fake();
        Mail::fake();
        config(['services.digiflazz.webhook_secret' => '']);

        $this->admin = $this->user('admin');
        $this->admin->updatePushSubscription('https://push.example.com/' . uniqid(), 'p256dh-key', 'auth-token');
    }

    protected function user(string $role): User
    {
        return User::create(['name' => ucfirst($role), 'email' => $role . '_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => $role]);
    }

    protected function assertAdminPushed(string $title): void
    {
        Notification::assertSentTo($this->admin, AdminActivityNotification::class, fn ($n) => $n->title === $title);
    }

    protected function order(array $over = []): Order
    {
        $cat = DigitalProductCategory::firstOrCreate(['slug' => 'games'], ['name' => 'Games']);
        $brand = DigitalProductBrand::create(['digital_product_category_id' => $cat->id, 'name' => 'B ' . uniqid(), 'slug' => 'b-' . uniqid()]);
        $sku = 'push-' . uniqid();
        $p = DigitalProduct::create(['provider' => 'digiflazz', 'sku_code' => $sku, 'slug' => $sku, 'name' => '86 Diamond',
            'digital_product_brand_id' => $brand->id, 'cost_price' => 20000, 'is_active' => true]);

        return Order::create($over + [
            'order_no' => Order::generateOrderNo(), 'digital_product_id' => $p->id, 'customer_no' => '123', 'product_name' => '86 Diamond',
            'sku_code' => $sku, 'cost_price' => 20000, 'price' => 21000, 'total_amount' => 21000,
        ]);
    }

    // --- Pendaftaran perangkat ------------------------------------------------------------------------

    public function test_admin_registers_and_removes_device(): void
    {
        $endpoint = 'https://fcm.googleapis.com/fcm/send/' . uniqid();
        $payload = ['endpoint' => $endpoint, 'keys' => ['auth' => 'a', 'p256dh' => 'p']];

        $this->postJson(route('admin.push.subscribe'), $payload)->assertUnauthorized();
        $this->actingAs($this->user('editor'))->postJson(route('admin.push.subscribe'), $payload)->assertForbidden();

        $this->actingAs($this->admin)->postJson(route('admin.push.subscribe'), $payload)->assertOk();
        $this->assertTrue($this->admin->pushSubscriptions()->where('endpoint', $endpoint)->exists());

        $this->actingAs($this->admin)->postJson(route('admin.push.test'))->assertOk();
        $this->assertAdminPushed('Notifikasi admin aktif');

        $this->actingAs($this->admin)->postJson(route('admin.push.unsubscribe'), ['endpoint' => $endpoint])->assertOk();
        $this->assertFalse($this->admin->pushSubscriptions()->where('endpoint', $endpoint)->exists());
    }

    // --- Kejadian ------------------------------------------------------------------------------------

    public function test_partner_registration_notifies_admin_but_not_when_admin_creates_it(): void
    {
        Affiliate::create(['name' => 'Budi', 'email' => 'budi_' . uniqid() . '@x.id', 'password' => bcrypt('x'), 'affiliate_code' => 'B' . rand(1000, 9999), 'status' => 'pending']);
        $this->assertAdminPushed('Partner baru mendaftar');

        Notification::fake();
        $this->actingAs($this->admin);
        Affiliate::create(['name' => 'Oleh Admin', 'email' => 'adm_' . uniqid() . '@x.id', 'password' => bcrypt('x'), 'affiliate_code' => 'A' . rand(1000, 9999), 'status' => 'approved']);
        Notification::assertNothingSent();
    }

    public function test_paid_topup_notifies_admin(): void
    {
        Http::fake(['*' => Http::response(['data' => ['status' => 'Pending', 'rc' => '03', 'sn' => '', 'message' => 'Pending']])]);
        $order = $this->order();

        $this->postJson('/api/webhook/payment', ['order_id' => $order->order_no, 'transaction_id' => 't-' . $order->id, 'transaction_status' => 'settlement'])->assertOk();

        $this->assertAdminPushed('Top Up Game dibayar');
    }

    public function test_failed_order_notifies_admin(): void
    {
        $order = $this->order(['status' => Order::STATUS_PROCESSING, 'payment_status' => Order::PAYMENT_PAID, 'paid_at' => now(), 'provider_ref_id' => 'x']);

        $this->postJson('/api/digiflazz/webhook', ['data' => [
            'ref_id' => $order->order_no, 'buyer_sku_code' => $order->sku_code, 'status' => 'Gagal', 'rc' => '40', 'message' => 'Nomor salah', 'sn' => '',
        ]])->assertOk();

        $this->assertAdminPushed('Order gagal di Digiflazz');
    }

    public function test_customer_withdrawal_notifies_admin(): void
    {
        $customer = Customer::create(['name' => 'Rina', 'email' => 'r_' . uniqid() . '@x.id', 'password' => 'secret123', 'source' => 'topup']);
        $customer->forceFill(['balance' => 50000])->save();

        app(CustomerBalanceService::class)->requestWithdrawal($customer, 50000, 'DANA', '081234567890', 'Rina');

        Notification::assertSentTo($this->admin, AdminActivityNotification::class,
            fn ($n) => $n->title === 'Customer ajukan penarikan' && str_contains($n->body, 'Rp 49.000'));
    }

    public function test_only_admins_with_devices_receive_and_failures_do_not_break_flow(): void
    {
        $editor = $this->user('editor');
        $editor->updatePushSubscription('https://push.example.com/e' . uniqid(), 'k', 't');
        $adminWithoutDevice = $this->user('super_admin');

        AdminNotifier::sendNow('Uji', 'Isi', url('/'));

        Notification::assertSentTo($this->admin, AdminActivityNotification::class);
        Notification::assertNotSentTo($editor, AdminActivityNotification::class);
        Notification::assertNotSentTo($adminWithoutDevice, AdminActivityNotification::class);

        // Pengiriman gagal (mis. layanan push mati) tidak boleh melempar error ke proses utama.
        Notification::shouldReceive('send')->andThrow(new \RuntimeException('push down'));
        AdminNotifier::sendNow('Uji', 'Isi', url('/'));
        $this->assertTrue(true);
    }

    public function test_push_can_be_disabled_by_config(): void
    {
        config(['services.admin_push.enabled' => false]);

        AdminNotifier::sendNow('Uji', 'Isi', url('/'));

        Notification::assertNothingSent();
    }
}
