<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdminPpobModernizationTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::first() ?? User::create([
            'name' => 'Admin PPOB Test',
            'email' => 'admin_ppob_' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }

    public function test_guest_is_redirected_from_ppob_page(): void
    {
        $response = $this->get(route('admin.ppob.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_ppob_page_with_standardized_components(): void
    {
        Http::fake([
            '*/cek-saldo' => Http::response([
                'data' => [
                    'deposit' => 250000,
                ],
            ], 200),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.ppob.index'));
        $response->assertOk();
        $response->assertSee('Integrasi Digiflazz');
        $response->assertDontSee('PPOB');
        $response->assertSee('Saldo Deposit Digiflazz');
        $response->assertSee('Username API');
        $response->assertSee('Production');
        $response->assertSee('/api/digiflazz/webhook');
        $response->assertSee('Live JSON Response Inspector');
        $response->assertSee('Deposit Saldo via ShopeePay');
    }

    public function test_api_cek_saldo_returns_exact_structure(): void
    {
        Http::fake([
            '*/cek-saldo' => Http::response([
                'data' => [
                    'deposit' => 0,
                ],
            ], 200),
        ]);

        config(['services.digiflazz.internal_token' => 'token-uji']);
        $response = $this->getJson(route('digiflazz.cek_saldo'), ['X-Internal-Token' => 'token-uji']);
        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'http_status' => 200,
            'request_payload' => [
                'cmd' => 'deposit',
            ],
            'digiflazz_response' => [
                'data' => [
                    'deposit' => 0,
                ],
            ],
        ]);
    }
}

