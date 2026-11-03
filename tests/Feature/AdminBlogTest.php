<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBlogTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;
    protected BlogCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::first() ?? User::factory()->create();
        $this->category = BlogCategory::create([
            'name' => 'Kategori Test ' . uniqid(),
            'slug' => 'kategori-test-' . uniqid(),
            'display_order' => 1,
            'is_active' => true,
        ]);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Artikel Test Standarisasi',
            'category_id' => $this->category->id,
            'author_id' => $this->admin->id,
            'content' => '<p>Isi artikel test.</p>',
            'tags' => ['Laravel, Tutorial ,  Web'],
            'is_featured' => '0',
            'is_published' => '1',
        ], $overrides);
    }

    private function makeBlog(array $attributes = []): Blog
    {
        return Blog::create(array_merge([
            'title' => 'Blog Lama',
            'slug' => 'blog-lama-' . uniqid(),
            'category_id' => $this->category->id,
            'author_id' => $this->admin->id,
            'content' => '<p>Lama</p>',
            'excerpt' => 'Ringkasan lama',
            'is_published' => true,
            'is_featured' => true,
            'published_at' => now()->subMonth(),
        ], $attributes));
    }

    public function test_all_blog_pages_render(): void
    {
        $blog = $this->makeBlog();
        $this->actingAs($this->admin);

        $this->get(route('blogs.index'))->assertOk()->assertSee('Daftar Blog');
        $this->get(route('blogs.create'))->assertOk()->assertSee('Buat Blog Baru')->assertSee('data-upload-url', false);
        $this->get(route('blogs.edit', $blog))->assertOk()->assertSee('Simpan Perubahan');
        $this->get(route('blogs.show', $blog))->assertOk()->assertSee('Blog Lama');
    }

    public function test_index_search_filters_by_title(): void
    {
        $this->makeBlog(['title' => 'Panduan Unik Zebra']);
        $this->makeBlog(['title' => 'Artikel Lain Sekali']);

        $this->actingAs($this->admin)
            ->get(route('blogs.index', ['q' => 'Zebra']))
            ->assertOk()
            ->assertSee('Panduan Unik Zebra')
            ->assertDontSee('Artikel Lain Sekali');
    }

    public function test_store_splits_tags_into_array(): void
    {
        $this->actingAs($this->admin)
            ->post(route('blogs.store'), $this->payload())
            ->assertRedirect(route('blogs.index'));

        $blog = Blog::where('title', 'Artikel Test Standarisasi')->latest('id')->first();
        $this->assertSame(['Laravel', 'Tutorial', 'Web'], $blog->tags);
        $this->assertSame('Isi artikel test.', $blog->getRawOriginal('excerpt'), 'Excerpt kosong diisi otomatis dari konten');
        $this->assertTrue($blog->is_published);
        $this->assertNotNull($blog->published_at);
    }

    public function test_update_can_unpublish_and_unfeature(): void
    {
        $blog = $this->makeBlog();

        $this->actingAs($this->admin)
            ->put(route('blogs.update', $blog), $this->payload(['is_published' => '0', 'is_featured' => '0']))
            ->assertRedirect(route('blogs.index'));

        $blog->refresh();
        $this->assertFalse($blog->is_published);
        $this->assertFalse($blog->is_featured);
        $this->assertNull($blog->published_at);
    }

    public function test_update_keeps_original_published_date(): void
    {
        $blog = $this->makeBlog();
        $originalDate = $blog->published_at->toDateTimeString();

        $this->actingAs($this->admin)->put(route('blogs.update', $blog), $this->payload());

        $this->assertSame($originalDate, $blog->fresh()->published_at->toDateTimeString());
    }

    public function test_update_can_remove_featured_image(): void
    {
        Storage::fake('public');
        $path = UploadedFile::fake()->image('lama.jpg')->store('blog_images', 'public');
        $blog = $this->makeBlog(['featured_image' => $path]);

        $this->actingAs($this->admin)
            ->put(route('blogs.update', $blog), $this->payload(['remove_image' => '1']));

        $this->assertNull($blog->fresh()->featured_image);
        Storage::disk('public')->assertMissing($path);
    }
}
