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

    public function test_mobile_design_rules_and_compact_numbers_render(): void
    {
        $html = $this->actingAs($this->admin())->get(route('admin.affiliates.index'))->assertOk()->getContent();

        // Aturan global HP dimuat di semua halaman admin.
        $this->assertStringContainsString('@media (max-width: 1023.98px)', $html);
        // Stat memakai komponen standar: angka besar ringkas di HP, lengkap di desktop.
        $this->assertStringContainsString('Komisi Diberikan', $html);
        $this->assertMatchesRegularExpression('/<span class="lg:hidden">Rp [^<]+<\/span><span class="hidden lg:inline">Rp [\d.]+<\/span>|title="Rp [\d.]+">Rp [\d.]+<\/span>/', $html);
    }

    public function test_stat_component_shows_compact_value_on_mobile_and_full_on_desktop(): void
    {
        $html = \Illuminate\Support\Facades\Blade::render('<x-admin.stat label="Omzet" :value="5663000" rupiah />');

        $this->assertStringContainsString('<span class="lg:hidden">Rp 5,66 jt</span>', $html);
        $this->assertStringContainsString('<span class="hidden lg:inline">Rp 5.663.000</span>', $html);
        $this->assertStringContainsString('truncate', $html);
    }

    public function test_filter_bar_is_compact_and_renders_each_filter_once(): void
    {
        $admin = $this->admin();
        $html = $this->actingAs($admin)
            ->get(route('admin.orders.index', ['source' => 'pulsa', 'search' => 'abc', 'status' => 'processing']))
            ->assertOk()->getContent();

        $this->assertStringContainsString('admin-filter', $html);
        $this->assertSame(1, substr_count($html, 'name="status"'), 'filter status harus dirender sekali');
        $this->assertSame(1, substr_count($html, 'name="payment_status"'));
        $this->assertStringContainsString('name="search" value="abc"', $html);
        $this->assertStringContainsString('<input type="hidden" name="source" value="pulsa">', $html); // tab ikut terkirim
        $this->assertStringContainsString('aria-label="Filter"', $html);                             // tombol panel di HP
        $this->assertMatchesRegularExpression('/bg-blue-600 text-white text-\[10px\][^>]*>1<\/span>/', $html); // 1 filter aktif

        foreach (['admin.affiliates.index', 'admin.customers.index', 'admin.withdrawals.index', 'admin.review_cards.index',
                  'admin.travel_bookings.index', 'admin.travel_schedules.index', 'admin.client_proposals.index'] as $name) {
            $this->actingAs($admin)->get(route($name))->assertOk()->assertSee('admin-filter', false);
        }
    }
}
