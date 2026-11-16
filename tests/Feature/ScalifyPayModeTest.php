<?php

namespace Tests\Feature;

use App\Models\AppSettingLog;
use App\Models\User;
use App\Services\QrisPaymentService;
use App\Services\ScalifyPayService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ScalifyPayModeTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::forget('app_setting:' . ScalifyPayService::MODE_SETTING_KEY);
        \App\Models\AppSetting::where('key', ScalifyPayService::MODE_SETTING_KEY)->delete();
        config([
            'services.scalify_pay.mode' => null,
            'services.scalify_pay.base_urls' => ['production' => 'https://pay.test/api/v1', 'sandbox' => 'https://sandbox.pay.test/api/v1'],
            'services.scalify_pay.api_keys' => ['production' => 'pk_live_prod_key_123', 'sandbox' => 'pk_test_sandbox_key_456'],
            'services.qris.url' => 'https://pay.test/api/v1/qris/dynamic',
        ]);
        Http::fake(['*' => Http::response(['success' => true, 'data' => []])]);
    }

    protected function tearDown(): void
    {
        Cache::forget('app_setting:' . ScalifyPayService::MODE_SETTING_KEY);
        parent::tearDown();
    }

    protected function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'adm_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => 'admin']);
    }

    public function test_default_mode_is_production_and_charge_uses_production_key(): void
    {
        $this->assertSame('production', ScalifyPayService::mode());

        ScalifyPayService::charge(['order_id' => 'TP-1', 'amount' => 10000, 'payment_type' => 'qris']);

        Http::assertSent(fn ($r) => $r->url() === 'https://pay.test/api/v1/payments/charge' && $r->header('X-API-Key')[0] === 'pk_live_prod_key_123');
    }

    public function test_admin_switches_to_sandbox_and_all_qris_calls_follow(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.payment_gateway.mode'), ['mode' => 'sandbox'])->assertSessionHas('success');
        $this->assertSame('sandbox', ScalifyPayService::mode());

        ScalifyPayService::charge(['order_id' => 'TP-2', 'amount' => 10000, 'payment_type' => 'qris']);
        QrisPaymentService::createDynamicQris('TRV-1', 50000);

        Http::assertSent(fn ($r) => $r->url() === 'https://sandbox.pay.test/api/v1/payments/charge' && $r->header('X-API-Key')[0] === 'pk_test_sandbox_key_456');
        Http::assertSent(fn ($r) => str_contains($r->url(), '/qris/dynamic') && $r->header('X-API-Key')[0] === 'pk_test_sandbox_key_456');

        $log = AppSettingLog::where('key', ScalifyPayService::MODE_SETTING_KEY)->latest('id')->firstOrFail();
        $this->assertSame('sandbox', $log->new_value);
        $this->assertSame($admin->email, $log->user_email);

        $this->actingAs($admin)->get(route('admin.payment_gateway.index'))
            ->assertOk()->assertSee('Sandbox (uji coba)')->assertSee('pk_test_sand')
            ->assertDontSee('pk_test_sandbox_key_456')->assertDontSee('pk_live_prod_key_123'); // key tidak pernah tampil utuh
    }

    public function test_cannot_switch_to_mode_without_key_and_guest_is_blocked(): void
    {
        config(['services.scalify_pay.api_keys.sandbox' => '']);

        $this->post(route('admin.payment_gateway.mode'), ['mode' => 'sandbox'])->assertRedirect(route('login'));
        $this->actingAs($this->admin())->post(route('admin.payment_gateway.mode'), ['mode' => 'sandbox'])->assertSessionHas('error');
        $this->actingAs($this->admin())->post(route('admin.payment_gateway.mode'), ['mode' => 'staging'])->assertSessionHasErrors('mode');

        $this->assertSame('production', ScalifyPayService::mode());
    }

    public function test_legacy_single_key_is_mapped_by_prefix(): void
    {
        $saved = [];
        $set = function (array $vars) use (&$saved) {
            foreach ($vars as $k => $v) {
                $saved[$k] ??= $_ENV[$k] ?? null;
                if ($v === null) { unset($_ENV[$k], $_SERVER[$k]); putenv($k); } else { $_ENV[$k] = $_SERVER[$k] = $v; putenv("$k=$v"); }
            }
        };
        $clear = ['SCALIFY_PAY_API_KEY' => null, 'SCALIFY_PAY_PRODUCTION_API_KEY' => null, 'SCALIFY_PAY_SANDBOX_API_KEY' => null, 'QRIS_API_KEY' => null];

        try {
            $set($clear + ['SCALIFY_QRIS_API_KEY' => 'pk_live_legacy_abc']);
            $live = (require config_path('services.php'))['scalify_pay']['api_keys'];
            $set(['SCALIFY_QRIS_API_KEY' => 'pk_test_legacy_xyz']);
            $test = (require config_path('services.php'))['scalify_pay']['api_keys'];
        } finally {
            $set(array_map(fn () => null, $saved));
            foreach ($saved as $k => $v) {
                if ($v !== null) { $_ENV[$k] = $_SERVER[$k] = $v; putenv("$k=$v"); }
            }
        }

        $this->assertSame(['production' => 'pk_live_legacy_abc', 'sandbox' => ''], $live);
        $this->assertSame(['production' => '', 'sandbox' => 'pk_test_legacy_xyz'], $test);
    }

    public function test_no_api_key_is_hardcoded_in_source(): void
    {
        foreach (['app/Services/ScalifyPayService.php', 'app/Services/QrisPaymentService.php', 'config/services.php'] as $file) {
            $this->assertDoesNotMatchRegularExpression('/pk_(live|test)_[a-z0-9]{6,}_sk_/i', file_get_contents(base_path($file)), $file);
        }
    }
}
