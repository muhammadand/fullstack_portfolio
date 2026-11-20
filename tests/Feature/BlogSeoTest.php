<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Support\SitemapBuilder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class BlogSeoTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;
    protected BlogCategory $category;

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'https://scalifyintellegence.my.id']);
        File::ensureDirectoryExists(dirname(SitemapBuilder::path()));
        File::delete(SitemapBuilder::path());

        $this->admin = User::first() ?? User::create([
            'name' => 'Admin SEO', 'email' => 'seo_' . uniqid() . '@example.com',
            'password' => bcrypt('password'), 'role' => 'admin',
        ]);
        $this->category = BlogCategory::create([
            'name' => 'SEO ' . uniqid(), 'slug' => 'seo-' . uniqid(), 'display_order' => 1, 'is_active' => true,
        ]);
    }

    protected function tearDown(): void
    {
        File::delete(SitemapBuilder::path());
        parent::tearDown();
    }

    private function makeBlog(array $over = []): Blog
    {
        return Blog::create($over + [
            'category_id' => $this->category->id, 'author_id' => $this->admin->id,
            'title' => 'Artikel SEO ' . uniqid(), 'excerpt' => 'Ringkasan', 'content' => '<p>Isi artikel.</p>',
            'is_published' => true, 'published_at' => now()->subMinute(),
        ]);
    }

    private function sitemap(): string
    {
        $this->assertFileExists(SitemapBuilder::path());

        return File::get(SitemapBuilder::path());
    }

    public function test_sitemap_is_rewritten_automatically_when_blog_is_published_and_removed(): void
    {
        $draft = $this->makeBlog(['is_published' => false, 'published_at' => null]);
        $this->assertStringNotContainsString("/s/blog/{$draft->slug}<", $this->sitemap());

        $draft->update(['is_published' => true, 'published_at' => now()->subMinute()]);
        $this->assertStringContainsString("https://scalifyintellegence.my.id/s/blog/{$draft->slug}</loc>", $this->sitemap());

        $draft->delete();
        $this->assertStringNotContainsString("/s/blog/{$draft->slug}<", $this->sitemap());
    }

    public function test_sitemap_uses_app_url_includes_static_pages_and_featured_image(): void
    {
        $blog = $this->makeBlog(['featured_image' => 'blog_images/cover.jpg']);
        $xml = $this->sitemap();

        $this->assertStringContainsString('<loc>https://scalifyintellegence.my.id/s/blogs</loc>', $xml);
        $this->assertStringContainsString('<loc>https://scalifyintellegence.my.id/</loc>', $xml);
        $this->assertStringContainsString("<loc>https://scalifyintellegence.my.id/s/blog/{$blog->slug}</loc>", $xml);
        $this->assertStringContainsString('https://scalifyintellegence.my.id/storage/blog_images/cover.jpg', $xml);
        $this->assertNotFalse(simplexml_load_string($xml), 'sitemap harus XML valid');
    }

    public function test_view_count_increments_do_not_rewrite_sitemap(): void
    {
        $blog = $this->makeBlog();
        File::delete(SitemapBuilder::path());

        $this->get(route('blogs.read', $blog->slug))->assertOk();

        $this->assertSame(1, $blog->fresh()->view_count);
        $this->assertFileDoesNotExist(SitemapBuilder::path());
    }

    public function test_generate_sitemap_route_still_works(): void
    {
        $this->makeBlog();
        File::delete(SitemapBuilder::path());

        $this->get('/generate-sitemap')->assertOk()->assertSee('Sitemap dinamis berhasil dibuat!');
        $this->assertFileExists(SitemapBuilder::path());
    }

    public function test_editing_title_in_admin_keeps_the_original_slug(): void
    {
        $blog = $this->makeBlog(['title' => 'Judul Awal Banget ' . uniqid()]);
        $slug = $blog->slug;

        $this->actingAs($this->admin)->put(route('blogs.update', $blog), [
            'category_id' => $this->category->id, 'author_id' => $this->admin->id,
            'title' => 'Judul Diganti Total', 'content' => '<p>Isi baru.</p>', 'is_published' => 1,
        ])->assertRedirect(route('blogs.index'));

        $this->assertSame($slug, $blog->fresh()->slug);
        $this->assertSame('Judul Diganti Total', $blog->fresh()->title);
        $this->get(route('blogs.read', $slug))->assertOk();
    }

    public function test_creating_two_blogs_with_the_same_title_gets_unique_slugs(): void
    {
        $title = 'Judul Kembar ' . uniqid();
        $payload = [
            'category_id' => $this->category->id, 'author_id' => $this->admin->id,
            'title' => $title, 'content' => '<p>Isi.</p>', 'is_published' => 1,
        ];

        $this->actingAs($this->admin)->post(route('blogs.store'), $payload)->assertRedirect(route('blogs.index'));
        $this->actingAs($this->admin)->post(route('blogs.store'), $payload)->assertRedirect(route('blogs.index'));

        $slugs = Blog::where('title', $title)->orderBy('id')->pluck('slug')->all();
        $this->assertCount(2, $slugs);
        $this->assertSame($slugs[0] . '-2', $slugs[1]);
    }

    public function test_read_page_has_valid_json_ld_with_existing_logo_and_escaped_title(): void
    {
        $blog = $this->makeBlog([
            'title' => 'Kenapa "Website" Penting </script><script>alert(1)</script> ' . uniqid(),
            'meta_description' => 'Deskripsi dengan "kutip" & simbol',
            'tags' => ['SEO', 'UMKM'],
        ]);

        $html = $this->get(route('blogs.read', $blog->slug))->assertOk()->getContent();

        $this->assertSame(1, preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m));
        $this->assertStringNotContainsString('<script>alert(1)</script>', $m[1]);

        $data = json_decode($m[1], true);
        $this->assertIsArray($data, 'JSON-LD harus valid');
        $this->assertSame('BlogPosting', $data['@type']);
        $this->assertSame($blog->title, $data['headline']);
        $this->assertSame(route('blogs.read', $blog->slug), $data['mainEntityOfPage']['@id']);
        $this->assertStringEndsWith('/scalify.png', $data['publisher']['logo']['url']);
        $this->assertFileExists(public_path('scalify.png'));
        $this->assertSame('SEO, UMKM', $data['keywords']);
    }

    public function test_every_public_page_outputs_valid_json_ld(): void
    {
        $blog = $this->makeBlog(['title' => 'Judul "Kutip" & <Tag> ' . uniqid()]);
        $paths = ['/', '/layanan/scm', '/layanan/template-cv', '/s/blogs', '/s/portfolio', '/s/careers',
            '/travell', '/google-review-card', '/top-up-game', route('blogs.read', $blog->slug, false)];
        if ($portfolio = \App\Models\Portfolio::active()->first()) {
            $paths[] = "/s/portfolio/{$portfolio->slug}";
        }

        foreach ($paths as $path) {
            $html = $this->get($path)->assertOk()->getContent();
            $this->assertStringNotContainsString('json_encode(', $html, "Kode Blade bocor ke HTML di {$path}");

            preg_match_all('#<script[^>]*application/ld\+json[^>]*>(.*?)</script>#si', $html, $m);
            foreach ($m[1] as $i => $json) {
                json_decode($json);
                $this->assertSame(JSON_ERROR_NONE, json_last_error(), "JSON-LD #{$i} rusak di {$path}: " . json_last_error_msg());
            }
        }
    }

    /**
     * Formatter editor pernah memecah "{!! ... !!}" jadi "{" + "!!...!!" + "}" sehingga Blade
     * mencetak kodenya mentah (JSON-LD rusak di Search Console). Test ini menangkapnya lebih awal.
     */
    public function test_no_blade_echo_tags_are_split_by_a_formatter(): void
    {
        $broken = [];
        foreach (File::allFiles(resource_path('views')) as $file) {
            if (!str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }
            foreach (file($file->getPathname()) as $n => $line) {
                if (preg_match('/^\s*!!\s*\S|\S\s*!!\s*$/', $line) && !str_contains($line, '{!!') && !str_contains($line, '!!}')) {
                    $broken[] = $file->getRelativePathname() . ':' . ($n + 1) . '  ' . trim($line);
                }
            }
        }

        $this->assertSame([], $broken, "Tag Blade terpecah:\n" . implode("\n", $broken));
    }

    public function test_blog_views_and_daily_views_are_counted_with_upsert(): void
    {
        // Satu request per test: callback "afterResponse" menumpuk di instance app yang sama bila
        // ada beberapa request dalam satu test (di server tiap request = proses baru).
        $blog = $this->makeBlog();
        Blog::whereKey($blog->id)->update(['view_count' => 5]);
        \App\Models\DailyView::create([
            'viewable_type' => Blog::class, 'viewable_id' => $blog->id,
            'date' => now()->toDateString(), 'views_count' => 5,
        ]);

        $this->get(route('blogs.read', $blog->slug))->assertOk();

        $this->assertSame(6, $blog->fresh()->view_count);
        $daily = \App\Models\DailyView::where('viewable_type', Blog::class)->where('viewable_id', $blog->id)->get();
        $this->assertCount(1, $daily, 'upsert harus menambah baris yang sama, bukan membuat baris baru');
        $this->assertSame(6, (int) $daily->first()->views_count);
    }
}
