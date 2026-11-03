<?php

namespace Tests\Feature;

use App\Models\DigitalProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDigitalProductModernizationTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->admin = User::first() ?? User::create([
            'name' => 'Admin Digipro Test',
            'email' => 'admin_digipro_' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }

    public function test_digital_products_index_renders_properly(): void
    {
        $product = DigitalProduct::create([
            'name' => 'Source Code Marketplace Scalify',
            'slug' => 'sc-marketplace-' . uniqid(),
            'lynk_slug' => 'lynk' . rand(100, 999),
            'category' => 'Source Code',
            'price' => 150000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.digital_products.index'));
        $response->assertOk();
        $response->assertSee('Produk Digital (Lynk.id)');
        $response->assertSee('Source Code Marketplace Scalify');
        $response->assertSee($product->lynk_slug);
    }

    public function test_digital_products_index_search_and_category_filter(): void
    {
        DigitalProduct::create([
            'name' => 'Alpha Laravel Project',
            'slug' => 'alpha-project-' . uniqid(),
            'lynk_slug' => 'alpha' . rand(100, 999),
            'category' => 'Source Code',
            'price' => 100000,
            'is_active' => true,
        ]);

        DigitalProduct::create([
            'name' => 'Beta Trading Script',
            'slug' => 'beta-script-' . uniqid(),
            'lynk_slug' => 'beta' . rand(100, 999),
            'category' => 'Trading & Finansial',
            'price' => 200000,
            'is_active' => true,
        ]);

        // Search by query q
        $resQ = $this->actingAs($this->admin)->get(route('admin.digital_products.index', ['q' => 'Alpha']));
        $resQ->assertOk();
        $resQ->assertSee('Alpha Laravel Project');
        $resQ->assertDontSee('Beta Trading Script');

        // Filter by category
        $resCat = $this->actingAs($this->admin)->get(route('admin.digital_products.index', ['category' => 'Trading & Finansial']));
        $resCat->assertOk();
        $resCat->assertSee('Beta Trading Script');
        $resCat->assertDontSee('Alpha Laravel Project');
    }

    public function test_digital_products_create_page_renders(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.digital_products.create'));
        $response->assertOk();
        $response->assertSee('Tambah Produk Digital');
    }

    public function test_digital_products_store_creates_record_and_file(): void
    {
        $file = UploadedFile::fake()->image('thumbnail.jpg', 600, 400);

        $response = $this->actingAs($this->admin)->post(route('admin.digital_products.store'), [
            'name' => 'E-Book Mahir Laravel 12',
            'lynk_slug' => 'ebook123' . rand(100, 999),
            'category' => 'E-Book & Panduan',
            'price' => 99000,
            'is_active' => '1',
            'display_order' => 1,
            'thumbnail' => $file,
            'short_description' => 'Panduan praktis lengkap',
            'description' => 'Materi detail dan studi kasus',
        ]);

        $response->assertRedirect(route('admin.digital_products.index'));
        $response->assertSessionHas('success');

        $product = DigitalProduct::where('name', 'E-Book Mahir Laravel 12')->first();
        $this->assertNotNull($product);
        $this->assertNotNull($product->slug);
        $this->assertNotNull($product->thumbnail);
        Storage::disk('public')->assertExists($product->thumbnail);
    }

    public function test_digital_products_edit_page_renders(): void
    {
        $product = DigitalProduct::create([
            'name' => 'Produk Edit Test',
            'slug' => 'produk-edit-test-' . uniqid(),
            'lynk_slug' => 'edit123',
            'category' => 'Template Website',
            'price' => 120000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.digital_products.edit', $product->id));
        $response->assertOk();
        $response->assertSee('Edit Produk Digital');
        $response->assertSee('Produk Edit Test');
    }

    public function test_digital_products_update_preserves_thumbnail_if_not_replaced(): void
    {
        $product = DigitalProduct::create([
            'name' => 'Original Product Name',
            'slug' => 'orig-prod-' . uniqid(),
            'lynk_slug' => 'orig123',
            'category' => 'Source Code',
            'price' => 75000,
            'thumbnail' => 'digital_products/existing_thumb.jpg',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.digital_products.update', $product->id), [
            'name' => 'Updated Product Name',
            'slug' => $product->slug,
            'lynk_slug' => 'orig123',
            'category' => 'Source Code',
            'price' => 85000,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.digital_products.index'));
        $product->refresh();
        $this->assertEquals('Updated Product Name', $product->name);
        $this->assertEquals('digital_products/existing_thumb.jpg', $product->thumbnail);
    }

    public function test_digital_products_update_removes_thumbnail_when_requested(): void
    {
        $file = UploadedFile::fake()->image('old_thumb.jpg');
        $path = $file->store('digital_products', 'public');

        $product = DigitalProduct::create([
            'name' => 'Product With Thumb',
            'slug' => 'prod-thumb-' . uniqid(),
            'lynk_slug' => 'thumb123',
            'price' => 50000,
            'thumbnail' => $path,
            'is_active' => true,
        ]);

        Storage::disk('public')->assertExists($path);

        $response = $this->actingAs($this->admin)->put(route('admin.digital_products.update', $product->id), [
            'name' => 'Product With Thumb',
            'slug' => $product->slug,
            'lynk_slug' => 'thumb123',
            'price' => 50000,
            'is_active' => '1',
            'remove_thumbnail' => '1',
        ]);

        $response->assertRedirect(route('admin.digital_products.index'));
        $product->refresh();
        $this->assertNull($product->thumbnail);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_digital_products_destroy_deletes_record_and_file(): void
    {
        $file = UploadedFile::fake()->image('todelete.jpg');
        $path = $file->store('digital_products', 'public');

        $product = DigitalProduct::create([
            'name' => 'Delete Me Product',
            'slug' => 'delete-me-' . uniqid(),
            'lynk_slug' => 'del123',
            'price' => 50000,
            'thumbnail' => $path,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.digital_products.destroy', $product->id));
        $response->assertRedirect(route('admin.digital_products.index'));
        $this->assertDatabaseMissing('digital_products', ['id' => $product->id]);
        Storage::disk('public')->assertMissing($path);
    }
}

