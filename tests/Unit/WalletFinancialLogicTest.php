<?php

namespace Tests\Unit;

use App\Models\Affiliate;
use App\Models\Wallet;
use App\Models\WalletDeposit;
use App\Models\WalletMutation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WalletFinancialLogicTest extends TestCase
{
    use DatabaseTransactions;

    protected Affiliate $affiliate;
    protected Wallet $wallet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = Affiliate::firstOrCreate(
            ['email' => 'unit_test_partner@scalify.id'],
            [
                'name' => 'Unit Test Partner',
                'password' => bcrypt('password123'),
                'affiliate_code' => 'TESTWALLET' . rand(100, 999),
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
     * Test 1: Penambahan saldo (Credit) harus atomik dan mencatat riwayat mutasi dengan saldo sebelum & sesudah yang tepat.
     */
    public function test_wallet_credit_is_atomic_and_creates_accurate_mutation_ledger(): void
    {
        $mutation = $this->wallet->credit(50000, 'DEPOSIT', 'Test Deposit Credit');

        $this->wallet->refresh();

        $this->assertEquals(50000.00, (float) $this->wallet->balance);
        $this->assertInstanceOf(WalletMutation::class, $mutation);
        $this->assertEquals('CREDIT', $mutation->type);
        $this->assertEquals(50000.00, (float) $mutation->amount);
        $this->assertEquals(0.00, (float) $mutation->balance_before);
        $this->assertEquals(50000.00, (float) $mutation->balance_after);
        $this->assertStringStartsWith('MUT-', $mutation->mutation_no);
    }

    /**
     * Test 2: Pengurangan saldo (Debit) harus mengurangi saldo dan mencatat mutasi DEBIT.
     */
    public function test_wallet_debit_is_atomic_and_decreases_balance(): void
    {
        // Berikan saldo awal Rp 100.000
        $this->wallet->credit(100000, 'DEPOSIT', 'Initial Balance');

        // Lakukan debit Rp 35.000 (contoh order PPOB)
        $mutation = $this->wallet->debit(35000, 'PPOB_ORDER', 'Order Pulsa 35k');

        $this->wallet->refresh();

        $this->assertEquals(65000.00, (float) $this->wallet->balance);
        $this->assertEquals('DEBIT', $mutation->type);
        $this->assertEquals(35000.00, (float) $mutation->amount);
        $this->assertEquals(100000.00, (float) $mutation->balance_before);
        $this->assertEquals(65000.00, (float) $mutation->balance_after);
    }

    /**
     * Test 3: Pengurangan saldo harus menolak dan melempar Exception jika saldo tidak mencukupi (Anti Double-Spend / Minus).
     */
    public function test_wallet_debit_fails_and_throws_exception_on_insufficient_balance(): void
    {
        $this->wallet->credit(20000, 'DEPOSIT', 'Initial Balance');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Saldo wallet tidak mencukupi untuk transaksi ini.');

        // Coba debit Rp 50.000 padahal saldo cuma Rp 20.000
        $this->wallet->debit(50000, 'PPOB_ORDER', 'Overspend Attempt');
    }

    /**
     * Test 4: Idempotensi markAsPaid pada WalletDeposit.
     * Memanggil markAsPaid berkali-kali HANYA mengkreditkan saldo sekali saja (Zero Double-Credit).
     */
    public function test_wallet_deposit_mark_as_paid_is_strictly_idempotent(): void
    {
        $deposit = WalletDeposit::create([
            'deposit_no' => 'DEP-IDEMPOTENT-TEST-' . rand(1000, 9999),
            'affiliate_id' => $this->affiliate->id,
            'wallet_id' => $this->wallet->id,
            'amount' => 50000.00,
            'fee' => 1000.00,
            'unique_code' => 0,
            'total_amount' => 51000.00,
            'payment_method' => 'qris',
            'payment_status' => 'pending',
            'expired_at' => now()->addMinutes(30),
        ]);

        // Panggilan 1: Berhasil diproses
        $firstCall = $deposit->markAsPaid('TX-REF-01', ['status' => 'settlement']);
        $this->assertTrue($firstCall);

        $this->wallet->refresh();
        $this->assertEquals(50000.00, (float) $this->wallet->balance);
        $this->assertEquals('paid', $deposit->payment_status);

        // Panggilan 2 (Simulasi Webhook retry / duplicate request simultan)
        $secondCall = $deposit->markAsPaid('TX-REF-01', ['status' => 'settlement']);
        $this->assertFalse($secondCall); // Harus false (no-op idempoten)

        // Panggilan 3
        $thirdCall = $deposit->markAsPaid('TX-REF-01', ['status' => 'settlement']);
        $this->assertFalse($thirdCall);

        // Verifikasi saldo TETAP Rp 50.000 (TIDAK menjadi Rp 100.000 atau Rp 150.000)
        $this->wallet->refresh();
        $this->assertEquals(50000.00, (float) $this->wallet->balance);

        // Verifikasi mutasi hanya ada 1 record
        $mutationsCount = $this->wallet->mutations()->where('category', 'DEPOSIT')->count();
        $this->assertEquals(1, $mutationsCount);
    }
}

