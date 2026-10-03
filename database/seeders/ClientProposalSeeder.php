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

        $lpkCategory = \App\Models\BusinessCategory::where('slug', 'lpk')->first();

        \App\Models\ClientProposal::updateOrCreate(
            ['slug' => 'lpk-kizuna-indonesia'],
            [
                'business_category_id' => $lpkCategory ? $lpkCategory->id : null,
                'brand_name' => 'LPK Kizuna Global Indonesia',
                'client_name' => 'Direktur & Manajemen LPK Kizuna Global',
                'wa_number' => '6281234567890',
                'wa_template' => 'Halo tim Scalify, kami dari LPK Kizuna Global Indonesia ingin konsultasi implementasi Sistem Informasi LMS & Website LPK.',
                'price_silver' => 850000,
                'price_gold' => 1850000,
                'price_diamond' => 2750000,
                'price_platinum' => 4500000,
                'renewal_silver' => '500rb/tahun',
                'renewal_gold' => '750rb/tahun',
                'renewal_diamond' => '1.2jt/tahun',
                'renewal_platinum' => '50% per tahun',
            ]
        );

        $sportCategory = \App\Models\BusinessCategory::where('slug', 'sport')->first();

        \App\Models\ClientProposal::updateOrCreate(
            ['slug' => 'apex-arena-sport'],
            [
                'business_category_id' => $sportCategory ? $sportCategory->id : null,
                'brand_name' => 'Apex Arena Sport Center',
                'client_name' => 'Manajemen Pengelola Apex Arena',
                'wa_number' => '6281234567890',
                'wa_template' => 'Halo tim Scalify, kami dari Apex Arena tertarik untuk membuat sistem website booking lapangan, membership, dan komunitas mabar.',
                'price_silver' => 850000,
                'price_gold' => 1950000,
                'price_diamond' => 2950000,
                'price_platinum' => 4900000,
                'renewal_silver' => '500rb/tahun',
                'renewal_gold' => '750rb/tahun',
                'renewal_diamond' => '1.2jt/tahun',
                'renewal_platinum' => '50% per tahun',
            ]
        );

        $klinikCategory = \App\Models\BusinessCategory::where('slug', 'klinik')->first();

        \App\Models\ClientProposal::updateOrCreate(
            ['slug' => 'medika-sehat-utama'],
            [
                'business_category_id' => $klinikCategory ? $klinikCategory->id : null,
                'brand_name' => 'Klinik Utama Medika Sehat',
                'client_name' => 'dr. Hendra Kusuma, Sp.PD (Direktur Medis)',
                'wa_number' => '6281234567890',
                'wa_template' => 'Halo tim Scalify, kami dari Manajemen Klinik Medika Sehat ingin konsultasi implementasi Sistem Informasi SIM Klinik & Rekam Medis Digital.',
                'price_silver' => 850000,
                'price_gold' => 1850000,
                'price_diamond' => 2500000,
                'price_platinum' => 3800000,
                'renewal_silver' => '600rb/tahun',
                'renewal_gold' => '800rb/tahun',
                'renewal_diamond' => '1.2juta/tahun',
                'renewal_platinum' => '50% per tahun',
            ]
        );
    }
}
