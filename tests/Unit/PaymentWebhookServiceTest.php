<?php

namespace Tests\Unit;

use App\Models\Affiliate;
use App\Models\PaymentCallback;
use App\Models\Wallet;
use App\Models\WalletDeposit;
use App\Models\WalletMutation;
use App\Services\PaymentWebhookService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PaymentWebhookServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected PaymentWebhookService $service;
    protected Affiliate $affiliate;
    protected Wallet $wallet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(PaymentWebhookService::class);

        $this->affiliate = Affiliate::firstOrCreate(
            ['email' => 'webhook_test_partner@scalify.id'],
            [
                'name' => 'Webhook Test Partner',
                'password' => bcrypt('password123'),
                'affiliate_code' => 'WEBHOOKTEST' . rand(100, 999),
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
     * Test 1: Ekstraksi dan normalisasi payload mendukung format Midtrans dan ScalifyPay
     */
    public function test_extract_payload_normalizes_various_gateway_formats(): void
    {
        // Format Midtrans
        $midtransPayload = [
            'order_id' => 'DEP-20261102-001',
            'transaction_id' => 'trx-midtrans-999',
            'transaction_status' => 'settlement',
            'status_code' => '200',
            'gross_amount' => '50000.00',
            'signature_key' => 'dummy-sha-signature',
        ];
        $extracted = $this->service->extractPayload($midtransPayload);
        $this->assertEquals('DEP-20261102-001', $extracted['order_number']);
        $this->assertEquals('trx-midtrans-999', $extracted['transaction_id']);
        $this->assertEquals('settlement', $extracted['transaction_status']);

        // Format ScalifyPay / Gateway alternatif
        $scalifyPayload = [
            'order_number' => 'DEP-20261102-002',
            'id' => 'scalify-trx-123',
            'status' => 'paid',
            'amount' => '100000',
        ];
        $extractedScalify = $this->service->extractPayload($scalifyPayload);
        $this->assertEquals('DEP-20261102-002', $extractedScalify['order_number']);
        $this->assertEquals('scalify-trx-123', $extractedScalify['transaction_id']);
        $this->assertEquals('paid', $extractedScalify['transaction_status']);
    }

    /**
     * Test 2: Validasi signature SHA-512 Midtrans (lolos jika valid, ditolak jika palsu)
     */
    public function test_signature_verification_succeeds_with_valid_hash_and_rejects_invalid(): void
    {
        config(['services.midtrans.server_key' => 'SB-Mid-server-TESTKEY123']);

        $orderId = 'DEP-SIGNATURE-TEST';
        $statusCode = '200';
        $grossAmount = '51000.00';
        $validHash = hash('sha512', $orderId . $statusCode . $grossAmount . 'SB-Mid-server-TESTKEY123');

        $this->assertTrue(
            $this->service->verifySignature($orderId, $statusCode, $grossAmount, $validHash)
        );

        $this->assertFalse(
            $this->service->verifySignature($orderId, $statusCode, $grossAmount, 'invalid-signature-hash')
        );
    }

    /**
     * Test 3: Webhook ditolak dengan status 422 jika order_number / order_id kosong
     */
    public function test_webhook_returns_422_when_order_identifier_is_missing(): void
    {
        $result = $this->service->handle([
            'transaction_status' => 'settlement',
            'gross_amount' => '50000',
        ]);

        $this->assertEquals(422, $result['status']);
        $this->assertFalse($result['data']['success']);
        $this->assertStringContainsString('identifier is missing', $result['data']['message']);
    }

    /**
     * Test 4: Webhook ditolak dengan status 403 jika signature tidak cocok
     */
    public function test_webhook_returns_403_when_signature_is_invalid(): void
    {
        config(['services.midtrans.server_key' => 'SB-Mid-server-TESTKEY123']);

        $result = $this->service->handle([
            'order_id' => 'DEP-INVALID-SIG',
            'status_code' => '200',
            'gross_amount' => '50000.00',
            'signature_key' => 'fake-signature-key-12345',
            'transaction_status' => 'settlement',
        ]);

        $this->assertEquals(403, $result['status']);
        $this->assertFalse($result['data']['success']);
        $this->assertStringContainsString('Invalid signature', $result['data']['message']);
    }

    /**
     * Test 5: Webhook sukses melunaskan WalletDeposit, mengkredit saldo, dan strictly idempotent (Anti Double-Credit)
     */
    public function test_wallet_deposit_webhook_settlement_is_atomic_and_strictly_idempotent(): void
    {
        // Pastikan signature check tidak memblokir test ini
        config(['services.midtrans.server_key' => null]);

        $deposit = WalletDeposit::create([
            'deposit_no' => 'DEP-' . date('YmdHis') . '-TEST',
            'affiliate_id' => $this->affiliate->id,
            'wallet_id' => $this->wallet->id,
            'amount' => 75000.00,
            'fee' => 1500.00,
            'unique_code' => 0,
            'total_amount' => 76500.00,
            'payment_method' => 'qris',
            'payment_status' => 'pending',
        ]);

        $payload = [
            'order_id' => $deposit->deposit_no,
            'transaction_id' => 'TRX-PAY-777',
            'transaction_status' => 'settlement',
            'status_code' => '200',
            'gross_amount' => '76500.00',
        ];

        // 1. Eksekusi pertama: harus melunasi deposit & menambah saldo wallet Rp 75.000
        $result = $this->service->handle($payload);

        $this->assertEquals(200, $result['status']);
        $this->assertTrue($result['data']['success']);

        $deposit->refresh();
        $this->wallet->refresh();

        $this->assertEquals('paid', $deposit->payment_status);
        $this->assertEquals(75000.00, (float) $this->wallet->balance);

        $mutation = WalletMutation::where('wallet_id', $this->wallet->id)->first();
        $this->assertNotNull($mutation);
        $this->assertEquals('CREDIT', $mutation->type);
        $this->assertEquals(75000.00, (float) $mutation->amount);

        // 2. Eksekusi kedua (simulasi webhook retry / duplikasi dari gateway):
        // Saldo TIDAK BOLEH bertambah lagi (Strict Idempotency Guard)
        $retryResult = $this->service->handle($payload);

        $this->assertEquals(200, $retryResult['status']);

        $this->wallet->refresh();
        $this->assertEquals(75000.00, (float) $this->wallet->balance, 'Saldo tidak boleh terisi dua kali!');
        $this->assertEquals(1, WalletMutation::where('wallet_id', $this->wallet->id)->count());
    }

    /**
     * Test 6: Webhook mengubah status menjadi 'expired' jika transaksi kedaluwarsa
     */
    public function test_wallet_deposit_webhook_marks_as_expired(): void
    {
        config(['services.midtrans.server_key' => null]);

        $deposit = WalletDeposit::create([
            'deposit_no' => 'DEP-EXPIRE-TEST',
            'affiliate_id' => $this->affiliate->id,
            'wallet_id' => $this->wallet->id,
            'amount' => 50000.00,
            'fee' => 1000.00,
            'unique_code' => 0,
            'total_amount' => 51000.00,
            'payment_method' => 'qris',
            'payment_status' => 'pending',
        ]);

        $result = $this->service->handle([
            'order_id' => $deposit->deposit_no,
            'transaction_status' => 'expire',
        ]);

        $this->assertEquals(200, $result['status']);
        $deposit->refresh();
        $this->assertEquals('expired', $deposit->payment_status);
    }

    /**
     * Test 7: Webhook mengubah status menjadi 'failed' jika transaksi cancel atau deny
     */
    public function test_wallet_deposit_webhook_marks_as_failed(): void
    {
        config(['services.midtrans.server_key' => null]);

        $deposit = WalletDeposit::create([
            'deposit_no' => 'DEP-FAIL-TEST',
            'affiliate_id' => $this->affiliate->id,
            'wallet_id' => $this->wallet->id,
            'amount' => 50000.00,
            'fee' => 1000.00,
            'unique_code' => 0,
            'total_amount' => 51000.00,
            'payment_method' => 'qris',
            'payment_status' => 'pending',
        ]);

        $result = $this->service->handle([
            'order_id' => $deposit->deposit_no,
            'transaction_status' => 'cancel',
        ]);

        $this->assertEquals(200, $result['status']);
        $deposit->refresh();
        $this->assertEquals('failed', $deposit->payment_status);
    }

    /**
     * Test 8: Memastikan setiap webhook mentah selalu tercatat di tabel payment_callbacks
     */
    public function test_webhook_creates_raw_audit_record_in_payment_callbacks_table(): void
    {
        config(['services.midtrans.server_key' => null]);

        $orderId = 'DEP-AUDIT-' . rand(1000, 9999);
        $result = $this->service->handle([
            'order_id' => $orderId,
            'transaction_id' => 'trx-audit-123',
            'transaction_status' => 'pending',
        ]);

        $this->assertEquals(200, $result['status']);

        $callback = PaymentCallback::where('order_number', $orderId)->first();
        $this->assertNotNull($callback);
        $this->assertEquals('trx-audit-123', $callback->transaction_id);
        $this->assertEquals('pending', $callback->transaction_status);
    }
}

