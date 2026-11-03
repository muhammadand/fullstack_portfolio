<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminReviewCardModernizationTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::first() ?? User::create([
            'name' => 'Admin RC Test',
            'email' => 'admin_rc_' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }

    public function test_review_cards_index_renders_properly(): void
    {
        $serial = 'SCL-' . strtoupper(Str::random(6));
        $slug = Str::lower(Str::random(6));

        DB::table('review_cards')->insert([
            'serial_number' => $serial,
            'slug' => $slug,
            'activation_code' => '123456',
            'business_name' => 'Kafe Kopi Koma Bandung',
            'status' => 'active',
            'is_sold' => false,
            'total_scans' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.review_cards.index'));
        $response->assertOk();
        $response->assertSee('Google Review Cards');
        $response->assertSee('Total Kartu');
        $response->assertSee($serial);
        $response->assertSee('Kafe Kopi Koma Bandung');
    }

    public function test_review_cards_index_search_and_status_filter(): void
    {
        $serial1 = 'SCL-ALPHA-' . rand(100, 999);
        $serial2 = 'SCL-BETA-' . rand(100, 999);

        DB::table('review_cards')->insert([
            'serial_number' => $serial1,
            'slug' => 'slug-alpha-' . uniqid(),
            'activation_code' => '111222',
            'business_name' => 'Alpha Business Test',
            'status' => 'active',
            'is_sold' => false,
            'total_scans' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('review_cards')->insert([
            'serial_number' => $serial2,
            'slug' => 'slug-beta-' . uniqid(),
            'activation_code' => '333444',
            'business_name' => 'Beta Business Test',
            'status' => 'pending',
            'is_sold' => true,
            'total_scans' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Search by query q
        $resQ = $this->actingAs($this->admin)->get(route('admin.review_cards.index', ['q' => 'ALPHA']));
        $resQ->assertOk();
        $resQ->assertSee($serial1);
        $resQ->assertDontSee($serial2);

        // Filter by sold status
        $resSold = $this->actingAs($this->admin)->get(route('admin.review_cards.index', ['status' => 'sold']));
        $resSold->assertOk();
        $resSold->assertSee($serial2);
        $resSold->assertDontSee($serial1);
    }

    public function test_review_cards_create_page_renders(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.review_cards.create'));
        $response->assertOk();
        $response->assertSee('Tambah Review Card Baru');
    }

    public function test_review_cards_store_creates_record(): void
    {
        $serial = 'SCL-' . strtoupper(Str::random(6));
        $slug = 'slug' . rand(1000, 9999);

        $response = $this->actingAs($this->admin)->post(route('admin.review_cards.store'), [
            'serial_number' => $serial,
            'slug' => $slug,
            'activation_code' => '987654',
            'status' => 'active',
            'business_name' => 'Resto Baru Enak',
            'google_review_url' => 'https://maps.app.goo.gl/example',
        ]);

        $response->assertRedirect(route('admin.review_cards.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('review_cards', [
            'serial_number' => $serial,
            'business_name' => 'Resto Baru Enak',
        ]);
    }

    public function test_review_cards_batch_generate(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.review_cards.batch_generate'), [
            'quantity' => 3,
            'prefix' => 'TESTBATCH',
            'notes' => 'Batch uji coba otomatis',
        ]);

        $response->assertRedirect(route('admin.review_cards.index'));
        $response->assertSessionHas('success');

        $count = DB::table('review_cards')->where('notes', 'Batch uji coba otomatis')->count();
        $this->assertEquals(3, $count);
    }

    public function test_review_cards_edit_page_renders(): void
    {
        $id = DB::table('review_cards')->insertGetId([
            'serial_number' => 'SCL-EDIT-' . rand(100, 999),
            'slug' => 'slug-edit-' . uniqid(),
            'activation_code' => '654321',
            'status' => 'pending',
            'is_sold' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.review_cards.edit', $id));
        $response->assertOk();
        $response->assertSee('Edit Review Card');
    }

    public function test_review_cards_update_saves_changes(): void
    {
        $id = DB::table('review_cards')->insertGetId([
            'serial_number' => 'SCL-UPD-' . rand(100, 999),
            'slug' => 'slug-upd-' . uniqid(),
            'activation_code' => '112233',
            'status' => 'pending',
            'is_sold' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.review_cards.update', $id), [
            'status' => 'active',
            'business_name' => 'Kedai Kopi Mantap',
            'google_review_url' => 'https://maps.app.goo.gl/kedai',
        ]);

        $response->assertRedirect(route('admin.review_cards.index'));
        $card = DB::table('review_cards')->where('id', $id)->first();
        $this->assertEquals('Kedai Kopi Mantap', $card->business_name);
        $this->assertEquals('active', $card->status);
    }

    public function test_review_cards_analytics_page_renders(): void
    {
        // Insert sample visit
        DB::table('google_card_visits')->insert([
            'visited_at' => now()->toDateString(),
            'source_type' => 'social',
            'source_name' => 'Threads',
            'device_type' => 'mobile',
            'referer' => 'https://www.threads.net',
            'utm_source' => 'threads',
            'ip_address' => '127.0.0.1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.review_cards.analytics'));
        $response->assertOk();
        $response->assertSee('Analitik Google Review Cards');
        $response->assertSee('Total Kunjungan');
        $response->assertSee('Generator Link Tracking Otomatis');
        $response->assertSee('Semua Aktivitas Kunjungan');
        $response->assertSee('Threads');
    }
}

