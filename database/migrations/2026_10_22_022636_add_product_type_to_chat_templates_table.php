<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_templates', function (Blueprint $table) {
            $table->string('product_type', 50)->default('website')->after('name')->comment('website, review_card, etc.');
            $table->index('product_type');
        });

        // Seed template default penawaran Smart Review Card
        DB::table('chat_templates')->insert([
            [
                'name'         => 'Review Card - Edukasi Rating Google Maps',
                'product_type' => 'review_card',
                'content'      => "Halo Kak {nama_bisnis}, salam kenal dari {pengirim}.\n\nSaya perhatikan bisnis {nama_bisnis} sudah ada di Google Maps, tapi ulasannya masih bisa dimaksimalkan lagi nih kak agar toko selalu muncul di urutan teratas pencarian Google.\n\nSekarang ada cara praktis: *Smart Google Review Card (NFC & QR)*. Pelanggan di kasir cukup tempelkan HP ke kartu, langsung terbuka form ulasan bintang 5 tanpa perlu cari manual.\n\nApakah berkenan jika saya kirimkan info detail & contoh demonya kak? Terima kasih 🙏",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Review Card - Solusi Kasir Praktis (Tap NFC)',
                'product_type' => 'review_card',
                'content'      => "Halo Tim {nama_bisnis}, izin sharing solusi praktis untuk kasir toko.\n\nSeringkali pelanggan puas tapi malas atau lupa kasih review di Google Maps karena ribet harus search nama toko dulu.\n\nDengan *Kartu Google Review Pintar*, pelanggan cukup tempel HP (NFC) atau scan QR di meja kasir, hitungan 3 detik langsung diarahkan kasih ulasan bintang 5 ⭐⭐⭐⭐⭐.\n\nBisa custom nama & logo {nama_bisnis} juga kak. Boleh saya kirimkan preview kartu & promo spesialnya kak?",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Review Card - Promo Khusus Merchant Lokal',
                'product_type' => 'review_card',
                'content'      => "Selamat siang Kak, salam kenal saya {pengirim}.\n\nUntuk mendukung kemajuan usaha lokal di sekitar, kami lagi ada program promo khusus merchant: *Smart NFC Review Card Toko* untuk meningkatkan reputasi & bintang Google Maps bisnis {nama_bisnis}.\n\nKartunya siap pakai tanpa baterai, tanpa biaya langganan bulanan, dan langsung aktif selamanya.\n\nKira-kira nomor ini terhubung dengan owner / manager {nama_bisnis} kak? Ada penawaran khusus minggu ini. Terima kasih kak!",
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_templates', function (Blueprint $table) {
            $table->dropIndex(['product_type']);
            $table->dropColumn('product_type');
        });
    }
};
