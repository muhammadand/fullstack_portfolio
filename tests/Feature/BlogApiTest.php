<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Services\Blog\BlogImageIngestor;
use App\Services\Blog\HtmlSanitizer;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class BlogApiTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        User::first() ?? User::create([
            'name' => 'Admin Blog API', 'email' => 'blog_api_' . uniqid() . '@example.com',
            'password' => bcrypt('password'), 'role' => 'admin',
        ]);
        RateLimiter::clear('');
    }

    private function fakeAi(string $html): void
    {
        Gemini::fake([GenerateContentResponse::fake([
            'candidates' => [['content' => ['parts' => [['text' => $html]], 'role' => 'model']]],
        ])]);
    }

    private function ingest(array $over = [])
    {
        return $this->postJson('/api/blogs', $over + [
            'title'    => 'Tren AI 2026 Untuk UMKM ' . uniqid(),
            'category' => 'Teknologi Riset ' . uniqid(),
            'content'  => '<h2>Pembuka</h2><p>Isi artikel.</p>',
        ]);
    }

    public function test_html_content_is_published_immediately_without_ai_and_category_is_created(): void
    {
        Gemini::fake(); // tidak boleh ada panggilan AI untuk konten HTML
        $category = 'Bisnis Digital ' . uniqid();

        $res = $this->ingest(['category' => $category, 'tags' => 'AI, umkm , ai, Riset'])
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.content_source', 'html')
            ->assertJsonPath('data.category.created', true)
            ->assertJsonPath('data.is_published', true);

        $blog = Blog::findOrFail($res->json('data.id'));
        $this->assertTrue($blog->is_published);
        $this->assertNotNull($blog->published_at);
        $this->assertSame('<h2>Pembuka</h2><p>Isi artikel.</p>', $blog->content);
        $this->assertSame(['AI', 'umkm', 'Riset'], $blog->tags);
        $this->assertSame($category, $blog->category->name);
        $this->assertSame(route('blogs.read', $blog->slug), $res->json('data.url'));
        Gemini::assertNothingSent();

        // Kategori yang sama (beda huruf besar/spasi) dipakai ulang, tidak dobel.
        $this->ingest(['category' => '  ' . strtoupper($category) . ' '])
            ->assertCreated()
            ->assertJsonPath('data.category.created', false)
            ->assertJsonPath('data.category.id', $blog->category_id);
    }

    public function test_json_content_is_converted_to_html_by_ai_and_sanitized(): void
    {
        $this->fakeAi("```html\n<h2>Ringkasan</h2><p onclick=\"x()\">Pasar tumbuh 20%.</p><script>alert(1)</script>\n```");

        $res = $this->ingest(['content' => [
            'sections' => [['heading' => 'Ringkasan', 'text' => 'Pasar tumbuh 20%.']],
        ]])->assertCreated()->assertJsonPath('data.content_source', 'ai');

        $this->assertSame('<h2>Ringkasan</h2><p>Pasar tumbuh 20%.</p>', Blog::find($res->json('data.id'))->content);
    }

    public function test_falls_back_to_simple_conversion_when_ai_fails(): void
    {
        Gemini::fake([new \RuntimeException('AI down')]);

        $res = $this->ingest(['content' => [
            ['type' => 'heading', 'text' => 'Latar Belakang'],
            ['type' => 'paragraph', 'text' => 'UMKM butuh <b>digitalisasi</b>.'],
            ['type' => 'list', 'items' => ['Website', 'Review Google']],
        ]])->assertCreated()->assertJsonPath('data.content_source', 'fallback');

        $this->assertSame(
            '<h2>Latar Belakang</h2><p>UMKM butuh &lt;b&gt;digitalisasi&lt;/b&gt;.</p><ul><li>Website</li><li>Review Google</li></ul>',
            Blog::find($res->json('data.id'))->content
        );
    }

    public function test_plain_text_fallback_makes_paragraphs_and_lists(): void
    {
        Gemini::fake([GenerateContentResponse::fake(['candidates' => [['content' => ['parts' => [['text' => '']], 'role' => 'model']]]])]);

        $res = $this->ingest(['content' => "Paragraf satu.\n\n- poin a\n- poin b"])->assertCreated();

        $this->assertSame('<p>Paragraf satu.</p><ul><li>poin a</li><li>poin b</li></ul>', Blog::find($res->json('data.id'))->content);
    }

    public function test_duplicate_titles_get_unique_slugs_and_meta_fields_are_trimmed_to_column_limits(): void
    {
        $title = 'Judul Sama Persis ' . uniqid();
        $a = $this->ingest(['title' => $title])->assertCreated()->json('data.slug');
        $b = $this->ingest([
            'title' => $title,
            'meta_title' => str_repeat('m', 100),
            'meta_description' => str_repeat('d', 400),
            'excerpt' => str_repeat('e', 400),
        ])->assertCreated()->json('data.slug');

        $this->assertNotSame($a, $b);
        $this->assertSame($a . '-2', $b);

        $blog = Blog::where('slug', $b)->first();
        $this->assertLessThanOrEqual(60, mb_strlen($blog->meta_title));
        $this->assertLessThanOrEqual(160, mb_strlen($blog->meta_description));
        $this->assertLessThanOrEqual(255, mb_strlen($blog->excerpt));
    }

    public function test_validation_errors(): void
    {
        $this->postJson('/api/blogs', [])->assertStatus(422)->assertJsonValidationErrors(['title', 'category', 'content']);
        $this->ingest(['content' => 12345])->assertStatus(422)->assertJsonValidationErrors('content');
        $this->ingest(['content' => '<script>alert(1)</script><p> </p>'])->assertStatus(422)->assertJsonValidationErrors('content');
    }

    public function test_endpoint_is_rate_limited(): void
    {
        Gemini::fake();
        for ($i = 0; $i < 30; $i++) {
            $this->ingest()->assertCreated();
        }

        $this->ingest()->assertStatus(429);
    }

    public function test_sanitizer_strips_dangerous_markup_but_keeps_safe_formatting(): void
    {
        $clean = app(HtmlSanitizer::class)->clean(
            '<h1>Judul</h1><p style="color:red" class="ql-align-center evil">Teks <strong>tebal</strong> <span>biasa</span></p>'
            . '<a href="javascript:alert(1)">jahat</a> <a href="https://contoh.id">aman</a>'
            . '<img src="x" onerror="alert(1)"><img src="https://contoh.id/a.png" alt="A">'
            . '<iframe src="https://evil.test"></iframe><!-- komentar --><div><p>dalam div</p></div>'
        );

        $this->assertSame(
            '<h2>Judul</h2><p class="ql-align-center">Teks <strong>tebal</strong> biasa</p>'
            . '<a>jahat</a> <a href="https://contoh.id" target="_blank" rel="nofollow noopener noreferrer">aman</a>'
            . '<img src="https://contoh.id/a.png" alt="A"><p>dalam div</p>',
            $clean
        );
    }

    /** PNG 1x1 asli. */
    private function pngBytes(): string
    {
        return base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
    }

    /** Resolver DNS palsu: host -> IP yang ditentukan test. */
    private function fakeDns(array $map): void
    {
        $this->app->instance(BlogImageIngestor::class, new BlogImageIngestor(fn ($host) => $map[$host] ?? []));
    }

    public function test_featured_image_as_multipart_file_with_json_content_string(): void
    {
        Storage::fake('public');
        Gemini::fake();

        $res = $this->post('/api/blogs', [
            'title' => 'Artikel Bergambar ' . uniqid(),
            'category' => 'Galeri',
            'content' => '<p>Isi dengan gambar.</p>',
            'featured_image' => UploadedFile::fake()->image('cover.jpg', 800, 450),
        ], ['Accept' => 'application/json'])->assertCreated();

        $blog = Blog::find($res->json('data.id'));
        $this->assertStringStartsWith('blog_images/', $blog->featured_image);
        $this->assertStringEndsWith('.jpg', $blog->featured_image);
        Storage::disk('public')->assertExists($blog->featured_image);
        $this->assertSame(asset('storage/' . $blog->featured_image), $res->json('data.featured_image'));
    }

    public function test_multipart_json_content_string_is_decoded_and_converted(): void
    {
        Storage::fake('public');
        Gemini::fake([new \RuntimeException('AI down')]);

        $res = $this->post('/api/blogs', [
            'title' => 'Multipart JSON ' . uniqid(),
            'category' => 'Galeri',
            'content' => json_encode([['type' => 'paragraph', 'text' => 'Dari multipart.']]),
            'featured_image' => UploadedFile::fake()->image('c.png'),
        ], ['Accept' => 'application/json'])->assertCreated()->assertJsonPath('data.content_source', 'fallback');

        $this->assertSame('<p>Dari multipart.</p>', Blog::find($res->json('data.id'))->content);
    }

    public function test_featured_image_as_base64_and_data_uri(): void
    {
        Storage::fake('public');
        Gemini::fake();

        foreach ([base64_encode($this->pngBytes()), 'data:image/png;base64,' . base64_encode($this->pngBytes())] as $value) {
            $path = Blog::find($this->ingest(['featured_image' => $value])->assertCreated()->json('data.id'))->featured_image;
            $this->assertStringEndsWith('.png', $path);
            $this->assertSame($this->pngBytes(), Storage::disk('public')->get($path));
        }
    }

    public function test_featured_image_from_public_url_is_downloaded(): void
    {
        Storage::fake('public');
        Gemini::fake();
        $this->fakeDns(['cdn.contoh.test' => ['93.184.216.34']]);
        Http::fake(['https://cdn.contoh.test/*' => Http::response($this->pngBytes(), 200, ['Content-Type' => 'image/png'])]);

        $path = Blog::find($this->ingest(['featured_image' => 'https://cdn.contoh.test/img/cover.png'])
            ->assertCreated()->json('data.id'))->featured_image;

        Storage::disk('public')->assertExists($path);
        Http::assertSent(fn ($r) => $r->url() === 'https://cdn.contoh.test/img/cover.png');
    }

    public function test_internal_urls_are_rejected_to_prevent_ssrf(): void
    {
        Storage::fake('public');
        Gemini::fake();
        Http::fake();
        $this->fakeDns(['internal.test' => ['10.0.0.5'], 'mixed.test' => ['93.184.216.34', '127.0.0.1']]);

        foreach ([
            'http://127.0.0.1/a.png', 'http://169.254.169.254/latest/meta-data', 'http://[::1]/a.png',
            'https://internal.test/a.png', 'https://mixed.test/a.png', 'https://tidak-ada.test/a.png',
            'ftp://contoh.test/a.png', 'https://user:pass@contoh.test/a.png',
        ] as $url) {
            $this->ingest(['featured_image' => $url])->assertStatus(422)->assertJsonValidationErrors('featured_image');
        }

        Http::assertNothingSent();
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_non_images_and_failed_downloads_are_rejected_without_creating_article(): void
    {
        Storage::fake('public');
        Gemini::fake();
        $this->fakeDns(['cdn.contoh.test' => ['93.184.216.34']]);
        Http::fake([
            'https://cdn.contoh.test/page.html' => Http::response('<html>bukan gambar</html>', 200, ['Content-Type' => 'image/png']),
            'https://cdn.contoh.test/missing.png' => Http::response('', 404),
        ]);
        $before = Blog::count();

        foreach ([
            UploadedFile::fake()->create('virus.php', 10, 'image/png'),
            base64_encode('<?php echo 1; ?>'),
            'bukan-base64-!!!',
            'https://cdn.contoh.test/page.html',
            'https://cdn.contoh.test/missing.png',
        ] as $value) {
            $this->post('/api/blogs', [
                'title' => 'Gagal ' . uniqid(), 'category' => 'Galeri', 'content' => '<p>x</p>', 'featured_image' => $value,
            ], ['Accept' => 'application/json'])->assertStatus(422)->assertJsonValidationErrors('featured_image');
        }

        $this->assertSame($before, Blog::count());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_oversized_image_is_rejected(): void
    {
        Storage::fake('public');
        Gemini::fake();

        $this->post('/api/blogs', [
            'title' => 'Besar ' . uniqid(), 'category' => 'Galeri', 'content' => '<p>x</p>',
            'featured_image' => UploadedFile::fake()->create('besar.jpg', 6000, 'image/jpeg'),
        ], ['Accept' => 'application/json'])->assertStatus(422)->assertJsonValidationErrors('featured_image');

        $this->ingest(['featured_image' => base64_encode(str_repeat('a', 6 * 1024 * 1024))])
            ->assertStatus(422)->assertJsonValidationErrors('featured_image');
    }

    public function test_article_without_image_still_works(): void
    {
        Gemini::fake();
        $res = $this->ingest()->assertCreated()->assertJsonPath('data.featured_image', null);
        $this->assertNull(Blog::find($res->json('data.id'))->featured_image);
    }
}
