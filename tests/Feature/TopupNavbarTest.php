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
}
