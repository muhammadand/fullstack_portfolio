<?php

namespace Tests\Feature;

use App\Models\Affiliate;
use App\Models\AffiliatePointHistory;
use App\Models\ChatTemplate;
use App\Models\Commission;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAffiliatesModernizationTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first() ?? User::create([
            'name' => 'Admin Test',
            'email' => 'admin_aff_test_' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }

    public function test_affiliates_index_renders_properly(): void
    {
        $affiliate = Affiliate::create([
            'name' => 'Partner Scalify Modern',
            'email' => 'partner_modern_' . uniqid() . '@example.com',
            'password' => Hash::make('password123'),
            'status' => 'approved',
            'affiliate_code' => 'SCL' . rand(100, 999),
            'balance' => 150000,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.affiliates.index'));
        $response->assertOk();
        $response->assertSee('Affiliate Dashboard');
        $response->assertSee('Total Partner');
        $response->assertSee('Partner Scalify Modern');
        $response->assertSee($affiliate->affiliate_code);
    }

    public function test_affiliates_index_search_and_filter(): void
    {
        $code1 = 'SCL' . rand(100, 999);
        $code2 = 'XYZ' . rand(100, 999);

        Affiliate::create([
            'name' => 'UniqueSearchPartnerAlpha',
            'email' => 'unique_alpha_' . uniqid() . '@example.com',
            'password' => Hash::make('password123'),
            'status' => 'approved',
            'affiliate_code' => $code1,
            'balance' => 50000,
        ]);

        Affiliate::create([
            'name' => 'AnotherPartnerBeta',
            'email' => 'another_beta_' . uniqid() . '@example.com',
            'password' => Hash::make('password123'),
            'status' => 'pending',
            'affiliate_code' => $code2,
            'balance' => 0,
        ]);

        // Search by query
        $resQuery = $this->actingAs($this->admin)->get(route('admin.affiliates.index', ['q' => 'Alpha']));
        $resQuery->assertOk();
        $resQuery->assertSee('UniqueSearchPartnerAlpha');
        $resQuery->assertDontSee('AnotherPartnerBeta');

        // Filter by status
        $resStatus = $this->actingAs($this->admin)->get(route('admin.affiliates.index', ['status' => 'pending']));
        $resStatus->assertOk();
        $resStatus->assertSee('AnotherPartnerBeta');
    }

    public function test_affiliates_store_creates_partner(): void
    {
        $email = 'partner_new_' . uniqid() . '@example.com';

        $response = $this->actingAs($this->admin)->post(route('admin.affiliates.store'), [
            'name' => 'Partner Baru Admin',
            'email' => $email,
            'password' => 'password12345',
            'status' => 'approved',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('affiliates', [
            'email' => $email,
            'status' => 'approved',
        ]);
    }

    public function test_affiliates_approve_and_reject(): void
    {
        $affiliate = Affiliate::create([
            'name' => 'Partner Review',
            'email' => 'review_' . uniqid() . '@example.com',
            'password' => Hash::make('password123'),
            'status' => 'pending',
            'affiliate_code' => 'REV' . rand(100, 999),
            'balance' => 0,
        ]);

        // Approve
        $resApprove = $this->actingAs($this->admin)->post(route('admin.affiliates.approve', $affiliate->id));
        $resApprove->assertRedirect();
        $this->assertEquals('approved', $affiliate->fresh()->status);

        // Reject
        $resReject = $this->actingAs($this->admin)->post(route('admin.affiliates.reject', $affiliate->id));
        $resReject->assertRedirect();
        $this->assertEquals('rejected', $affiliate->fresh()->status);
    }

    public function test_affiliates_show_renders_with_relationships(): void
    {
        $affiliate = Affiliate::create([
            'name' => 'Partner Detail Test',
            'email' => 'detail_' . uniqid() . '@example.com',
            'password' => Hash::make('password123'),
            'status' => 'approved',
            'affiliate_code' => 'DET' . rand(100, 999),
            'balance' => 200000,
            'points' => 350,
            'current_streak' => 5,
            'highest_streak' => 12,
            'bank_info' => 'BCA 12345678 a/n Test',
        ]);

        Commission::create([
            'affiliate_id' => $affiliate->id,
            'amount' => 50000,
            'description' => 'Project Toko Online',
            'status' => 'Paid',
        ]);

        Withdrawal::create([
            'affiliate_id' => $affiliate->id,
            'amount' => 50000,
            'status' => 'Completed',
            'bank_info' => 'BCA 12345678 a/n Test',
        ]);

        ChatTemplate::create([
            'affiliate_id' => $affiliate->id,
            'name' => 'Template Follow Up Deal',
            'content' => 'Halo kak, kami dari Scalify...',
        ]);

        AffiliatePointHistory::create([
            'affiliate_id' => $affiliate->id,
            'points_earned' => 100,
            'description' => 'Daily Login Claim',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.affiliates.show', $affiliate->id));
        $response->assertOk();
        $response->assertSee('Partner Detail Test');
        $response->assertSee('Project Toko Online');
        $response->assertSee('Template Follow Up Deal');
        $response->assertSee('Daily Login Claim');
    }

    public function test_affiliates_add_commission_updates_balance_and_points(): void
    {
        $affiliate = Affiliate::create([
            'name' => 'Partner Komisi',
            'email' => 'komisi_' . uniqid() . '@example.com',
            'password' => Hash::make('password123'),
            'status' => 'approved',
            'affiliate_code' => 'KMS' . rand(100, 999),
            'balance' => 100000,
            'points' => 50,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.affiliates.commission', $affiliate->id), [
            'amount' => 150000,
            'description' => 'Closing Website E-Commerce',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $affiliate->refresh();
        $this->assertEquals(250000, $affiliate->balance);
        $this->assertEquals(150, $affiliate->points);
    }

    public function test_affiliates_update_lynk_settings(): void
    {
        $affiliate = Affiliate::create([
            'name' => 'Partner Lynk Settings',
            'email' => 'lynk_' . uniqid() . '@example.com',
            'password' => Hash::make('password123'),
            'status' => 'approved',
            'affiliate_code' => 'LNK' . rand(100, 999),
            'balance' => 0,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.affiliates.lynk_settings', $affiliate->id), [
            'lynk_id_link' => 'https://lynk.id/a/scalify123',
            'lynk_commission_rate' => 12.5,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $affiliate->refresh();
        $this->assertEquals('https://lynk.id/a/scalify123', $affiliate->lynk_id_link);
        $this->assertEquals(12.5, (float)$affiliate->lynk_commission_rate);
    }
}
