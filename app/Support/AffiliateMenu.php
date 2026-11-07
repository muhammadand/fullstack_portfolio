<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

/**
 * Sumber tunggal data menu dashboard affiliate.
 *
 * Data menu sengaja ditaruh di kelas PHP (bukan array di blok @php Blade)
 * supaya aman dari formatter editor dan mudah dirawat.
 *
 * Catatan Tailwind v4: file ini di-scan lewat @source di resources/css/app.css,
 * jadi class warna yang ditulis lengkap di sini tetap ter-generate.
 */
class AffiliateMenu
{
    /**
     * Urutan shortcut yang tampil di dashboard depan (7 item + tombol "Semua Menu").
     */
    public const SHORTCUT_KEYS = [
        'proposals',
        'review_proposals',
        'digital_products',
        'share_web',
        'guide', // kolom pertama baris ke-2 supaya coach mark tidak terpotong di layar mobile
        'review_cards',
        'project_deal',
    ];

    /**
     * Semua kelompok menu, berurutan sesuai tampilan halaman "Semua Menu".
     *
     * Field item:
     * - key, label (baris 1), sublabel (baris 2), icon, color (class teks ikon), hover (class hover)
     * - route   : nama route tujuan (null jika aksi JS / segera hadir)
     * - action  : 'share' untuk membuka share modal
     * - badge, badgeClass : badge kecil di pojok ikon
     * - counter : 'totalProjects' -> ikon diganti angka
     * - coachMark : true -> item Edukasi & AI Hub yang punya coach mark di dashboard
     * - soon    : true -> belum tersedia, tampil dengan badge "Segera" dan tidak bisa diklik
     */
    public static function groups(): array
    {
        return [
            [
                'key' => 'website',
                'title' => 'Jual Website ke Bisnis',
                'description' => 'Tawarkan jasa pembuatan website & dapatkan komisi per project.',
                'icon' => 'fa-solid fa-briefcase',
                'iconColor' => 'text-rose-400',
                'border' => 'border-rose-500',
                'items' => [
                    self::item('proposals', 'Penawaran', 'Website', 'fa-solid fa-briefcase', 'text-rose-400', 'group-hover:bg-rose-500/10 group-hover:border-rose-500/30', route: 'affiliate.proposals'),
                    self::item('chat_templates', 'Template', 'Chat', 'fa-solid fa-message', 'text-teal-400', 'group-hover:bg-teal-500/10 group-hover:border-teal-500/30', route: 'affiliate.chat_templates.index'),
                    self::item('student_leads', 'Data', 'Mahasiswa', 'fa-solid fa-users', 'text-cyan-400', 'group-hover:bg-cyan-500/10 group-hover:border-cyan-500/30', route: 'affiliate.student_leads.index'),
                    self::item('project_deal', 'Project', 'Deal', 'fa-solid fa-handshake', 'text-emerald-400', 'group-hover:bg-emerald-500/10 group-hover:border-emerald-500/30', route: 'affiliate.history', counter: 'totalProjects'),
                ],
            ],
            [
                'key' => 'review_card',
                'title' => 'Google Review Card',
                'description' => 'Jual kartu NFC/QR ulasan Google ke pemilik usaha.',
                'icon' => 'fa-solid fa-star',
                'iconColor' => 'text-sky-400',
                'border' => 'border-sky-500',
                'items' => [
                    self::item('review_cards', 'Review', 'Cards', 'fa-solid fa-qrcode', 'text-blue-400', 'group-hover:bg-blue-500/10 group-hover:border-blue-500/30', route: 'affiliate.review_cards.index', badge: 'New', badgeClass: 'bg-blue-500 text-white font-semibold'),
                    self::item('review_proposals', 'Tawarkan', 'Review Card', 'fa-solid fa-star-half-stroke', 'text-sky-400', 'group-hover:bg-sky-500/10 group-hover:border-sky-500/30', route: 'affiliate.review_proposals', badge: 'Hot', badgeClass: 'bg-sky-500 text-white font-semibold'),
                ],
            ],
            [
                'key' => 'ppob',
                'title' => 'Produk Digital',
                'description' => 'Produk digital, pulsa, paket data & token listrik.',
                'icon' => 'fa-solid fa-bolt',
                'iconColor' => 'text-amber-400',
                'border' => 'border-amber-500',
                'items' => [
                    self::item('digital_products', 'Produk', 'Digital', 'fa-solid fa-cubes-stacked', 'text-amber-400', 'group-hover:bg-amber-500/10 group-hover:border-amber-500/30', route: 'affiliate.digital_products.index', badge: '10%', badgeClass: 'bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold shadow-md shadow-amber-500/40'),
                    self::item('pulsa', 'Pulsa', '', 'fa-solid fa-mobile-screen-button', 'text-green-400', 'group-hover:bg-green-500/10 group-hover:border-green-500/30', route: 'affiliate.ppob.pulsa', badge: 'Baru', badgeClass: 'bg-green-500 text-white font-semibold'),
                    self::item('paket_data', 'Paket', 'Data', 'fa-solid fa-wifi', 'text-violet-400', '', soon: true),
                    self::item('pln', 'Token', 'PLN', 'fa-solid fa-bolt', 'text-yellow-400', '', soon: true),
                ],
            ],
            [
                'key' => 'content',
                'title' => 'Promosi, Konten & Poin',
                'description' => 'Sebarkan link, tulis artikel, kumpulkan & tukar poin.',
                'icon' => 'fa-solid fa-fire',
                'iconColor' => 'text-orange-400',
                'border' => 'border-orange-500',
                'items' => [
                    self::item('share_web', 'Bagikan', 'Web', 'fa-solid fa-share-nodes', 'text-indigo-400', 'group-hover:bg-indigo-500/10 group-hover:border-indigo-500/30', action: 'share'),
                    self::item('blogs', 'Tulis', 'Artikel', 'fa-solid fa-pen-nib', 'text-orange-400', 'group-hover:bg-orange-500/10 group-hover:border-orange-500/30', route: 'affiliate.blogs.index', badge: '+Poin', badgeClass: 'bg-yellow-500 text-white font-bold shadow-md shadow-yellow-500/40 animate-pulse'),
                    self::item('store', 'Tukar', 'Poin', 'fa-solid fa-store', 'text-pink-400', 'group-hover:bg-pink-500/10 group-hover:border-pink-500/30', route: 'affiliate.store'),
                ],
            ],
            [
                'key' => 'account',
                'title' => 'Akun & Panduan',
                'description' => 'Saldo, jaringan referral, edukasi dan akses login.',
                'icon' => 'fa-solid fa-circle-user',
                'iconColor' => 'text-purple-400',
                'border' => 'border-purple-500',
                'items' => [
                    self::item('history', 'Riwayat', 'Dana', 'fa-solid fa-clock-rotate-left', 'text-blue-400', 'group-hover:bg-blue-500/10 group-hover:border-blue-500/30', route: 'affiliate.history'),
                    self::item('referrals', 'Jaringan', 'Referral', 'fa-solid fa-network-wired', 'text-indigo-400', 'group-hover:bg-indigo-500/10 group-hover:border-indigo-500/30', route: 'affiliate.referrals.index', badge: '3 Tier', badgeClass: 'bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold shadow-md shadow-indigo-500/40'),
                    self::item('guide', 'Edukasi', '& AI Hub', 'fa-solid fa-graduation-cap', 'text-yellow-400', 'group-hover:bg-yellow-500/10 group-hover:border-yellow-500/30', route: 'affiliate.guide', badge: 'AI Hub', badgeClass: 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-md shadow-blue-500/40 animate-pulse', coachMark: true),
                    self::item('magic_login_qr', 'Akses', 'Login', 'fa-solid fa-key', 'text-purple-400', 'group-hover:bg-purple-500/10 group-hover:border-purple-500/30', route: 'affiliate.magic_login_qr'),
                ],
            ],
        ];
    }

    /**
     * Shortcut dashboard depan, urut sesuai SHORTCUT_KEYS.
     */
    public static function shortcuts(): array
    {
        $items = collect(self::groups())->flatMap(fn(array $group) => $group['items'])->keyBy('key');

        return collect(self::SHORTCUT_KEYS)
            ->map(fn(string $key) => $items->get($key))
            ->filter()
            ->values()
            ->all();
    }

    private static function item(
        string $key,
        string $label,
        string $sublabel,
        string $icon,
        string $color,
        string $hover,
        ?string $route = null,
        ?string $action = null,
        ?string $badge = null,
        ?string $badgeClass = null,
        ?string $counter = null,
        bool $coachMark = false,
        bool $soon = false,
    ): array {
        // Jaga-jaga: route yang belum terdaftar otomatis jadi "Segera" alih-alih error.
        if ($route !== null && ! Route::has($route)) {
            $route = null;
            $soon = true;
        }

        if ($soon) {
            $badge = 'Segera';
            $badgeClass = 'bg-slate-600 text-slate-100 font-semibold';
        }

        return compact('key', 'label', 'sublabel', 'icon', 'color', 'hover', 'route', 'action', 'badge', 'badgeClass', 'counter', 'coachMark', 'soon');
    }
}
