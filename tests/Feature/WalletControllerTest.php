<?php

namespace Tests\Feature;

use App\Models\Affiliate;
use App\Models\Wallet;
use App\Models\WalletDeposit;
use App\Services\ScalifyPayService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WalletControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected Affiliate $affiliate;
    protected Wallet $wallet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = Affiliate::firstOrCreate(
            ['email' => 'feature_test_partner@scalify.id'],
            [
                'name' => 'Feature Test Partner',
                'password' => bcrypt('password123'),
                'affiliate_code' => 'FEATUREWALLET' . rand(100, 999),
                'balance' => 0.00,
                'status' => 'approved',
            ]
        );

        $this->wallet = $this->affiliate->getOrCreateWallet();
    }

    /**
     * Test 1: Tamu (Guest) tanpa autentikasi tidak boleh mengakses rute wallet.
     */
    public function test_guest_cannot_access_wallet_routes(): void
    {
        $response = $this->get(route('affiliate.wallet.mutations'));
        $response->assertRedirect(route('affiliate.login'));

        $postResponse = $this->post(route('affiliate.wallet.deposit'), ['amount' => 50000]);
        $postResponse->assertRedirect(route('affiliate.login'));
    }

    /**
     * Test 2: Validasi nominal pengisian saldo minimal Rp 50.000.
     */
    public function test_deposit_validation_rejects_amount_below_50k(): void
    {
        $response = $this->actingAs($this->affiliate, 'affiliate')
            ->post(route('affiliate.wallet.deposit'), [
                'amount' => 25000, // Di bawah 50.000
            ]);

        $response->assertSessionHasErrors(['amount']);
    }

    /**
     * Test 3: Idempotency Guard pada depositStore.
     * Jika partner sudah memiliki tagihan pending aktif dengan nominal yang sama dalam 2 menit,
     * sistem tidak menembak gateway ulang tapi mengarahkan ke tagihan yang sudah ada.
     */
    public function test_deposit_store_idempotency_reuses_active_pending_invoice(): void
    {
        $existing = WalletDeposit::create([
            'deposit_no' => 'DEP-PENDING-' . rand(1000, 9999),
            'affiliate_id' => $this->affiliate->id,
            'wallet_id' => $this->wallet->id,
            'amount' => 50000.00,
            'fee' => 1000.00,
            'total_amount' => 51000.00,
            'payment_method' => 'qris',
            'payment_status' => 'pending',
            'payment_url' => 'https://api.sandbox.midtrans.com/v2/qris/dummy/qr-code',
            'expired_at' => now()->addMinutes(25),
        ]);

        $response = $this->actingAs($this->affiliate, 'affiliate')
            ->post(route('affiliate.wallet.deposit'), [
                'amount' => 50000,
            ]);

        // Harus diarahkan ke tagihan pending yang sudah ada
        $response->assertRedirect(route('affiliate.wallet.pay_qris', $existing->deposit_no));
        $response->assertSessionHas('info');
    }

    /**
     * Test 4: Endpoint checkDepositStatus mengembalikan data super lean sesuai kebutuhan UI saja.
     */
    public function test_check_deposit_status_returns_only_lean_ui_data(): void
    {
        $deposit = WalletDeposit::create([
            'deposit_no' => 'DEP-CHECK-' . rand(1000, 9999),
            'affiliate_id' => $this->affiliate->id,
            'wallet_id' => $this->wallet->id,
            'amount' => 50000.00,
            'fee' => 1000.00,
            'total_amount' => 51000.00,
            'payment_method' => 'qris',
            'payment_status' => 'pending',
            'expired_at' => now()->addMinutes(30),
        ]);

        $response = $this->actingAs($this->affiliate, 'affiliate')
            ->getJson(route('affiliate.wallet.deposit_check', $deposit->deposit_no));

        $response->assertOk()
            ->assertExactJson([
                'success' => true,
                'deposit_no' => $deposit->deposit_no,
                'payment_status' => 'pending',
                'is_paid' => false,
                'amount' => 50000.00,
                'wallet_balance' => (float) $this->wallet->balance,
            ]);
    }

    /**
     * Test 5: Endpoint mutations JSON mengembalikan field yang bersih dan spesifik untuk UI.
     */
    public function test_mutations_json_returns_only_ui_fields(): void
    {
        $this->wallet->credit(50000, 'DEPOSIT', 'Test Credit UI');

        $response = $this->actingAs($this->affiliate, 'affiliate')
            ->getJson(route('affiliate.wallet.mutations'));

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'wallet' => ['balance', 'status'],
                'mutations' => [
                    'data' => [
                        '*' => [
                            'mutation_no',
                            'type',
                            'amount',
                            'balance_after',
                            'category',
                            'description',
                            'date_human',
                        ]
                    ]
                ]
            ]);
    }
}

