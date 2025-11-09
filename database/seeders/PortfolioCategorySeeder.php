<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PortfolioCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $categories = [
            [
                'name' => 'Integrasi & Chatbot',
                'slug' => 'integrasi-chatbot',
                'description' => 'Proyek integrasi sistem chat, webhook, dan AI agent (Flowise, Qontak).',
                'display_order' => 1,
                'is_active' => true,
                'created_at' => $now,
            ],
            [
                'name' => 'Backend & API',
                'slug' => 'backend-api',
                'description' => 'Rewrite backend, RESTful API, optimasi Redis, queue, dan deployment.',
                'display_order' => 2,
                'is_active' => true,
                'created_at' => $now,
            ],
            [
                'name' => 'Machine Learning',
                'slug' => 'machine-learning',
                'description' => 'Proyek ML klasik seperti algoritma C4.5 untuk keputusan KPR dan model penilaian.',
                'display_order' => 3,
                'is_active' => true,
                'created_at' => $now,
            ],
        ];

        DB::table('portfolio_categories')->insert($categories);
    }
}
