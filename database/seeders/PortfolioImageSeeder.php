<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortfolioImageSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $images = [
            // images for portfolio 1 (integrasi qontak)
            [
                'portfolio_id' => 1,
                'image_url' => 'images/portfolio/integrasi-qontak-1.jpg',
                'caption' => 'Arsitektur integrasi: Qontak → Node.js → Flowise',
                'display_order' => 1,
                'created_at' => $now,
            ],
            [
                'portfolio_id' => 1,
                'image_url' => 'images/portfolio/integrasi-qontak-2.jpg',
                'caption' => 'Dashboard monitoring webhook & Redis cache',
                'display_order' => 2,
                'created_at' => $now,
            ],

            // images for portfolio 2 (rewrite backend)
            [
                'portfolio_id' => 2,
                'image_url' => 'images/portfolio/rewrite-globalkomunika-1.jpg',
                'caption' => 'Diagram modul service layer dan API endpoints',
                'display_order' => 1,
                'created_at' => $now,
            ],
            [
                'portfolio_id' => 2,
                'image_url' => 'images/portfolio/rewrite-globalkomunika-2.jpg',
                'caption' => 'Contoh dokumentasi OpenAPI untuk endpoint utama',
                'display_order' => 2,
                'created_at' => $now,
            ],

            // images for portfolio 3 (C4.5)
            [
                'portfolio_id' => 3,
                'image_url' => 'images/portfolio/c45-kpr-1.jpg',
                'caption' => 'Visualisasi pohon keputusan C4.5',
                'display_order' => 1,
                'created_at' => $now,
            ],
            [
                'portfolio_id' => 3,
                'image_url' => 'images/portfolio/c45-kpr-2.jpg',
                'caption' => 'Confusion matrix & metrik evaluasi',
                'display_order' => 2,
                'created_at' => $now,
            ],
        ];

        DB::table('portfolio_images')->insert($images);
    }
}
