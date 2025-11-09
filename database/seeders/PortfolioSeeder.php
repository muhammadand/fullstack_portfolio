<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Pastikan category_id sesuai urutan insert di PortfolioCategorySeeder
        $portfolios = [
            [
                'category_id' => 1,
                'title' => 'Integrasi Qontak ke Flowise (AI Agent) — Node.js, Webhook, Redis',
                'slug' => 'integrasi-qontak-flowise-nodejs-webhook-redis',
                'client_name' => 'Globalkomunika (Proof of concept)',
                'project_type' => 'Integration, AI Agent',
                'short_description' => 'Membuat agent AI yang terhubung ke Qontak menggunakan Flowise, webhook, dan Node.js sebagai middleware.',
                'full_description' => "Proyek ini membangun pipeline integrasi antara platform Qontak dan Flowise sebagai AI agent. Node.js berperan sebagai middleware yang meneruskan webhook, meng-handle rate limit, caching dengan Redis, dan menyimpan event penting ke database. Hasil: response time berkurang, fallback handling saat Flowise timeout, dan logs terstruktur untuk audit.",
                'challenge' => "Rate limiting pada provider chat, sinkronisasi event, dan menjaga konsistensi state pada koneksi multi-channel.",
                'solution' => "Implementasi queue + retry (BullMQ), cache state sementara di Redis, dan arsitektur idempotent handler di Node.js.",
                'result' => "Tingkat keberhasilan automasi percakapan meningkat, waktu SLA turun 40%, dan pengurangan tiket CS manual.",
                'thumbnail_image' => 'images/portfolio/integrasi-qontak-flowise-thumb.jpg',
                'featured_image' => 'images/portfolio/integrasi-qontak-flowise.jpg',
                'technologies' => json_encode(['Node.js','Flowise','Qontak','Redis','Webhook','BullMQ']),
                'project_url' => null,
                'github_url' => null,
                'completion_date' => now()->subMonths(6)->toDateString(),
                'is_featured' => true,
                'view_count' => 0,
                'display_order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 2,
                'title' => 'Rewrite Backend Globalkomunika — Laravel, RESTful API, Redis, Queue',
                'slug' => 'rewrite-backend-globalkomunika-laravel-restful-redis',
                'client_name' => 'Globalkomunika',
                'project_type' => 'Backend Rewrite',
                'short_description' => 'Merewrite backend menjadi Laravel, menambahkan RESTful API, optimasi caching dengan Redis dan job queue untuk background processing.',
                'full_description' => "Rewrite backend legacy ke Laravel: struktur modular, service layer, optimized DB queries, Redis caching untuk endpoint berat, dan queue workers untuk pengolahan pesan & notifikasi. Sertakan dokumentasi API (OpenAPI) dan pengujian beban dasar.",
                'challenge' => "Monorepo lama, banyak endpoint blocking, dan tidak ada dokumentasi API.",
                'solution' => "Refactor ke service-oriented controllers, penambahan Redis cache, job queue untuk heavy tasks, dan dokumentasi OpenAPI.",
                'result' => "Latency API stabil, throughput meningkat, maintenance lebih mudah dan tim pengembangan lebih produktif.",
                'thumbnail_image' => 'images/portfolio/rewrite-globalkomunika-thumb.jpg',
                'featured_image' => 'images/portfolio/rewrite-globalkomunika.jpg',
                'technologies' => json_encode(['Laravel','PHP','MySQL','Redis','Docker','OpenAPI']),
                'project_url' => null,
                'github_url' => null,
                'completion_date' => now()->subYear()->toDateString(),
                'is_featured' => true,
                'view_count' => 0,
                'display_order' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 3,
                'title' => 'Sistem Penentuan Kelayakan KPR — Algoritma C4.5',
                'slug' => 'kelayakan-kpr-c45',
                'client_name' => 'Internal / R&D',
                'project_type' => 'Machine Learning',
                'short_description' => 'Implementasi C4.5 untuk klasifikasi kelayakan KPR berbasis data demografis dan finansial.',
                'full_description' => "Proyek R&D membangun sistem klasifikasi menggunakan algoritma C4.5 untuk menilai kelayakan permohonan KPR. Pipeline: data cleaning -> feature engineering -> C4.5 decision tree -> evaluasi (accuracy, precision, recall). Output dipaketkan dalam service yang dapat di-call oleh backend untuk memberikan rekomendasi awal.",
                'challenge' => "Data tidak seimbang dan missing values pada kolom finansial.",
                'solution' => "Imputasi missing value, SMOTE untuk balancing, pruning pohon untuk menghindari overfitting, dan validasi silang k-fold.",
                'result' => "Model mencapai performa yang memadai untuk screening awal dengan akurasi yang dapat ditingkatkan melalui data tambahan.",
                'thumbnail_image' => 'images/portfolio/c45-kpr-thumb.jpg',
                'featured_image' => 'images/portfolio/c45-kpr.jpg',
                'technologies' => json_encode(['Python','scikit-learn','pandas','C4.5','SMOTE']),
                'project_url' => null,
                'github_url' => null,
                'completion_date' => now()->subMonths(3)->toDateString(),
                'is_featured' => false,
                'view_count' => 0,
                'display_order' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('portfolios')->insert($portfolios);
    }
}
