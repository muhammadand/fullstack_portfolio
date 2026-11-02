<?php

namespace Tests\Feature;

use App\Models\Affiliate;
use App\Models\PaymentCallback;
use App\Models\Wallet;
use App\Models\WalletDeposit;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PaymentCallbackControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected Affiliate $affiliate;
    protected Wallet $wallet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = Affiliate::firstOrCreate(
            ['email' => 'feature_webhook_partner@scalify.id'],
            [
                'name' => 'Feature Webhook Partner',
                'password' => bcrypt('password123'),
                'affiliate_code' => 'WEBHOOKFEAT' . rand(100, 999),
                'balance' => 0.00,
                'status' => 'approved',
            ]
        );

        $this->wallet = $this->affiliate->getOrCreateWallet();
        $this->wallet->balance = 0.00;
        $this->wallet->save();
        $this->wallet->mutations()->delete();
        $this->wallet->deposits()->delete();
    }

    /**
     * Test 1: Permintaan webhook tanpa order_id atau order_number menghasilkan HTTP 422 Unprocessable Entity
     */
    public function test_post_webhook_returns_422_when_order_id_is_missing(): void
    {
        $response = $this->postJson('/payment/callback', [
            'transaction_status' => 'settlement',
            'gross_amount' => '50000.00',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Order identifier is missing.',
            ]);
    }

    /**
     * Test 2: Permintaan webhook dengan signature SHA-512 tidak valid menghasilkan HTTP 403 Forbidden
     */
    public function test_post_webhook_returns_403_when_signature_is_invalid(): void
    {
        config(['services.midtrans.server_key' => 'MIDTRANS-TEST-SECRET']);

        $response = $this->postJson('/payment/callback', [
            'order_id' => 'DEP-SIG-TEST',
            'status_code' => '200',
            'gross_amount' => '51000.00',
            'signature_key' => 'invalid-fake-signature',
            'transaction_status' => 'settlement',
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid signature key.',
            ]);
    }

    /**
     * Test 3: Endpoint POST /payment/callback berhasil memproses pelunasan WalletDeposit
     */
    public function test_post_payment_callback_settles_wallet_deposit_successfully(): void
    {
        config(['services.midtrans.server_key' => null]);

        $deposit = WalletDeposit::create([
            'deposit_no' => 'DEP-' . date('YmdHis') . '-HTTP',
            'affiliate_id' => $this->affiliate->id,
            'wallet_id' => $this->wallet->id,
            'amount' => 100000.00,
            'fee' => 2000.00,
            'unique_code' => 0,
            'total_amount' => 102000.00,
            'payment_method' => 'qris',
            'payment_status' => 'pending',
        ]);

        $response = $this->postJson('/payment/callback', [
            'order_id' => $deposit->deposit_no,
            'transaction_id' => 'TRX-HTTP-12345',
            'transaction_status' => 'settlement',
            'status_code' => '200',
            'gross_amount' => '102000.00',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Payment callback stored successfully.',
                'data' => [
                    'order_number' => $deposit->deposit_no,
                    'transaction_id' => 'TRX-HTTP-12345',
                    'transaction_status' => 'settlement',
                    'order_updated' => true,
                ],
            ]);

        $deposit->refresh();
        $this->wallet->refresh();

        $this->assertEquals('paid', $deposit->payment_status);
        $this->assertEquals(100000.00, (float) $this->wallet->balance);

        // Pastikan tersimpan di audit trail payment_callbacks
        $this->assertDatabaseHas('payment_callbacks', [
            'order_number' => $deposit->deposit_no,
            'transaction_id' => 'TRX-HTTP-12345',
            'transaction_status' => 'settlement',
        ]);
    }

    /**
     * Test 4: Webhook berulang lewat HTTP tetap idempoten dan tidak menduplikasi saldo
     */
    public function test_post_payment_callback_is_strictly_idempotent_via_http(): void
    {
        config(['services.midtrans.server_key' => null]);

        $deposit = WalletDeposit::create([
            'deposit_no' => 'DEP-' . date('YmdHis') . '-DUP',
            'affiliate_id' => $this->affiliate->id,
            'wallet_id' => $this->wallet->id,
            'amount' => 50000.00,
            'fee' => 1000.00,
            'unique_code' => 0,
            'total_amount' => 51000.00,
            'payment_method' => 'qris',
            'payment_status' => 'pending',
        ]);

        $payload = [
            'order_id' => $deposit->deposit_no,
            'transaction_id' => 'TRX-DUP-999',
            'transaction_status' => 'settlement',
            'status_code' => '200',
            'gross_amount' => '51000.00',
        ];

        // Hit pertama
        $this->postJson('/payment/callback', $payload)->assertStatus(200);
        $this->wallet->refresh();
        $this->assertEquals(50000.00, (float) $this->wallet->balance);

        // Hit kedua (Retry webhook dari gateway)
        $this->postJson('/payment/callback', $payload)->assertStatus(200);
        $this->wallet->refresh();
        $this->assertEquals(50000.00, (float) $this->wallet->balance, 'Saldo tidak boleh terisi dua kali!');
    }

    /**
     * Test 5: Route alias /webhook/payment dan /api/v1/payments/webhook berfungsi dengan baik
     */
    public function test_webhook_route_aliases_work_properly(): void
    {
        config(['services.midtrans.server_key' => null]);

        $responseWeb = $this->postJson('/webhook/payment', [
            'order_id' => 'DEP-ALIAS-WEB-' . rand(100, 999),
            'transaction_status' => 'pending',
        ]);
        $responseWeb->assertStatus(200);

        $responseApi = $this->postJson('/api/v1/payments/webhook', [
            'order_id' => 'DEP-ALIAS-API-' . rand(100, 999),
            'transaction_status' => 'pending',
        ]);
        $responseApi->assertStatus(200);
    }
}

