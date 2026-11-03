<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPortfolioTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;
    protected PortfolioCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->admin = User::first() ?? User::create([
            'name' => 'Admin Portfolio Test',
            'email' => 'admin_port_' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $this->category = PortfolioCategory::create([
            'name' => 'Kategori Test ' . uniqid(),
            'slug' => 'kategori-test-' . uniqid(),
            'display_order' => 1,
            'is_active' => true,
        ]);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Website Toko Test',
            'slug' => '',
            'category_id' => $this->category->id,
            'short_description' => 'Ringkasan proyek test.',
            'full_description' => '<p>Deskripsi lengkap.</p>',
            'technologies' => 'Laravel,  Vue.js , MySQL',
            'completion_date' => '2026-05-20',
            'is_active' => '1',
            'is_featured' => '0',
            'thumbnail_image' => UploadedFile::fake()->image('thumb.jpg'),
        ], $overrides);
    }

    private function makePortfolio(array $attributes = []): Portfolio
    {
        return Portfolio::create(array_merge([
            'category_id' => $this->category->id,
            'title' => 'Portfolio Lama',
            'slug' => 'portfolio-lama-' . uniqid(),
            'thumbnail_image' => 'uploads/portfolio/lama.jpg',
            'short_description' => 'Ringkasan lama',
            'full_description' => '<p>Lama</p>',
            'technologies' => ['PHP'],
            'completion_date' => '2026-01-15',
            'is_active' => true,
            'is_featured' => true,
        ], $attributes));
    }

    public function test_all_portfolio_pages_render(): void
    {
        $item = $this->makePortfolio();
        $this->actingAs($this->admin);

        $this->get(route('portfolio.index'))->assertOk()->assertSee('Daftar Portfolio')->assertSee('Portfolio Lama');
        $this->get(route('portfolio.create'))->assertOk()->assertSee('Tambah Portfolio');
        $this->get(route('portfolio.edit', $item))
            ->assertOk()
            ->assertSee('Simpan Perubahan')
            ->assertSee('value="2026-01-15"', false)
            ->assertSee('value="PHP"', false);
    }

    public function test_index_filters_by_search_and_status(): void
    {
        $this->makePortfolio(['title' => 'Proyek Zebra Unik']);
        $this->makePortfolio(['title' => 'Proyek Lain Sekali', 'is_active' => false]);

        $this->actingAs($this->admin)
            ->get(route('portfolio.index', ['search' => 'Zebra']))
            ->assertOk()->assertSee('Proyek Zebra Unik')->assertDontSee('Proyek Lain Sekali');

        $this->actingAs($this->admin)
            ->get(route('portfolio.index', ['is_active' => '0']))
            ->assertOk()->assertSee('Proyek Lain Sekali')->assertDontSee('Proyek Zebra Unik');
    }

    public function test_store_generates_slug_and_splits_technologies(): void
    {
        $this->actingAs($this->admin)
            ->post(route('portfolio.store'), $this->payload())
            ->assertRedirect(route('portfolio.index'));

        $item = Portfolio::where('title', 'Website Toko Test')->latest('id')->first();
        $this->assertSame('website-toko-test', $item->slug);
        $this->assertSame(['Laravel', 'Vue.js', 'MySQL'], $item->technologies);
        $this->assertTrue($item->is_active);
        $this->assertFalse($item->is_featured);
        Storage::disk('public')->assertExists($item->thumbnail_image);
    }

    public function test_store_makes_duplicate_slug_unique(): void
    {
        $this->makePortfolio(['slug' => 'website-toko-test']);

        $this->actingAs($this->admin)->post(route('portfolio.store'), $this->payload());

        $this->assertSame('website-toko-test-2', Portfolio::where('title', 'Website Toko Test')->latest('id')->first()->slug);
    }

    public function test_store_requires_thumbnail(): void
    {
        $this->actingAs($this->admin)
            ->post(route('portfolio.store'), $this->payload(['thumbnail_image' => null]))
            ->assertSessionHasErrors('thumbnail_image');
    }

    public function test_update_can_deactivate_and_keeps_existing_thumbnail(): void
    {
        $path = UploadedFile::fake()->image('lama.jpg')->store('uploads/portfolio', 'public');
        $item = $this->makePortfolio(['thumbnail_image' => $path]);

        $this->actingAs($this->admin)
            ->put(route('portfolio.update', $item), $this->payload(['thumbnail_image' => null, 'is_active' => '0', 'is_featured' => '0', 'slug' => $item->slug]))
            ->assertRedirect(route('portfolio.index'));

        $item->refresh();
        $this->assertFalse($item->is_active);
        $this->assertFalse($item->is_featured);
        $this->assertSame($path, $item->thumbnail_image);
    }

    public function test_update_replaces_thumbnail_and_removes_featured_image(): void
    {
        $thumb = UploadedFile::fake()->image('t.jpg')->store('uploads/portfolio', 'public');
        $featured = UploadedFile::fake()->image('f.jpg')->store('uploads/portfolio', 'public');
        $item = $this->makePortfolio(['thumbnail_image' => $thumb, 'featured_image' => $featured]);

        $this->actingAs($this->admin)->put(route('portfolio.update', $item), $this->payload([
            'slug' => $item->slug,
            'remove_featured_image' => '1',
            'thumbnail_image' => UploadedFile::fake()->image('baru.jpg'),
        ]));

        $item->refresh();
        $this->assertNull($item->featured_image);
        Storage::disk('public')->assertMissing($featured);
        Storage::disk('public')->assertMissing($thumb);
        Storage::disk('public')->assertExists($item->thumbnail_image);
    }

    public function test_destroy_deletes_images(): void
    {
        $thumb = UploadedFile::fake()->image('t.jpg')->store('uploads/portfolio', 'public');
        $item = $this->makePortfolio(['thumbnail_image' => $thumb]);

        $this->actingAs($this->admin)->delete(route('portfolio.destroy', $item))->assertRedirect(route('portfolio.index'));

        $this->assertDatabaseMissing('portfolios', ['id' => $item->id]);
        Storage::disk('public')->assertMissing($thumb);
    }
}
