<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\DigiflazzService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdminDigiflazzDepositTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::forget('app_setting:' . DigiflazzService::MODE_SETTING_KEY);
        \App\Models\AppSetting::where('key', DigiflazzService::MODE_SETTING_KEY)->delete();
        config([
            'services.digiflazz.username' => 'tester',
            'services.digiflazz.mode' => 'production',
            'services.digiflazz.api_keys' => ['development' => 'dev-key-123', 'production' => 'prod-key-456'],
        ]);
        $this->admin = User::create(['name' => 'Admin', 'email' => 'adm_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => 'admin']);
    }

    protected function tearDown(): void
    {
        Cache::forget('app_setting:' . DigiflazzService::MODE_SETTING_KEY);
        parent::tearDown();
    }

    public function test_admin_creates_shopeepay_deposit_ticket_and_it_is_recorded(): void
    {
        Http::fake([
            // Bentuk balasan asli Digiflazz /deposit.
            '*/deposit' => Http::response(['data' => [
                'rc' => '00', 'bank' => 'ShopeePay (BCA)', 'payment_method' => 'Bank Transfer',
                'notes' => '', 'amount' => 200123, 'account_no' => '6042888890',
            ]]),
            '*' => Http::response(['data' => ['deposit' => 5000]]),
        ]);

        $this->actingAs($this->admin)->post(route('admin.ppob.deposit'), ['amount' => 200000, 'owner_name' => ' Andi Saputra '])
            ->assertRedirect()->assertSessionMissing('success'); // detail tampil di modal, bukan toast

        // Format request sesuai dokumentasi Digiflazz /deposit.
        Http::assertSent(fn ($r) => str_ends_with($r->url(), '/deposit')
            && $r['username'] === 'tester'
            && $r['amount'] === 200000
            && $r['Bank'] === 'ShopeePay'
            && $r['owner_name'] === 'Andi Saputra'
            && $r['sign'] === md5('tester' . 'prod-key-456' . 'deposit'));

        $this->assertSame([
            'amount' => 200123, 'account_no' => '6042888890', 'bank' => 'ShopeePay (BCA)',
            'payment_method' => 'Bank Transfer', 'notes' => null,
        ], session('deposit_ticket'));

        $this->assertFalse(\Illuminate\Support\Facades\Schema::hasTable('digiflazz_deposits')); // tidak disimpan ke DB

        $this->actingAs($this->admin)->withSession(['deposit_ticket' => session('deposit_ticket')])->get(route('admin.ppob.index'))
            ->assertOk()->assertSee('Deposit Saldo via ShopeePay')->assertSee('Tiket Deposit Dibuat')->assertSee('Rp 200.123')->assertSee('data-ticket-account>6042888890', false)
            ->assertSee('Nomor rekening disalin')->assertSee('ShopeePay (BCA)')->assertDontSee('Berita transfer')
            ->assertSee('Integrasi Digiflazz')->assertDontSee('PPOB');
    }

    public function test_rejected_ticket_is_recorded_as_failed(): void
    {
        Http::fake(['*/deposit' => Http::response(['data' => ['rc' => '41', 'message' => 'Signature Anda salah']], 400)]);

        $this->actingAs($this->admin)->post(route('admin.ppob.deposit'), ['amount' => 200000, 'owner_name' => 'Andi'])
            ->assertSessionHas('error', 'Tiket deposit gagal: Signature Anda salah');

        $this->assertNull(session('deposit_ticket'));
    }

    public function test_validation_and_guest_protection(): void
    {
        Http::fake();

        $this->post(route('admin.ppob.deposit'), ['amount' => 200000, 'owner_name' => 'Andi'])->assertRedirect(route('login'));
        $this->actingAs($this->admin)->post(route('admin.ppob.deposit'), ['amount' => 5000, 'owner_name' => ''])
            ->assertSessionHasErrors(['amount', 'owner_name']);

        Http::assertNothingSent();
    }

    public function test_modal_is_not_shown_without_new_ticket(): void
    {
        Http::fake(['*' => Http::response(['data' => ['deposit' => 5000]])]);

        $this->actingAs($this->admin)->get(route('admin.ppob.index'))
            ->assertOk()->assertDontSee('Tiket Deposit Dibuat')->assertSee('Cara deposit');
    }
}
