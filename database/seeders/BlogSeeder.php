<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // === Blog Categories ===
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Artikel seputar pembuatan website profesional dan teknologi terkini.',
                'meta_description' => 'Tips dan insight seputar web development untuk bisnis modern.',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'description' => 'Strategi pemasaran digital untuk meningkatkan brand awareness dan penjualan.',
                'meta_description' => 'Pelajari strategi digital marketing terbaik untuk bisnis Anda.',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Branding & Design',
                'slug' => 'branding-design',
                'description' => 'Kunci membangun identitas visual yang kuat untuk bisnis Anda.',
                'meta_description' => 'Tips branding dan desain untuk meningkatkan citra perusahaan Anda.',
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'SEO Tips',
                'slug' => 'seo-tips',
                'description' => 'Teknik optimasi mesin pencari agar website mudah ditemukan.',
                'meta_description' => 'Panduan praktis SEO untuk meningkatkan trafik organik bisnis Anda.',
                'display_order' => 4,
                'is_active' => true,
            ],
        ];

        DB::table('blog_categories')->insert($categories);

        // === Blogs ===
        $blogs = [
            [
                'category_id' => 1,
                'author_id' => 1, // pastikan user id 1 ada (admin misalnya)
                'title' => 'Mengapa Bisnis Anda Butuh Website Profesional di 2025',
                'slug' => 'mengapa-bisnis-anda-butuh-website-profesional-2025',
                'excerpt' => 'Website bukan lagi sekadar kebutuhan tambahan, tapi fondasi utama bisnis modern.',
                'content' => 'Di era digital, pelanggan pertama kali mengenal bisnis Anda melalui internet. Website profesional bukan hanya meningkatkan kredibilitas, tapi juga memperluas jangkauan pasar. Tim kami siap membantu Anda membangun website yang cepat, aman, dan berdesain menarik sesuai kebutuhan bisnis Anda.',
                'featured_image' => 'images/blog/website-profesional.jpg',
                'tags' => json_encode(['Website', 'Bisnis', 'Teknologi']),
                'meta_title' => 'Website Profesional 2025',
                'meta_description' => 'Alasan penting bisnis membutuhkan website profesional tahun 2025.',
                'reading_time' => 4,
                'view_count' => 0,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'author_id' => 1,
                'title' => 'Strategi Digital Marketing yang Efektif untuk UMKM',
                'slug' => 'strategi-digital-marketing-efektif-umkm',
                'excerpt' => 'Promosi online tidak harus mahal, yang penting tepat sasaran.',
                'content' => 'Melalui social media, Google Ads, dan SEO, bisnis kecil pun bisa bersaing di pasar besar. Tim kami berpengalaman dalam membantu UMKM membangun strategi digital marketing yang efisien dan mengubah trafik menjadi pelanggan.',
                'featured_image' => 'images/blog/digital-marketing-umkm.jpg',
                'tags' => json_encode(['Digital Marketing', 'UMKM', 'Growth']),
                'meta_title' => 'Strategi Digital Marketing UMKM',
                'meta_description' => 'Tips promosi online untuk meningkatkan penjualan UMKM.',
                'reading_time' => 5,
                'view_count' => 0,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'author_id' => 1,
                'title' => 'Rahasia Membangun Brand yang Dikenal dan Diingat',
                'slug' => 'rahasia-membangun-brand-dikenal-dan-diingat',
                'excerpt' => 'Desain visual bukan sekadar estetika, tapi pesan yang membentuk persepsi.',
                'content' => 'Kami membantu banyak brand membangun identitas visual yang kuat dan mudah dikenali. Dari logo hingga tampilan website, semua disesuaikan agar pesan bisnis Anda tersampaikan dengan elegan dan profesional.',
                'featured_image' => 'images/blog/branding-design.jpg',
                'tags' => json_encode(['Branding', 'Desain', 'Bisnis']),
                'meta_title' => 'Branding Bisnis Efektif',
                'meta_description' => 'Cara membangun brand yang mudah diingat pelanggan.',
                'reading_time' => 3,
                'view_count' => 0,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'author_id' => 1,
                'title' => 'Cara Meningkatkan Trafik Website dengan SEO yang Tepat',
                'slug' => 'cara-meningkatkan-trafik-website-dengan-seo',
                'excerpt' => 'SEO bukan sihir — tapi strategi cerdas untuk bisnis tumbuh secara organik.',
                'content' => 'Dengan optimasi SEO yang benar, website Anda bisa muncul di halaman pertama Google. Kami menyediakan layanan SEO yang fokus pada hasil nyata: peningkatan trafik, engagement, dan konversi pelanggan.',
                'featured_image' => 'images/blog/seo-tips.jpg',
                'tags' => json_encode(['SEO', 'Website', 'Bisnis Online']),
                'meta_title' => 'SEO untuk Bisnis',
                'meta_description' => 'Panduan meningkatkan trafik dengan SEO efektif.',
                'reading_time' => 6,
                'view_count' => 0,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('blogs')->insert($blogs);
    }
}
