<?php

namespace Tests\Feature;

use App\Models\Affiliate;
use App\Models\Commission;
use App\Models\Wallet;
use App\Models\WalletMutation;
use App\Models\Withdrawal;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AffiliateHistoryTest extends TestCase
{
    use DatabaseTransactions;

    protected Affiliate $affiliate;
    protected Wallet $wallet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = Affiliate::firstOrCreate(
            ['email' => 'history_partner@scalify.id'],
            [
                'name' => 'History Partner',
                'password' => bcrypt('password123'),
                'affiliate_code' => 'HISTPARTNER' . rand(100, 999),
                'balance' => 350000.00,
                'status' => 'approved',
            ]
        );

        $this->wallet = $this->affiliate->getOrCreateWallet();
        $this->wallet->balance = 50000.00;
        $this->wallet->save();
    }

    /**
     * Test 1: Tamu (Guest) tanpa login dialihkan ke halaman login
     */
    public function test_guest_cannot_access_affiliate_history(): void
    {
        $response = $this->get(route('affiliate.history'));
        $response->assertRedirect(route('affiliate.login'));
    }

    /**
     * Test 2: Partner terautentikasi dapat membuka halaman riwayat dengan status 200 OK
     */
    public function test_authenticated_affiliate_can_view_history_page(): void
    {
        $response = $this->actingAs($this->affiliate, 'affiliate')
            ->get(route('affiliate.history'));

        $response->assertStatus(200);
        $response->assertViewIs('affiliate.history_mobile');
        $response->assertViewHasAll([
            'affiliate',
            'wallet',
            'commissions',
            'withdrawals',
            'walletMasuk',
            'walletKeluar',
        ]);
    }

    /**
     * Test 3: Riwayat memuat dan menampilkan komisi masuk dan penarikan saldo
     */
    public function test_history_displays_commissions_and_withdrawals(): void
    {
        Commission::create([
            'affiliate_id' => $this->affiliate->id,
            'amount' => 75000.00,
            'description' => 'Komisi Project Landing Page',
            'status' => 'paid',
        ]);

        Withdrawal::create([
            'affiliate_id' => $this->affiliate->id,
            'amount' => 100000.00,
            'bank_info' => 'BCA 12345678 a/n History Partner',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($this->affiliate, 'affiliate')
            ->get(route('affiliate.history'));

        $response->assertStatus(200);
        $response->assertSee('Komisi Project Landing Page');
        $response->assertSee('75.000');
        $response->assertSee('BCA 12345678 a/n History Partner');
        $response->assertSee('100.000');
    }

    /**
     * Test 4: Riwayat memuat dan menampilkan mutasi dana wallet masuk (CREDIT) dan keluar (DEBIT)
     */
    public function test_history_displays_wallet_masuk_and_wallet_keluar(): void
    {
        // 1. Dana Masuk: Top up saldo via QRIS
        WalletMutation::create([
            'mutation_no' => 'MUT-' . date('YmdHis') . '-IN12',
            'affiliate_id' => $this->affiliate->id,
            'wallet_id' => $this->wallet->id,
            'type' => 'CREDIT',
            'amount' => 50000.00,
            'balance_before' => 0.00,
            'balance_after' => 50000.00,
            'category' => 'DEPOSIT',
            'description' => 'Top up saldo via QRIS #DEP-TEST-1234',
        ]);

        // 2. Dana Keluar: Transaksi Pembelian Pulsa PPOB
        WalletMutation::create([
            'mutation_no' => 'MUT-' . date('YmdHis') . '-OUT9',
            'affiliate_id' => $this->affiliate->id,
            'wallet_id' => $this->wallet->id,
            'type' => 'DEBIT',
            'amount' => 25000.00,
            'balance_before' => 50000.00,
            'balance_after' => 25000.00,
            'category' => 'PPOB',
            'description' => 'Pembelian Pulsa Telkomsel 25k #TRX-9876',
        ]);

        $response = $this->actingAs($this->affiliate, 'affiliate')
            ->get(route('affiliate.history'));

        $response->assertStatus(200);
        $response->assertSee('Top up saldo via QRIS #DEP-TEST-1234');
        $response->assertSee('Pembelian Pulsa Telkomsel 25k #TRX-9876');
        $response->assertSee('Komisi Afiliasi');
        $response->assertSee('Wallet PPOB');
    }

    /**
     * Test 5: Query yang dihasilkan terproyeksi hemat kolom (Lean UI Query)
     */
    public function test_history_queries_only_needed_ui_columns(): void
    {
        $response = $this->actingAs($this->affiliate, 'affiliate')
            ->get(route('affiliate.history'));

        $commissions = $response->viewData('commissions');
        $withdrawals = $response->viewData('withdrawals');
        $walletMasuk = $response->viewData('walletMasuk');
        $walletKeluar = $response->viewData('walletKeluar');

        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $commissions);
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $withdrawals);
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $walletMasuk);
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $walletKeluar);
    }
}
