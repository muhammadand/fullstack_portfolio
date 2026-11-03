<?php

namespace Tests\Feature;

use App\Livewire\Affiliate\WithdrawPage;
use App\Models\Affiliate;
use App\Models\Wallet;
use App\Models\WalletMutation;
use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AffiliateWithdrawTest extends TestCase
{
    use DatabaseTransactions;

    protected Affiliate $affiliate;
    protected Wallet $wallet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = Affiliate::create([
            'name' => 'Withdraw Partner',
            'email' => 'withdraw_partner_' . uniqid() . '@scalify.id',
            'password' => bcrypt('password123'),
            'affiliate_code' => 'WDPARTNER' . rand(1000, 9999),
            'balance' => 300000.00,
            'bank_info' => 'BCA 1234567890 a/n Withdraw Partner',
            'status' => 'approved',
        ]);

        $this->wallet = $this->affiliate->getOrCreateWallet();
        $this->wallet->update(['balance' => 200000.00]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('affiliate.withdraw'))->assertRedirect(route('affiliate.login'));
    }

    public function test_affiliate_can_open_withdraw_page(): void
    {
        $this->actingAs($this->affiliate, 'affiliate')
            ->get(route('affiliate.withdraw'))
            ->assertOk()
            ->assertSeeLivewire(WithdrawPage::class)
            ->assertSee('BCA 1234567890');
    }

    public function test_can_withdraw_from_commission_balance(): void
    {
        $this->actingAs($this->affiliate, 'affiliate');

        Livewire::test(WithdrawPage::class)
            ->set('source', 'commission')
            ->set('amount', '100000')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('amount', '')
            ->assertNotSet('submitted', null);

        $this->assertEquals(200000, (float) $this->affiliate->fresh()->balance);
        $this->assertEquals(200000, (float) $this->wallet->fresh()->balance, 'Saldo wallet tidak boleh berubah');
        $this->assertDatabaseHas('withdrawals', [
            'affiliate_id' => $this->affiliate->id,
            'source' => 'commission',
            'amount' => 100000,
            'status' => 'Pending',
            'bank_info' => 'BCA 1234567890 a/n Withdraw Partner',
        ]);
    }

    public function test_can_withdraw_from_wallet_balance_and_records_mutation(): void
    {
        $this->actingAs($this->affiliate, 'affiliate');

        Livewire::test(WithdrawPage::class, ['source' => 'wallet'])
            ->set('source', 'wallet')
            ->set('amount', '150000')
            ->call('submit')
            ->assertHasNoErrors();

        $withdrawal = Withdrawal::where('affiliate_id', $this->affiliate->id)->latest('id')->first();

        $this->assertSame('wallet', $withdrawal->source);
        $this->assertEquals(50000, (float) $this->wallet->fresh()->balance);
        $this->assertEquals(300000, (float) $this->affiliate->fresh()->balance, 'Saldo komisi tidak boleh berubah');

        $mutation = WalletMutation::where('reference_type', Withdrawal::class)
            ->where('reference_id', $withdrawal->id)
            ->first();
        $this->assertNotNull($mutation);
        $this->assertSame('DEBIT', $mutation->type);
        $this->assertSame('WITHDRAWAL', $mutation->category);
    }

    public function test_cannot_withdraw_more_than_balance(): void
    {
        $this->actingAs($this->affiliate, 'affiliate');

        Livewire::test(WithdrawPage::class)
            ->set('source', 'wallet')
            ->set('amount', '250000')
            ->call('submit')
            ->assertHasErrors('amount');

        $this->assertEquals(200000, (float) $this->wallet->fresh()->balance);
        $this->assertDatabaseMissing('withdrawals', ['affiliate_id' => $this->affiliate->id]);
    }

    public function test_cannot_withdraw_below_minimum(): void
    {
        $this->actingAs($this->affiliate, 'affiliate');

        Livewire::test(WithdrawPage::class)
            ->set('amount', '10000')
            ->call('submit')
            ->assertHasErrors(['amount' => 'min']);
    }

    public function test_cannot_withdraw_without_bank_info(): void
    {
        $this->affiliate->update(['bank_info' => null]);
        $this->actingAs($this->affiliate, 'affiliate');

        Livewire::test(WithdrawPage::class)
            ->set('amount', '100000')
            ->call('submit')
            ->assertHasErrors('amount');

        $this->assertEquals(300000, (float) $this->affiliate->fresh()->balance);
    }

    public function test_admin_approval_marks_withdrawal_completed(): void
    {
        Storage::fake('public');

        $withdrawal = Withdrawal::create([
            'affiliate_id' => $this->affiliate->id,
            'source' => 'wallet',
            'amount' => 100000,
            'bank_info' => $this->affiliate->bank_info,
            'status' => 'Pending',
        ]);

        $admin = User::first() ?? User::create([
            'name' => 'Admin Withdraw Test',
            'email' => 'admin_wd_test_' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.withdrawals.approve', $withdrawal), [
                'proof' => UploadedFile::fake()->image('bukti.jpg'),
            ])
            ->assertSessionHas('success');

        $withdrawal->refresh();
        $this->assertSame('Completed', $withdrawal->status);
        $this->assertNotNull($withdrawal->processed_at);
        $this->assertNotNull($withdrawal->proof_of_payment);
    }
}
