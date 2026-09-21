<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\BusinessCategory::updateOrCreate(
            ['slug' => 'wedding'],
            [
                'name' => 'Wedding',
                'wa_template' => 'Halo tim Scalify, saya tertarik untuk diskusi lebih lanjut mengenai penawaran website Wedding.',
                'project_price' => 4500000,
                'domain_price' => 1200000,
            ]
        );

        \App\Models\BusinessCategory::updateOrCreate(
            ['slug' => 'barbershop'],
            [
                'name' => 'Barbershop',
                'wa_template' => 'Halo tim Scalify, saya pengusaha Barbershop dan butuh website booking/landing page.',
                'project_price' => 3000000,
                'domain_price' => 1200000,
            ]
        );

        \App\Models\BusinessCategory::updateOrCreate(
            ['slug' => 'travel'],
            [
                'name' => 'Travel & Shuttle',
                'wa_template' => 'Halo tim Scalify, saya pengusaha Travel / Shuttle dan tertarik untuk membuat sistem website booking jadwal dan armada.',
                'project_price' => 4500000,
                'domain_price' => 1200000,
            ]
        );

        \App\Models\BusinessCategory::updateOrCreate(
            ['slug' => 'lpk'],
            [
                'name' => 'LPK & Lembaga Pelatihan Kerja',
                'wa_template' => 'Halo tim Scalify, saya dari Lembaga Pelatihan Kerja (LPK) dan tertarik untuk konsultasi pembuatan sistem website LMS, ujian online, absensi, sertifikat, dan pendaftaran calon pekerja.',
                'project_price' => 5500000,
                'domain_price' => 1200000,
            ]
        );
    }
}
