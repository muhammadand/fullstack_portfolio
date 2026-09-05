<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DigitalProduct;
use App\Models\Affiliate;

class DigitalProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'PAKET 3 Source Code Laravel E-Commerce Terbaik (Chat + Payment + Raja Ongkir)',
                'slug' => 'paket-3-source-code-laravel-e-commerce-terbaik',
                'lynk_slug' => '4pngq6kwqwzl',
                'category' => 'Source Code',
                'price' => 350000,
                'short_description' => 'Paket komplit source code Laravel E-Commerce dengan fitur live chat, payment gateway otomatis, dan integrasi RajaOngkir.',
                'description' => 'Source code lengkap untuk toko online modern. Dilengkapi fitur keranjang belanja, checkout otomatis dengan gateway pembayaran, integrasi ongkir ke seluruh Indonesia, dan live chat customer support.',
                'demo_url' => null,
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Source Code Oprasional Cafe + Payment Gateway',
                'slug' => 'source-code-oprasional-cafe-paymentgateway',
                'lynk_slug' => 'rj4yq6kndnpl',
                'category' => 'Source Code',
                'price' => 275000,
                'short_description' => 'Sistem operasional kasir & manajemen cafe lengkap terintegrasi payment gateway otomatis.',
                'description' => 'Aplikasi POS dan manajemen operasional resto/cafe modern. Mendukung order meja, cetak struk, manajemen stok bahan baku, dan pembayaran QRIS/e-wallet instan.',
                'demo_url' => null,
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Desain Template Website Premium Termurah',
                'slug' => 'desain-template-website-premium-termurah',
                'lynk_slug' => '8j6q2xggqrol',
                'category' => 'Template Website',
                'price' => 99000,
                'short_description' => 'Koleksi template website premium modern, responsive, dan mudah dikustomisasi untuk berbagai kebutuhan.',
                'description' => 'Template website ultra-modern dengan desain glassmorphism, responsive di semua device, clean code, dan sangat mudah disesuaikan untuk landing page bisnis maupun portofolio.',
                'demo_url' => null,
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'Website Manajemen Inventory dengan Metode WMA dan ROP',
                'slug' => 'website-manajemen-inventory-metode-wma-dan-rop',
                'lynk_slug' => '1mk10gqm4olk',
                'category' => 'Skripsi & Algoritma',
                'price' => 300000,
                'short_description' => 'Sistem inventori pergudangan cerdas dengan forecasting Weighted Moving Average (WMA) dan Reorder Point (ROP).',
                'description' => 'Cocok untuk skripsi atau operasional gudang nyata. Menggunakan peramalan permintaan berbasis WMA dan penentuan titik pemesanan ulang otomatis (Reorder Point).',
                'demo_url' => null,
                'is_active' => true,
                'display_order' => 4,
            ],
            [
                'name' => 'Website SPK Metode Fuzzy untuk Seleksi Calon Driver',
                'slug' => 'website-spk-metode-fuzzy-untuk-seleksi-calon-driver',
                'lynk_slug' => 'qmqzyxxwkeke',
                'category' => 'Skripsi & Algoritma',
                'price' => 280000,
                'short_description' => 'Sistem Pendukung Keputusan (SPK) berbasis metode Fuzzy Logic untuk penilaian dan seleksi calon driver secara objektif.',
                'description' => 'Aplikasi web SPK lengkap dengan perhitungan fuzzifikasi, aturan inferensi Mamdani/Sugeno, dan defuzzifikasi yang transparan dan akurat.',
                'demo_url' => null,
                'is_active' => true,
                'display_order' => 5,
            ],
            [
                'name' => 'Signal Trading XAUUSD Auto Profit',
                'slug' => 'signal-trading-xauusd-auto-profit',
                'lynk_slug' => '3gyx17qelvw0',
                'category' => 'Trading & Finansial',
                'price' => 450000,
                'short_description' => 'Akses signal harian trading XAUUSD (Gold) dengan analisa teknikal presisi tinggi dan risk management terukur.',
                'description' => 'Layanan alert signal harian untuk komoditas Emas (XAUUSD) dilengkapi Take Profit, Stop Loss, serta edukasi money management.',
                'demo_url' => null,
                'is_active' => true,
                'display_order' => 6,
            ],
            [
                'name' => 'Implementasi Algoritma C4.5 di Website',
                'slug' => 'implementasi-algoritma-c45-di-website',
                'lynk_slug' => 'w4lxg0l7enow',
                'category' => 'Skripsi & Algoritma',
                'price' => 290000,
                'short_description' => 'Implementasi data mining Decision Tree Algoritma C4.5 berbasis web untuk klasifikasi dan prediksi akurat.',
                'description' => 'Aplikasi data mining pohon keputusan (decision tree) C4.5 lengkap dengan visualisasi pohon keputusan, perhitungan gain ratio, dan pengujian akurasi confusion matrix.',
                'demo_url' => null,
                'is_active' => true,
                'display_order' => 7,
            ],
        ];

        foreach ($products as $item) {
            DigitalProduct::updateOrCreate(
                ['lynk_slug' => $item['lynk_slug']],
                $item
            );
        }

        // Set default lynk_id_link and lynk_commission_rate for affiliates
        Affiliate::whereNull('lynk_id_link')->orWhere('lynk_id_link', '')->update([
            'lynk_id_link' => 'https://lynk.id/a/1035009226',
            'lynk_commission_rate' => 10.00,
        ]);

        Affiliate::whereNull('lynk_commission_rate')->update([
            'lynk_commission_rate' => 10.00,
        ]);
    }
}
