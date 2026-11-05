<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomerAuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_sees_register_cta_on_topup_page(): void
    {
        $this->get(route('topup.index'))
            ->assertOk()
            ->assertSee(route('customer.register'), false)
            ->assertSee(route('customer.login'), false)
            ->assertSee('Daftar, dapat reward!');
    }

    public function test_register_creates_customer_and_logs_in_with_customer_guard(): void
    {
        $email = 'reg_' . uniqid() . '@example.com';

        $this->post(route('customer.register.post'), [
            'name' => 'Budi Gamers', 'email' => $email, 'password' => 'secret123',
        ])->assertRedirect(route('topup.index'));

        $this->assertDatabaseHas('customers', ['email' => $email, 'name' => 'Budi Gamers', 'points' => 50]);
        $this->assertAuthenticatedAs(Customer::where('email', $email)->first(), 'customer');
        $this->assertGuest('web');
    }

    public function test_login_and_logout(): void
    {
        $c = Customer::create(['name' => 'Siti', 'email' => 'login_' . uniqid() . '@example.com', 'password' => 'secret123']);

        $this->post(route('customer.login.post'), ['email' => $c->email, 'password' => 'salah'])
            ->assertSessionHasErrors('email');

        $this->post(route('customer.login.post'), ['email' => $c->email, 'password' => 'secret123'])
            ->assertRedirect(route('topup.index'));
        $this->assertAuthenticatedAs($c, 'customer');

        $this->get(route('topup.index'))->assertSee('Halo, Siti');

        $this->post(route('customer.logout'))->assertRedirect(route('topup.index'));
        $this->assertGuest('customer');
    }

    public function test_account_page_requires_login_and_lists_own_orders(): void
    {
        $this->get(route('customer.account'))->assertRedirect();

        $c = Customer::create(['name' => 'Rina', 'email' => 'acc_' . uniqid() . '@example.com', 'password' => 'secret123', 'points' => 120]);

        $this->actingAs($c, 'customer')->get(route('customer.account'))
            ->assertOk()->assertSee('Rina')->assertSee('Belum ada pesanan');
    }
}
