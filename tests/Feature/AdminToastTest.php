<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminToastTest extends TestCase
{
    use DatabaseTransactions;

    protected function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => 'adm_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => 'admin']);
    }

    public function test_flash_messages_render_as_standard_toast_once(): void
    {
        $res = $this->actingAs($this->admin())
            ->withSession(['success' => 'Data tersimpan <b>aman</b>', 'error' => 'Ada yang gagal'])
            ->get(route('admin.orders.index'))
            ->assertOk()
            ->assertSee('sweetalert2.all.min.js', false)
            ->assertSee('window.toast = function', false);

        $html = $res->getContent();
        // Pesan dikirim sebagai data JSON (di-escape), bukan HTML mentah, dan hanya sekali.
        $this->assertStringNotContainsString('Data tersimpan <b>aman</b>', $html);
        $this->assertSame(1, substr_count($html, 'Data tersimpan'));
        $this->assertStringContainsString('Ada yang gagal', $html);
    }

    public function test_no_flash_means_no_toast_queue(): void
    {
        $this->actingAs($this->admin())->get(route('admin.orders.index'))
            ->assertOk()->assertDontSee('Flash dari redirect', false);
    }
}
