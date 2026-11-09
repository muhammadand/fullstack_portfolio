<?php

namespace Tests\Feature;

use Tests\TestCase;

class TopupNavbarTest extends TestCase
{
    public function test_topup_page_hides_services_portfolio_career_and_whatsapp(): void
    {
        $html = $this->get(route('topup.index'))->assertOk()->getContent();
        $html = substr($html, 0, strpos($html, '</nav>')); // hanya navbar, footer punya link sendiri

        foreach (['Layanan & Solusi', 'Layanan &amp; Solusi', 'Program & Karir', 'Program &amp; Karir', 'Konsultasi Web', 'Konsultasi via WhatsApp', 'Portofolio'] as $hidden) {
            $this->assertStringNotContainsString($hidden, $html, "'$hidden' harusnya tersembunyi di halaman top up");
        }
        $this->assertStringNotContainsString('wa.me/6285221694067?text=Halo%20Scalify,%20saya%20ingin%20konsultasi', $html);

        foreach (['Top-Up Game', 'Blog'] as $shown) {
            $this->assertStringContainsString($shown, $html);
        }
    }

    public function test_other_pages_keep_full_navbar(): void
    {
        $html = $this->get(route('index.company.profile'))->assertOk()->getContent();
        $html = substr($html, 0, strpos($html, '</nav>'));

        foreach (['Layanan', 'Program', 'Portofolio', 'Konsultasi Web'] as $shown) {
            $this->assertStringContainsString($shown, $html);
        }
    }

    public function test_topup_index_has_loader_and_skips_heavy_chatbot_widget(): void
    {
        $html = $this->get(route('topup.index'))->assertOk()->getContent();

        $this->assertStringContainsString('id="topup-page-loader"', $html);
        $this->assertStringNotContainsString('scalify-native-launcher', $html);

        $other = $this->get(route('index.company.profile'))->getContent();
        $this->assertStringContainsString('scalify-native-launcher', $other);
        $this->assertStringNotContainsString('id="topup-page-loader"', $other);
    }

    public function test_mobile_menu_always_has_topup_link(): void
    {
        foreach (['index.company.profile', 'landing.blogs', 'topup.index'] as $name) {
            $html = $this->get(route($name))->assertOk()->getContent();
            $this->assertSame(1, substr_count($html, 'data-mobile-topup'), "$name: menu HP harus punya satu link Top-Up Game");
            $this->assertMatchesRegularExpression('/href="' . preg_quote(route('topup.index'), '/') . '"[^>]*data-mobile-topup/', $html);
        }
    }
}
