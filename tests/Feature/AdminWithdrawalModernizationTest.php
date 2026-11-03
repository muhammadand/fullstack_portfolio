<?php

namespace Tests\Feature;

use App\Models\Affiliate;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminWithdrawalModernizationTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;
    protected Affiliate $affiliate;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->admin = User::first() ?? User::create([
            'name' => 'Admin WD Test',
            'email' => 'admin_wd_test_' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->affiliate = Affiliate::create([
            'name' => 'Partner Tarik Dana',
            'email' => 'partner_wd_' . uniqid() . '@example.com',
            'password' => Hash::make('password123'),
            'status' => 'approved',
            'affiliate_code' => 'WD' . rand(100, 999),
            'bank_info' => 'BCA 88990011 a/n Partner',
            'balance' => 500000,
        ]);
    }

    public function test_withdrawals_index_renders_properly(): void
    {
        Withdrawal::create([
            'affiliate_id' => $this->affiliate->id,
            'amount' => 100000,
            'source' => Withdrawal::SOURCE_COMMISSION,
            'status' => Withdrawal::STATUS_PENDING,
            'bank_info' => $this->affiliate->bank_info,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.withdrawals.index'));
        $response->assertOk();
        $response->assertSee('Permintaan Penarikan');
        $response->assertSee('Total Permintaan');
        $response->assertSee('Menunggu Proses');
        $response->assertSee('Partner Tarik Dana');
        $response->assertSee('BCA 88990011');
    }

    public function test_withdrawals_index_search_and_filters(): void
    {
        $otherAffiliate = Affiliate::create([
            'name' => 'Other Unique Partner',
            'email' => 'other_wd_' . uniqid() . '@example.com',
            'password' => Hash::make('password123'),
            'status' => 'approved',
            'affiliate_code' => 'OTH' . rand(100, 999),
            'bank_info' => 'Mandiri 55443322',
        ]);

        $wd1 = Withdrawal::create([
            'affiliate_id' => $this->affiliate->id,
            'amount' => 150000,
            'source' => Withdrawal::SOURCE_COMMISSION,
            'status' => Withdrawal::STATUS_PENDING,
            'bank_info' => 'BCA 88990011',
        ]);

        $wd2 = Withdrawal::create([
            'affiliate_id' => $otherAffiliate->id,
            'amount' => 200000,
            'source' => Withdrawal::SOURCE_WALLET,
            'status' => Withdrawal::STATUS_COMPLETED,
            'bank_info' => 'Mandiri 55443322',
            'proof_of_payment' => 'withdrawals/fake_proof.jpg',
            'processed_at' => now(),
        ]);

        // Search query
        $resQ = $this->actingAs($this->admin)->get(route('admin.withdrawals.index', ['q' => 'Mandiri']));
        $resQ->assertOk();
        $resQ->assertSee('Mandiri 55443322');
        $resQ->assertDontSee('BCA 88990011');

        // Status filter
        $resPending = $this->actingAs($this->admin)->get(route('admin.withdrawals.index', ['status' => Withdrawal::STATUS_PENDING]));
        $resPending->assertOk();
        $resPending->assertSee('BCA 88990011');
        $resPending->assertDontSee('Mandiri 55443322');

        // Source filter
        $resWallet = $this->actingAs($this->admin)->get(route('admin.withdrawals.index', ['source' => Withdrawal::SOURCE_WALLET]));
        $resWallet->assertOk();
        $resWallet->assertSee('Mandiri 55443322');
        $resWallet->assertDontSee('BCA 88990011');
    }

    public function test_withdrawals_approve_with_proof(): void
    {
        $withdrawal = Withdrawal::create([
            'affiliate_id' => $this->affiliate->id,
            'amount' => 75000,
            'source' => Withdrawal::SOURCE_WALLET,
            'status' => Withdrawal::STATUS_PENDING,
            'bank_info' => $this->affiliate->bank_info,
        ]);

        $file = UploadedFile::fake()->image('bukti_tf.jpg', 600, 400);

        $response = $this->actingAs($this->admin)->post(route('admin.withdrawals.approve', $withdrawal->id), [
            'proof' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $withdrawal->refresh();
        $this->assertEquals(Withdrawal::STATUS_COMPLETED, $withdrawal->status);
        $this->assertNotNull($withdrawal->proof_of_payment);
        $this->assertNotNull($withdrawal->processed_at);
        Storage::disk('public')->assertExists($withdrawal->proof_of_payment);
    }
}

