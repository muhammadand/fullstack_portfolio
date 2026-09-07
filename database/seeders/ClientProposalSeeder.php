<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ClientProposal::updateOrCreate(
            ['slug' => 'permata-qiana-wedding'],
            [
                'brand_name' => 'Permata Qiana Wedding',
                'client_name' => 'Manajemen Permata Qiana Wedding',
                'wa_number' => '6281234567890',
                'wa_template' => 'Halo tim Scalify, saya tertarik untuk diskusi lebih lanjut mengenai proposal website dari Permata Qiana.',
                'price_silver' => 700000,
                'price_gold' => 1600000,
                'price_diamond' => 2000000,
                'price_platinum' => 3000000,
            ]
        );
    }
}
