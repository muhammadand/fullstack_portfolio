<?php

namespace Tests\Feature;

use App\Models\Documentation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminDocumentationTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first() ?? User::create([
            'name' => 'Admin Doc Test',
            'email' => 'admin_doc_' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }

    public function test_documentation_index_renders_properly(): void
    {
        Documentation::create([
            'title' => 'Test Kegiatan Satu',
            'slug' => 'test-kegiatan-satu-' . uniqid(),
            'images' => null,
        ]);

        $response = $this->actingAs($this->admin)->get(route('documentation.index'));
        $response->assertOk();
        $response->assertSee('Daftar Dokumentasi');
        $response->assertSee('Test Kegiatan Satu');
    }

    public function test_documentation_index_search_filters_results(): void
    {
        Documentation::create(['title' => 'Workshop SEO Scalify', 'slug' => 'workshop-seo-' . uniqid()]);
        Documentation::create(['title' => 'Gathering Internal', 'slug' => 'gathering-internal-' . uniqid()]);

        $response = $this->actingAs($this->admin)->get(route('documentation.index', ['q' => 'SEO']));
        $response->assertOk();
        $response->assertSee('Workshop SEO Scalify');
        $response->assertDontSee('Gathering Internal');
    }

    public function test_documentation_create_page_renders(): void
    {
        $response = $this->actingAs($this->admin)->get(route('documentation.create'));
        $response->assertOk();
        $response->assertSee('Tambah Foto Dokumentasi');
    }

    public function test_documentation_store_creates_record_and_file(): void
    {
        $file = UploadedFile::fake()->image('doc.jpg', 600, 400);

        $response = $this->actingAs($this->admin)->post(route('documentation.store'), [
            'title' => 'Dokumentasi Baru ' . uniqid(),
            'images' => $file,
        ]);

        $response->assertRedirect(route('documentation.index'));
        $response->assertSessionHas('success');

        $doc = Documentation::where('title', 'like', 'Dokumentasi Baru%')->latest('id')->first();
        $this->assertNotNull($doc);
        $this->assertNotNull($doc->images);

        // cleanup file
        if ($doc->images && File::exists(public_path('images/' . $doc->images))) {
            @unlink(public_path('images/' . $doc->images));
        }
    }

    public function test_documentation_edit_page_renders(): void
    {
        $doc = Documentation::create([
            'title' => 'Dokumentasi Edit',
            'slug' => 'dokumentasi-edit-' . uniqid(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('documentation.edit', $doc->slug));
        $response->assertOk();
        $response->assertSee('Edit Foto Dokumentasi');
        $response->assertSee('Dokumentasi Edit');
    }

    public function test_documentation_update_without_replacing_image_preserves_image(): void
    {
        $doc = Documentation::create([
            'title' => 'Dokumentasi Awal',
            'slug' => 'doc-awal-' . uniqid(),
            'images' => 'existing_dummy_image.jpg',
        ]);

        $response = $this->actingAs($this->admin)->put(route('documentation.update', $doc->slug), [
            'title' => 'Dokumentasi Terupdate',
        ]);

        $response->assertRedirect(route('documentation.index'));
        $doc->refresh();
        $this->assertEquals('Dokumentasi Terupdate', $doc->title);
        $this->assertEquals('existing_dummy_image.jpg', $doc->images);
    }

    public function test_documentation_destroy_deletes_record(): void
    {
        $doc = Documentation::create([
            'title' => 'Hapus Saya',
            'slug' => 'hapus-saya-' . uniqid(),
        ]);

        $response = $this->actingAs($this->admin)->delete(route('documentation.destroy', $doc->slug));
        $response->assertRedirect(route('documentation.index'));
        $this->assertDatabaseMissing('documentations', ['id' => $doc->id]);
    }
}

