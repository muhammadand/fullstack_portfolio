<?php

namespace Tests\Feature;

use App\Models\Affiliate;
use App\Support\AffiliateMenu;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AffiliateAllMenuTest extends TestCase
{
    use DatabaseTransactions;

    protected Affiliate $affiliate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = Affiliate::firstOrCreate(
            ['email' => 'allmenu_partner@scalify.id'],
            [
                'name' => 'All Menu Partner',
                'password' => bcrypt('password123'),
                'affiliate_code' => 'ALLMENU' . rand(100, 999),
                'status' => 'approved',
            ]
        );
        $this->affiliate->forceFill(['status' => 'approved'])->save();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('affiliate.menu'))->assertRedirect(route('affiliate.login'));
    }

    public function test_affiliate_can_view_all_menu_with_every_group(): void
    {
        $response = $this->actingAs($this->affiliate, 'affiliate')->get(route('affiliate.menu'));

        $response->assertOk();
        $response->assertViewIs('affiliate.all_menu');
        $response->assertSeeInOrder([
            'Jual Website ke Bisnis',
            'Google Review Card',
            'Produk Digital',
            'Promosi, Konten &amp; Poin',
            'Akun &amp; Panduan',
        ], false);

        foreach (AffiliateMenu::groups() as $group) {
            $response->assertSee('data-menu-group="' . $group['key'] . '"', false);
            foreach ($group['items'] as $item) {
                $response->assertSee('data-menu-key="' . $item['key'] . '"', false);
            }
        }

        // Semua produk digital sudah aktif: Pulsa, Paket Data, Token PLN, Top Up Game.
        foreach (['affiliate.ppob.pulsa', 'affiliate.ppob.paket_data', 'affiliate.ppob.pln', 'affiliate.ppob.games'] as $name) {
            $response->assertSee(route($name), false);
        }
        $response->assertSee(route('affiliate.proposals'), false);
    }

    public function test_dashboard_shows_seven_shortcuts_and_all_menu_button(): void
    {
        $response = $this->actingAs($this->affiliate, 'affiliate')->get(route('affiliate.dashboard'));

        $response->assertOk();
        $this->assertCount(7, AffiliateMenu::shortcuts());
        foreach (AffiliateMenu::SHORTCUT_KEYS as $key) {
            $response->assertSee('data-menu-key="' . $key . '"', false);
        }
        $response->assertSee('data-menu-key="all_menu"', false);
        $response->assertSee(route('affiliate.menu'), false);
        $response->assertSee('id="dashboardCoachMark"', false);
        // Item di luar shortcut tidak tampil di dashboard.
        $response->assertDontSee('data-menu-key="pulsa"', false);
    }
}
