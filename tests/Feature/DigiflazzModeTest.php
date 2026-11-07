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

        Http::assertSent(fn($r) => str_contains($r->url(), '/transaction')
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
        Http::assertSent(fn($r) => str_contains($r->url(), '/transaction')
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

    public function test_legacy_single_production_key_without_prefix_is_used_in_production_mode(): void
    {
        // Server lama: hanya DIGIFLAZZ_API_KEY berisi key production (key production Digiflazz tanpa awalan).
        $saved = [];
        foreach (['DIGIFLAZZ_API_KEY' => 'a1b2c3d4-0000-1111-2222-333344445555', 'DIGIFLAZZ_DEV_API_KEY' => null, 'DIGIFLAZZ_PROD_API_KEY' => null, 'DIGIFLAZZ_MODE' => null] as $k => $v) {
            $saved[$k] = $_ENV[$k] ?? null;
            if ($v === null) {
                unset($_ENV[$k], $_SERVER[$k]);
                putenv($k);
            } else {
                $_ENV[$k] = $_SERVER[$k] = $v;
                putenv("$k=$v");
            }
        }

        try {
            $digiflazz = (require config_path('services.php'))['digiflazz'];
        } finally {
            foreach ($saved as $k => $v) {
                if ($v === null) {
                    unset($_ENV[$k], $_SERVER[$k]);
                    putenv($k);
                } else {
                    $_ENV[$k] = $_SERVER[$k] = $v;
                    putenv("$k=$v");
                }
            }
        }

        $this->assertSame('', $digiflazz['api_keys']['development']);
        $this->assertSame('a1b2c3d4-0000-1111-2222-333344445555', $digiflazz['api_keys']['production']);
        $this->assertNull($digiflazz['mode']);

        config(['services.digiflazz.mode' => $digiflazz['mode'], 'services.digiflazz.api_keys' => $digiflazz['api_keys']]);
        $this->assertSame('production', DigiflazzService::mode()); // otomatis production, bukan development tanpa key
        $this->assertSame('a1b2c3d4-0000-1111-2222-333344445555', DigiflazzService::getApiKey());
    }

    public function test_admin_choice_overrides_automatic_mode(): void
    {
        config(['services.digiflazz.mode' => null]);
        $this->assertSame('development', DigiflazzService::mode()); // dua key ada -> aman ke development

        $this->actingAs($this->admin())->post(route('admin.ppob.mode'), ['mode' => 'production']);
        $this->assertSame('production', DigiflazzService::mode());
    }

    public function test_cek_saldo_endpoint_can_target_each_mode(): void
    {
        config(['services.digiflazz.internal_token' => 'token-uji']);
        $this->withHeader('X-Internal-Token', 'token-uji');

        $this->getJson('/api/digiflazz/cek-saldo?mode=production')->assertOk()->assertJsonPath('mode', 'production');
        Http::assertSent(fn ($r) => str_contains($r->url(), '/cek-saldo') && $r['sign'] === md5('tester' . 'prod-key-456' . 'depo'));

        $this->getJson('/api/digiflazz/cek-saldo?mode=development')->assertOk()->assertJsonPath('mode', 'development');
        Http::assertSent(fn ($r) => str_contains($r->url(), '/cek-saldo') && $r['sign'] === md5('tester' . 'dev-key-123' . 'depo'));

        // Tanpa parameter = mode aktif.
        $this->getJson('/api/digiflazz/cek-saldo')->assertOk()->assertJsonPath('mode', 'development');

        $this->getJson('/api/digiflazz/cek-saldo?mode=staging')->assertStatus(422);

        config(['services.digiflazz.api_keys.production' => '']);
        $this->getJson('/api/digiflazz/cek-saldo?mode=production')->assertStatus(422)->assertJsonPath('mode', 'production');
    }
}
