<?php

namespace Tests\Feature;

use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminMobileLayoutTest extends TestCase
{
    use DatabaseTransactions;

    protected function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'adm_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => 'admin']);
    }

    public function test_admin_pages_have_mobile_bottom_nav_and_desktop_only_sidebar(): void
    {
        $html = $this->actingAs($this->admin())->get(route('admin.orders.index'))->assertOk()->getContent();

        $this->assertStringContainsString('aria-label="Navigasi admin"', $html);
        $this->assertStringContainsString('class="hidden lg:block relative z-50 h-screen"', $html); // sidebar hanya desktop
        $this->assertStringNotContainsString('fa-solid fa-bars', $html);                           // tidak ada tombol ☰ lagi
        foreach (['Beranda', 'Order', 'Penarikan', 'Partner', 'Menu'] as $tab) {
            $this->assertStringContainsString($tab, $html);
        }
        // Tab Order aktif di halaman order.
        $this->assertMatchesRegularExpression('/href="[^"]*admin\/orders"\s+aria-current="page"/', $html);
    }

    public function test_partner_badge_shows_pending_count_and_links_to_pending_filter(): void
    {
        Affiliate::create(['name' => 'Baru', 'email' => 'b_' . uniqid() . '@x.id', 'password' => bcrypt('x'), 'affiliate_code' => 'N' . rand(1000, 9999), 'status' => 'pending']);
        $pending = Affiliate::where('status', 'pending')->count();

        $html = $this->actingAs($this->admin())->get(route('admin.menu'))->assertOk()->getContent();

        $this->assertStringContainsString('admin/affiliates?status=pending', $html);
        $this->assertMatchesRegularExpression('/bg-red-500[^>]*>' . $pending . '<\/span>/', $html);
    }

    public function test_menu_page_lists_all_groups_and_requires_login(): void
    {
        $this->get(route('admin.menu'))->assertRedirect(route('login'));

        $this->actingAs($this->admin())->get(route('admin.menu'))->assertOk()
            ->assertSee('Umum')->assertSee('Digiflazz')->assertSee('Penarikan Customer')
            ->assertSee('Travel &amp; Shuttle', false)->assertSee('Keluar');
    }

    public function test_dashboard_has_mobile_home_with_action_cards(): void
    {
        $this->actingAs($this->admin())->get(route('dashboard.admin'))->assertOk()
            ->assertSee('data-mobile-home', false)->assertSee('Perlu tindakan')->assertSee('Partner perlu approval')
            ->assertSee('Menu cepat');
    }

    public function test_main_list_pages_render_mobile_cards_and_desktop_table(): void
    {
        $admin = $this->admin();
        Affiliate::create(['name' => 'Kartu HP', 'email' => 'k_' . uniqid() . '@x.id', 'password' => bcrypt('x'), 'affiliate_code' => 'K' . rand(1000, 9999), 'status' => 'pending']);

        foreach (['admin.affiliates.index', 'admin.withdrawals.index', 'admin.travel_bookings.index', 'admin.review_cards.index'] as $name) {
            $html = $this->actingAs($admin)->get(route($name))->assertOk()->getContent();

            $this->assertStringContainsString('class="hidden md:block overflow-x-auto"', $html, "$name: tabel harus desktop-only");
            $this->assertStringContainsString('class="md:hidden divide-y divide-slate-100"', $html, "$name: harus punya kartu HP");
        }
    }
}
