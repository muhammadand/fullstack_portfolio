<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan tabel dulu sebelum re-seed
        DB::table('student_services')->truncate();

        $services = [
            // Kategori: Enterprise Systems (CRM, SCM, ERP)
            [
                'name' => 'Analytical CRM (Customer Relationship Management)',
                'category' => 'Sistem Enterprise (CRM/SCM)',
                'min_price' => 2000000,
                'max_price' => 4500000,
                'description' => 'Aplikasi CRM untuk menganalisis data pelanggan. Cocok untuk skripsi Sistem Informasi. Contoh Kasus: "Sistem CRM Analytical untuk Prediksi Churn Pelanggan Telco", "CRM untuk Rekomendasi Produk Berdasarkan Riwayat Belanja (Market Basket Analysis)".',
            ],
            [
                'name' => 'SCM (Supply Chain Management)',
                'category' => 'Sistem Enterprise (CRM/SCM)',
                'min_price' => 2500000,
                'max_price' => 5000000,
                'description' => 'Aplikasi SCM untuk rantai pasok. Contoh Kasus: "Sistem Manajemen Rantai Pasok (SCM) untuk Prediksi Ketersediaan Bahan Baku Restoran", "SCM Terintegrasi Vendor dan Gudang menggunakan Metode EOQ (Economic Order Quantity)".',
            ],
            [
                'name' => 'ERP (Enterprise Resource Planning) Mini',
                'category' => 'Sistem Enterprise (CRM/SCM)',
                'min_price' => 3000000,
                'max_price' => 6000000,
                'description' => 'Aplikasi gabungan HRD, Keuangan, dan Operasional. Contoh Kasus: "Sistem ERP Modul HR dan Penggajian untuk UMKM", "Mini ERP terintegrasi untuk Manajemen Inventaris dan Laba Rugi".',
            ],

            // Kategori: Data Science & SPK
            [
                'name' => 'Sistem Pendukung Keputusan (SPK) - Metode SAW & TOPSIS',
                'category' => 'Data Science & SPK',
                'min_price' => 1500000,
                'max_price' => 2500000,
                'description' => 'Aplikasi SPK untuk memilih alternatif terbaik. Contoh Kasus: "SPK Pemilihan Karyawan Teladan menggunakan TOPSIS", "SPK Penentuan Penerima Beasiswa Kurang Mampu (SAW)". Sangat diminati mahasiswa IT/SI.',
            ],
            [
                'name' => 'Sistem Pendukung Keputusan (SPK) - Metode AHP',
                'category' => 'Data Science & SPK',
                'min_price' => 1800000,
                'max_price' => 3000000,
                'description' => 'SPK berbasis Analytical Hierarchy Process yang hitungannya kompleks. Contoh Kasus: "SPK Pemilihan Lokasi Cabang Baru Minimarket", "SPK Evaluasi Vendor IT Perusahaan".',
            ],
            [
                'name' => 'Data Science / Data Mining (Klasifikasi & Klastering)',
                'category' => 'Data Science & SPK',
                'min_price' => 2500000,
                'max_price' => 4500000,
                'description' => 'Implementasi algoritma AI/Data Mining. Contoh Kasus: "Klastering Area Rawan Banjir menggunakan K-Means", "Klasifikasi Kelulusan Tepat Waktu Mahasiswa dengan Naive Bayes / Decision Tree".',
            ],
            [
                'name' => 'Sistem Pakar (Expert System)',
                'category' => 'Data Science & SPK',
                'min_price' => 1500000,
                'max_price' => 2500000,
                'description' => 'Aplikasi yang meniru diagnosa pakar (Forward/Backward Chaining atau Certainty Factor). Contoh Kasus: "Sistem Pakar Diagnosa Penyakit Kulit pada Kucing", "Sistem Pakar Deteksi Kerusakan Mesin Kendaraan".',
            ],

            // Kategori: E-Commerce & Marketplace
            [
                'name' => 'E-Commerce / Toko Online Skripsi',
                'category' => 'Website E-Commerce & Bisnis',
                'min_price' => 1500000,
                'max_price' => 3500000,
                'description' => 'Aplikasi E-Commerce lengkap dengan Payment Gateway dan Ongkir. Contoh Kasus: "Sistem Informasi Penjualan Berbasis Web dengan Rekomendasi Produk (Collaborative Filtering)", "E-Commerce Integrasi API Midtrans dan RajaOngkir".',
            ],
            [
                'name' => 'Sistem Reservasi / Booking Online',
                'category' => 'Website E-Commerce & Bisnis',
                'min_price' => 1500000,
                'max_price' => 3000000,
                'description' => 'Aplikasi untuk booking jasa atau penyewaan. Contoh Kasus: "Sistem Informasi Booking Lapangan Futsal Real-time", "Website Reservasi Klinik Gigi Berbasis Web".',
            ],

            // Kategori: Manajemen & Administrasi
            [
                'name' => 'Sistem Informasi Akademik / Sekolah',
                'category' => 'Sistem Manajemen & Administrasi',
                'min_price' => 2000000,
                'max_price' => 4000000,
                'description' => 'Portal akademik lengkap. Contoh Kasus: "Sistem Informasi Akademik dan Portal Raport Online Berbasis Web", "Aplikasi Penerimaan Siswa Baru (PPDB) Online Terintegrasi".',
            ],
            [
                'name' => 'Aplikasi Kasir / POS (Point of Sales)',
                'category' => 'Sistem Manajemen & Administrasi',
                'min_price' => 1500000,
                'max_price' => 3000000,
                'description' => 'Sistem kasir toko. Cocok untuk Tugas Akhir D3. Contoh Kasus: "Sistem Informasi Point of Sales dan Manajemen Inventaris Apotek", "Aplikasi Kasir Cafe Berbasis Web (Support Barcode)".',
            ],
            [
                'name' => 'Company Profile / Portofolio Dinamis',
                'category' => 'Tugas Kuliah / Praktikum',
                'min_price' => 500000,
                'max_price' => 1000000,
                'description' => 'Website statis/dinamis ringan untuk tugas akhir semester matkul Web Programming. Memuat fitur CRUD sederhana (CMS blog).',
            ],
        ];

        foreach ($services as $service) {
            \App\Models\StudentService::create($service);
        }
    }
}
