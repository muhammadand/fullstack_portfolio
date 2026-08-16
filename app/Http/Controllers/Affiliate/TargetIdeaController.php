<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TargetIdeaController extends Controller
{
    public static function getIdeas()
    {
        return [
            'wedding-organizer' => [
                'title' => 'Wedding Organizer & Dekorasi',
                'category_id' => null,
                'image' => asset('img/ideas/wedding_idea.jpg'),
                'short_desc' => 'Tampilkan portofolio gaun, dekorasi, dan pricelist secara elegan.',
                'reason' => 'Bisnis pernikahan sangat mengandalkan visual (portofolio). Calon pengantin lebih percaya pada WO yang memiliki website resmi dengan galeri foto pernikahan yang indah, daftar paket harga yang jelas, dan testimoni pelanggan yang sah.',
                'features' => ['Galeri Portofolio HD', 'Daftar Paket & Harga', 'Formulir Booking/Konsultasi', 'Integrasi WhatsApp', 'Katalog Vendor Partner']
            ],
            'rental-kendaraan' => [
                'title' => 'Rental Mobil & Motor',
                'category_id' => null,
                'image' => asset('img/ideas/rental_idea.jpg'),
                'short_desc' => 'Tingkatkan booking kendaraan dengan katalog online 24 jam.',
                'reason' => 'Turis atau penyewa mobil biasanya mencari lewat Google sebelum tiba di kota tujuan. Memiliki website akan meningkatkan visibilitas di Google, membuat penyewa bisa melihat ketersediaan armada, dan memudahkan proses booking kapan saja.',
                'features' => ['Katalog Armada & Spesifikasi', 'Sistem Booking & Kalender', 'Daftar Harga Sewa', 'Syarat & Ketentuan', 'Tombol Pesan via WA']
            ],
            'cafe-coffee-shop' => [
                'title' => 'Cafe & Coffee Shop',
                'category_id' => null,
                'image' => asset('img/ideas/cafe_idea.jpg'),
                'short_desc' => 'Tampilkan menu digital dan suasana estetik tempat ngopi.',
                'reason' => 'Meskipun sudah ada GoFood/GrabFood, pelanggan sering ingin melihat ambience (suasana) cafe, menu lengkap, dan lokasi untuk nongkrong atau nugas. Website bisa dijadikan menu QR di meja, dan sarana branding yang sangat kuat.',
                'features' => ['Menu Digital Dinamis', 'Galeri Suasana Ruangan', 'Jam Operasional & Maps', 'Reservasi Meja', 'Integrasi Social Media']
            ],
            'hotel-penginapan' => [
                'title' => 'Hotel, Villa & Homestay',
                'category_id' => null,
                'image' => asset('img/ideas/hotel_idea.jpg'),
                'short_desc' => 'Kurangi potongan komisi OTA (Traveloka/Agoda) dengan direct booking.',
                'reason' => 'Penginapan sering tercekik komisi tinggi dari aplikasi booking (OTA). Dengan website sendiri, mereka bisa menerima Direct Booking, menawarkan diskon khusus, dan memamerkan fasilitas kamar dengan lebih leluasa.',
                'features' => ['Sistem Direct Booking', 'Tur Virtual/Galeri Kamar', 'Fasilitas & Layanan', 'Review Tamu Asli', 'Promo Eksklusif Website']
            ],
            'sekolah-pendidikan' => [
                'title' => 'Sekolah & Bimbingan Belajar',
                'category_id' => null,
                'image' => asset('img/ideas/school_idea.jpg'),
                'short_desc' => 'Permudah PPDB online dan tingkatkan kredibilitas instansi.',
                'reason' => 'Sekolah tanpa website dianggap kurang profesional di era digital. Website sangat penting untuk penerimaan siswa baru (PPDB) online, portal informasi bagi orang tua wali, dan galeri kegiatan prestasi siswa.',
                'features' => ['Sistem PPDB Online', 'Profil Guru & Staff', 'Berita & Pengumuman', 'Galeri Ekstrakurikuler', 'Portal Download Materi']
            ],
            'instansi-pemerintah' => [
                'title' => 'Pemerintahan & Desa',
                'category_id' => null,
                'image' => asset('img/ideas/gov_idea.jpg'),
                'short_desc' => 'Tingkatkan transparansi publik dan pelayanan digital.',
                'reason' => 'Sesuai arahan pemerintah pusat mengenai digitalisasi (Smart Village/Smart City), setiap instansi atau desa diwajibkan memiliki portal publik untuk pelayanan, laporan dana desa, dan informasi warga.',
                'features' => ['Portal Berita Instansi', 'Layanan Surat Menyurat', 'Transparansi Anggaran', 'Galeri Kegiatan', 'Direktori Pejabat']
            ],
            'jasa-laundry' => [
                'title' => 'Jasa Laundry & Cuci Sepatu',
                'category_id' => null,
                'image' => asset('img/ideas/laundry_idea.jpg'),
                'short_desc' => 'Terima order antar-jemput cucian secara online.',
                'reason' => 'Orang-orang super sibuk ingin kemudahan mencari laundry yang bisa antar-jemput. Website memastikan laundry tersebut muncul di pencarian lokal Google, lengkap dengan daftar layanan dan tombol request pickup.',
                'features' => ['Form Order Antar-Jemput', 'Daftar Layanan & Harga', 'Status Pengerjaan (Tracking)', 'Testimoni Pelanggan', 'Promo Member']
            ],
            'pedagang-sarapan' => [
                'title' => 'Pedagang Sarapan / Kaki Lima',
                'category_id' => null,
                'image' => asset('img/ideas/breakfast_idea.jpg'),
                'short_desc' => 'Buktikan bahwa warung kaki lima bisa go-digital & viral.',
                'reason' => 'Jangan salah, pedagang nasi uduk, bubur ayam, atau jajanan pinggir jalan pun butuh go digital! Sebuah landing page sederhana bisa memuat menu, menerima pesanan pre-order kantor/katering, dan jadi modal promosi viral di TikTok.',
                'features' => ['Menu Lengkap', 'Order Katering/Borongan', 'Lokasi Akurat (Maps)', 'Jam Buka Real-time', 'Tombol Pesan WhatsApp']
            ],
            'toko-kue-donat' => [
                'title' => 'Toko Kue, Roti & Donat',
                'category_id' => null,
                'image' => asset('img/ideas/bakery_idea.jpg'),
                'short_desc' => 'Tampilkan katalog kue menggiurkan dan terima pesanan custom.',
                'reason' => 'Visual kue yang manis dan estetis sangat penting. Pelanggan butuh melihat katalog bentuk kue (terutama custom cake untuk ulang tahun) dan melihat daftar harga sebelum memesan. Website adalah showcase terbaik!',
                'features' => ['Katalog Roti/Kue', 'Form Custom Order', 'Daftar Harga Cake', 'Testimoni', 'Informasi Pengiriman']
            ],
            'toko-elektronik' => [
                'title' => 'Toko Elektronik & Komputer',
                'category_id' => null,
                'image' => asset('img/ideas/electronic_idea.jpg'),
                'short_desc' => 'Katalog produk gadget dengan spesifikasi teknis lengkap.',
                'reason' => 'Pembeli elektronik sangat mementingkan spesifikasi produk (RAM, Prosesor, Garansi). Katalog di Instagram atau WA kurang rapi. Website e-commerce atau katalog memberikan pengalaman belanja yang profesional dan mempermudah perbandingan produk.',
                'features' => ['Katalog Produk (Filter Spesifikasi)', 'Status Stok', 'Klaim Garansi Online', 'Integrasi Tokopedia/Shopee', 'Live Chat Bantuan Teknisi']
            ],
            'toko-boneka-mainan' => [
                'title' => 'Toko Boneka & Mainan Anak',
                'category_id' => null,
                'image' => asset('img/ideas/toys_idea.jpg'),
                'short_desc' => 'Katalog mainan yang menggemaskan dan aman untuk anak.',
                'reason' => 'Pembeli utama (orang tua atau orang yang mencari kado) membutuhkan detail produk seperti bahan, ukuran, dan rentang usia anak. Website e-katalog mempermudah pencarian mainan berdasarkan kategori usia atau gender.',
                'features' => ['Kategori Berdasarkan Usia', 'Galeri Produk HD', 'Tombol Order WhatsApp', 'Promo Diskon Kado', 'Review Pembeli']
            ]
        ];
    }

    public function show($slug)
    {
        $ideas = self::getIdeas();
        
        if (!array_key_exists($slug, $ideas)) {
            abort(404);
        }

        $idea = $ideas[$slug];
        $idea['slug'] = $slug;

        // Ambil Business Categories dari DB untuk form modal Buat Proposal
        $categories = \App\Models\BusinessCategory::all();

        return view('affiliate.ideas.show_mobile', compact('idea', 'categories'));
    }
}
