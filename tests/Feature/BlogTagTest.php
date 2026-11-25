<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Support\BlogTags;
use App\Support\SitemapBuilder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class BlogTagTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;
    protected BlogCategory $category;
    protected string $u; // akhiran unik agar tidak bentrok dengan data lain di database

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'https://scalifyintellegence.my.id']);
        File::ensureDirectoryExists(dirname(SitemapBuilder::path()));
        BlogTags::flush();

        $this->u = substr(uniqid(), -6);
        $this->admin = User::first() ?? User::create([
            'name' => 'Admin Tag', 'email' => 'tag_' . uniqid() . '@example.com',
            'password' => bcrypt('password'), 'role' => 'admin',
        ]);
        $this->category = BlogCategory::create([
            'name' => 'Tag Cat ' . $this->u, 'slug' => 'tag-cat-' . $this->u, 'display_order' => 1, 'is_active' => true,
        ]);
    }

    protected function tearDown(): void
    {
        File::delete(SitemapBuilder::path());
        parent::tearDown();
    }

    private function blog(array $tags, array $over = []): Blog
    {
        return Blog::create($over + [
            'category_id' => $this->category->id, 'author_id' => $this->admin->id,
            'title' => 'Artikel Tag ' . uniqid(), 'excerpt' => 'Ringkasan', 'content' => '<p>Isi.</p>',
            'tags' => $tags, 'is_published' => true, 'published_at' => now()->subMinutes(5),
        ]);
    }

    private function tag(string $name): string
    {
        return "{$name} {$this->u}";
    }

    public function test_normalize_strips_hash_splits_commas_and_dedupes_case_insensitively(): void
    {
        // Ejaan yang pertama muncul dipertahankan; duplikat beda huruf besar/kecil/spasi/'#' dibuang.
        $this->assertSame(['AI', 'umkm digital', 'SEO'], BlogTags::normalize(['#AI', 'umkm   digital, ai', ' #UMKM Digital', 'SEO', '#', '']));
        $this->assertSame(['Laravel', 'web'], BlogTags::normalize('Laravel, #web ,'));
        $this->assertSame([], BlogTags::normalize(null));
    }

    public function test_tag_page_lists_only_published_articles_with_that_tag(): void
    {
        $tag = $this->tag('Digital Marketing');
        $a = $this->blog([$tag, 'Lain']);
        $b = $this->blog(['#' . strtoupper($tag)]);
        $other = $this->blog(['Bukan Ini ' . $this->u]);
        $draft = $this->blog([$tag], ['is_published' => false, 'published_at' => null]);
        $future = $this->blog([$tag], ['published_at' => now()->addDay()]);

        $slug = BlogTags::slug($tag);
        $res = $this->get(route('blogs.tag', $slug))->assertOk()
            ->assertSee($a->title)->assertSee($b->title)
            ->assertDontSee($other->title)->assertDontSee($draft->title)->assertDontSee($future->title)
            ->assertSee('<link rel="canonical" href="' . route('blogs.tag', $slug) . '" />', false)
            ->assertSee('index, follow', false);

        preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $res->getContent(), $m);
        $schema = json_decode($m[1], true);
        $this->assertSame('CollectionPage', $schema['@graph'][0]['@type']);
        $this->assertSame(2, $schema['@graph'][0]['mainEntity']['numberOfItems']);
        $this->assertSame('BreadcrumbList', $schema['@graph'][1]['@type']);
    }

    public function test_non_canonical_tag_urls_redirect_and_unknown_tags_404(): void
    {
        $tag = $this->tag('Web Design');
        $this->blog([$tag]);
        $slug = BlogTags::slug($tag);

        $this->get('/s/blogs/tag/' . rawurlencode($tag))->assertRedirect(route('blogs.tag', $slug))->assertStatus(301);
        $this->get('/s/blogs/tag/tidak-ada-tag-' . $this->u)->assertNotFound();
    }

    public function test_thin_tag_pages_are_noindex_and_left_out_of_sitemap(): void
    {
        $thin = $this->tag('Satu Artikel');
        $rich = $this->tag('Dua Artikel');
        $this->blog([$thin, $rich]);
        $this->blog([$rich]);

        $this->get(route('blogs.tag', BlogTags::slug($thin)))->assertOk()->assertSee('noindex, follow', false);
        $this->get(route('blogs.tag', BlogTags::slug($rich)))->assertOk()->assertDontSee('noindex', false);

        $xml = File::get(SitemapBuilder::write());
        $this->assertStringContainsString('/s/blogs/tag/' . BlogTags::slug($rich) . '</loc>', $xml);
        $this->assertStringNotContainsString('/s/blogs/tag/' . BlogTags::slug($thin) . '<', $xml);
    }

    public function test_sitemap_written_on_save_already_contains_the_new_tag(): void
    {
        $tag = $this->tag('Langsung Masuk');
        $this->blog([$tag]);
        $this->blog([$tag]); // tag kedua -> indexable; sitemap ditulis di event "created"

        $this->assertStringContainsString('/s/blogs/tag/' . BlogTags::slug($tag) . '</loc>', File::get(SitemapBuilder::path()));
    }

    public function test_read_page_shows_clickable_tag_links_and_keywords(): void
    {
        $tag = $this->tag('Landing Page');
        $blog = $this->blog(['#' . $tag, strtolower($tag), 'SEO ' . $this->u]);

        $this->get(route('blogs.read', $blog->slug))->assertOk()
            ->assertSee('href="' . route('blogs.tag', BlogTags::slug($tag)) . '" rel="tag"', false)
            ->assertSee('#' . $tag)
            ->assertSee('<meta name="keywords" content="' . e($tag . ', SEO ' . $this->u) . '" />', false);
    }

    public function test_related_articles_prefer_shared_tags_over_category(): void
    {
        $tag = $this->tag('Chatbot');
        $otherCategory = BlogCategory::create(['name' => 'Lain ' . $this->u, 'slug' => 'lain-' . $this->u, 'display_order' => 2, 'is_active' => true]);

        $main = $this->blog([$tag, $this->tag('AI')]);
        $sharesTwo = $this->blog([$tag, $this->tag('AI')], ['category_id' => $otherCategory->id, 'published_at' => now()->subDays(9)]);
        $sharesOne = $this->blog([$tag], ['category_id' => $otherCategory->id, 'published_at' => now()->subDays(8)]);
        $sameCategoryOnly = $this->blog(['Tanpa Hubungan ' . $this->u], ['published_at' => now()->subMinute()]);

        $related = $this->get(route('blogs.read', $main->slug))->assertOk()->viewData('related');

        $this->assertSame([$sharesTwo->id, $sharesOne->id], $related->take(2)->pluck('id')->all());
        $this->assertContains($sameCategoryOnly->id, $related->pluck('id')->all(), 'sisa slot diisi dari kategori yang sama');
        $this->assertNotContains($main->id, $related->pluck('id')->all());
    }

    public function test_blog_index_shows_popular_topics_linking_to_tag_pages(): void
    {
        $tag = $this->tag('Populer');
        $this->blog([$tag]);
        $this->blog([$tag]);

        $this->get(route('landing.blogs'))->assertOk()
            ->assertSee('Topik Populer')
            ->assertSee('href="' . route('blogs.tag', BlogTags::slug($tag)) . '"', false);
    }

    public function test_tag_index_cache_refreshes_when_articles_change(): void
    {
        $tag = $this->tag('Segar');
        $this->blog([$tag]);
        $this->assertSame(1, BlogTags::find(BlogTags::slug($tag))['count']);

        $second = $this->blog([$tag]);
        $this->assertSame(2, BlogTags::find(BlogTags::slug($tag))['count']);

        $second->delete();
        $this->assertSame(1, BlogTags::find(BlogTags::slug($tag))['count']);
    }
}
