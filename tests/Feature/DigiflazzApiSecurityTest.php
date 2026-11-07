<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DigiflazzApiSecurityTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake(['*' => Http::response(['data' => ['deposit' => 1000, 'rc' => '00']])]);
        config(['services.digiflazz.internal_token' => 'rahasia-internal-123']);
    }

    public static function internalEndpoints(): array
    {
        return [
            'cek saldo GET'  => ['GET', '/api/digiflazz/cek-saldo', []],
            'cek saldo POST' => ['POST', '/api/digiflazz/cek-saldo', []],
            'price list'     => ['POST', '/api/digiflazz/price-list', ['cmd' => 'prepaid']],
            'deposit'        => ['POST', '/api/digiflazz/deposit', ['amount' => 200000, 'bank' => 'ShopeePay', 'owner_name' => 'X']],
            'transaksi'      => ['POST', '/api/digiflazz/transaction', ['buyer_sku_code' => 'tsel5', 'customer_no' => '081234567890']],
            'ping webhook'   => ['POST', '/api/digiflazz/webhook/ping/123', []],
        ];
    }

    /** @dataProvider internalEndpoints */
    public function test_internal_endpoints_reject_requests_without_valid_token(string $method, string $uri, array $body): void
    {
        $this->json($method, $uri, $body)->assertStatus(401);
        $this->json($method, $uri, $body, ['X-Internal-Token' => 'salah'])->assertStatus(401);

        // Login admin (session) juga tidak cukup untuk endpoint API: harus token.
        $admin = User::create(['name' => 'A', 'email' => 'a_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => 'admin']);
        $this->actingAs($admin)->json($method, $uri, $body)->assertStatus(401);

        Http::assertNothingSent(); // tidak ada request ke Digiflazz sama sekali
    }

    public function test_valid_token_via_header_or_bearer_is_accepted(): void
    {
        $this->getJson('/api/digiflazz/cek-saldo', ['X-Internal-Token' => 'rahasia-internal-123'])->assertOk();
        $this->getJson('/api/digiflazz/cek-saldo', ['Authorization' => 'Bearer rahasia-internal-123'])->assertOk();
    }

    public function test_endpoints_are_disabled_when_token_not_configured(): void
    {
        config(['services.digiflazz.internal_token' => '']);

        $this->getJson('/api/digiflazz/cek-saldo', ['X-Internal-Token' => ''])
            ->assertStatus(401)->assertJsonPath('message', 'Endpoint dinonaktifkan: DIGIFLAZZ_INTERNAL_TOKEN belum diatur di server.');
    }

    public function test_webhook_stays_public_for_digiflazz(): void
    {
        config(['services.digiflazz.webhook_secret' => '']);
        $this->postJson('/api/digiflazz/webhook', ['hook_id' => 'abc'])->assertOk();
    }

    public function test_admin_refresh_uses_session_route_without_leaking_sign(): void
    {
        $this->getJson(route('admin.ppob.balance'))->assertUnauthorized();

        $admin = User::create(['name' => 'A', 'email' => 'a_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => 'admin']);
        $this->actingAs($admin)->getJson(route('admin.ppob.balance'))
            ->assertOk()->assertJsonPath('digiflazz_response.data.deposit', 1000)->assertJsonMissingPath('request_payload');
    }
}
