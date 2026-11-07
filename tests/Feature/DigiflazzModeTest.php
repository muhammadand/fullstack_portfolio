<?php

namespace Tests\Feature;

use App\Models\AppSetting;
use App\Models\AppSettingLog;
use App\Models\User;
use App\Services\DigiflazzService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DigiflazzModeTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::forget('app_setting:' . DigiflazzService::MODE_SETTING_KEY);
        \App\Models\AppSetting::where('key', DigiflazzService::MODE_SETTING_KEY)->delete();

        config([
            'services.digiflazz.username' => 'tester',
            'services.digiflazz.mode' => 'development',
            'services.digiflazz.api_keys' => ['development' => 'dev-key-123', 'production' => 'prod-key-456'],
        ]);

        Http::fake(['*' => Http::response(['data' => ['deposit' => 100000, 'status' => 'Pending', 'rc' => '03']])]);
    }

    protected function tearDown(): void
    {
        Cache::forget('app_setting:' . DigiflazzService::MODE_SETTING_KEY);
        parent::tearDown();
    }

    protected function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'adm_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => 'admin']);
    }

    public function test_default_mode_comes_from_config_and_uses_dev_key_with_testing_flag(): void
    {
        $this->assertSame('development', DigiflazzService::mode());
        $this->assertSame('dev-key-123', DigiflazzService::getApiKey());

        DigiflazzService::transaction('tsel5', '081234567890', 'PL-1');

        Http::assertSent(fn ($r) => str_contains($r->url(), '/transaction')
            && $r['testing'] === true
            && $r['sign'] === md5('tester' . 'dev-key-123' . 'PL-1'));
    }

    public function test_admin_switches_to_production_and_change_is_audited(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.ppob.mode'), ['mode' => 'production'])
            ->assertRedirect()->assertSessionHas('success');

        $this->assertSame('production', DigiflazzService::mode());
        $this->assertSame('prod-key-456', DigiflazzService::getApiKey());

        $log = AppSettingLog::where('key', DigiflazzService::MODE_SETTING_KEY)->latest('id')->firstOrFail();
        $this->assertNull($log->old_value);
        $this->assertSame('production', $log->new_value);
        $this->assertSame($admin->id, $log->user_id);
        $this->assertSame($admin->email, $log->user_email);
        $this->assertNotNull($log->ip_address);

        // Produksi: tanpa flag testing, sign pakai key production.
        DigiflazzService::transaction('tsel5', '081234567890', 'PL-2');
        Http::assertSent(fn ($r) => str_contains($r->url(), '/transaction')
            && !isset($r['testing'])
            && $r['sign'] === md5('tester' . 'prod-key-456' . 'PL-2'));

        $this->actingAs($admin)->get(route('admin.ppob.index'))
            ->assertOk()->assertSee('Riwayat perubahan mode')->assertSee($admin->email)
            ->assertDontSee('prod-key-456'); // key tidak pernah ditampilkan utuh
    }

    public function test_cannot_switch_to_mode_without_api_key(): void
    {
        config(['services.digiflazz.api_keys.production' => '']);

        $this->actingAs($this->admin())->post(route('admin.ppob.mode'), ['mode' => 'production'])
            ->assertSessionHas('error');

        $this->assertSame('development', DigiflazzService::mode());
        $this->assertSame(0, AppSettingLog::where('key', DigiflazzService::MODE_SETTING_KEY)->where('new_value', 'production')->where('created_at', '>=', now()->subMinute())->count());
    }

    public function test_invalid_mode_and_guest_are_rejected(): void
    {
        $this->post(route('admin.ppob.mode'), ['mode' => 'production'])->assertRedirect(route('login'));

        $this->actingAs($this->admin())->post(route('admin.ppob.mode'), ['mode' => 'staging'])->assertSessionHasErrors('mode');
        $this->assertSame('development', DigiflazzService::mode());
    }

    public function test_setting_log_is_append_only(): void
    {
        AppSetting::put('test.key', 'a');
        $log = AppSettingLog::where('key', 'test.key')->latest('id')->firstOrFail();

        $this->expectException(\LogicException::class);
        $log->delete();
    }
}
