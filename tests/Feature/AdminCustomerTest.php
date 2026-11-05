<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminCustomerTest extends TestCase
{
    use DatabaseTransactions;

    protected function admin(): User
    {
        return User::create(['name' => 'Admin Test', 'email' => 'adm_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => 'admin']);
    }

    public function test_pages_require_login(): void
    {
        $c = Customer::create(['name' => 'Budi']);
        $this->get(route('admin.customers.index'))->assertRedirect();
        $this->get(route('admin.customers.show', $c->id))->assertRedirect();
    }

    public function test_index_lists_numbers_filters_by_source_and_never_loads_password(): void
    {
        $tag = uniqid();
        $topup = Customer::create(['name' => "Topup $tag", 'email' => "a_$tag@example.com", 'password' => 'secret123', 'source' => Customer::SOURCE_TOPUP]);
        $travel = Customer::create(['name' => "Travel $tag", 'phone' => '0812' . random_int(1000000, 9999999)]); // default source
        $google = Customer::create(['name' => "Google $tag", 'source' => Customer::SOURCE_GOOGLE_CARD]);
        $admin = $this->admin();

        $this->assertSame('travel', $travel->fresh()->source);

        DB::enableQueryLog();
        $this->actingAs($admin)->get(route('admin.customers.index', ['q' => $tag]))
            ->assertOk()->assertSee("Topup $tag")->assertSee("Travel $tag")->assertSee("Google $tag")->assertSee('>1</td>', false);
        $list = collect(DB::getQueryLog())->pluck('query')->first(fn ($q) => str_contains($q, 'has_account'));
        $this->assertNotNull($list);
        $this->assertStringNotContainsString('select *', $list);
        $this->assertStringNotContainsString('`remember_token`', $list);

        foreach (['topup' => "Topup $tag", 'travel' => "Travel $tag", 'google_card' => "Google $tag"] as $src => $name) {
            $others = array_diff(["Topup $tag", "Travel $tag", "Google $tag"], [$name]);
            $res = $this->actingAs($admin)->get(route('admin.customers.index', ['q' => $tag, 'source' => $src]))->assertSee($name);
            foreach ($others as $o) {
                $res->assertDontSee($o);
            }
        }
    }

    public function test_register_via_topup_sets_source_topup(): void
    {
        $email = 'src_' . uniqid() . '@example.com';
        $this->post(route('customer.register.post'), ['name' => 'Budi', 'email' => $email, 'password' => 'secret123']);

        $this->assertSame('topup', Customer::where('email', $email)->value('source'));
    }

    public function test_show_displays_profile_and_orders_summary(): void
    {
        $c = Customer::create(['name' => 'Siti Detail', 'email' => 's_' . uniqid() . '@example.com', 'password' => 'secret123', 'points' => 120]);

        $this->actingAs($this->admin())->get(route('admin.customers.show', $c->id))
            ->assertOk()->assertSee('Siti Detail')->assertSee('120')->assertSee('Belum ada order top up');
    }
}
