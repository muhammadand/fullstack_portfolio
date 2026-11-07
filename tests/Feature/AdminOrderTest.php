<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\DigitalProduct;
use App\Models\DigitalProductBrand;
use App\Models\DigitalProductCategory;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminOrderTest extends TestCase
{
    use DatabaseTransactions;

    protected function order(array $over = []): Order
    {
        $cat = DigitalProductCategory::firstOrCreate(['slug' => 'games'], ['name' => 'Games']);
        $brand = DigitalProductBrand::create(['digital_product_category_id' => $cat->id, 'name' => 'Brand ' . uniqid(), 'slug' => 'b-' . uniqid()]);
        $sku = 'ao-' . uniqid();
        $product = DigitalProduct::create(['provider' => 'digiflazz', 'sku_code' => $sku, 'slug' => $sku, 'name' => '86 Diamond',
            'digital_product_brand_id' => $brand->id, 'cost_price' => 10000, 'is_active' => true]);

        return Order::create($over + [
            'order_no' => Order::generateOrderNo(), 'digital_product_id' => $product->id, 'customer_no' => '12345678',
            'email' => 'buyer@example.com', 'account_data' => ['user_id' => '1234', 'zone_id' => '99'],
            'product_name' => '86 Diamond', 'sku_code' => $sku, 'cost_price' => 10000, 'price' => 11000, 'total_amount' => 11000,
        ]);
    }

    protected function admin(): User
    {
        return User::create(['name' => 'Admin Test', 'email' => 'adm_' . uniqid() . '@example.com', 'password' => 'secret123', 'role' => 'admin']);
    }

    public function test_admin_pages_require_login(): void
    {
        $o = $this->order();
        $this->get(route('admin.orders.index'))->assertRedirect();
        $this->get(route('admin.orders.show', $o))->assertRedirect();
    }

    public function test_index_lists_filters_and_searches_orders(): void
    {
        $paid = $this->order(['payment_status' => 'paid', 'status' => 'processing', 'product_name' => 'Paket Paid XYZ']);
        $unpaid = $this->order(['product_name' => 'Paket Unpaid QQQ']);

        $admin = $this->admin();

        $this->actingAs($admin)->get(route('admin.orders.index'))
            ->assertOk()->assertSee($paid->order_no)->assertSee($unpaid->order_no)->assertSee('Order Produk Digital');

        $this->actingAs($admin)->get(route('admin.orders.index', ['payment_status' => 'paid', 'search' => 'XYZ']))
            ->assertOk()->assertSee($paid->order_no)->assertDontSee($unpaid->order_no);
    }

    public function test_show_displays_details_status_and_customer(): void
    {
        $c = Customer::create(['name' => 'Siti Gamers', 'email' => 's_' . uniqid() . '@example.com', 'password' => 'secret123']);
        $o = $this->order(['customer_id' => $c->id, 'payment_status' => 'paid', 'status' => 'processing', 'paid_at' => now()]);

        $this->actingAs($this->admin())->get(route('admin.orders.show', $o))
            ->assertOk()->assertSee($o->order_no)->assertSee('Diproses')->assertSee('Lunas')
            ->assertSee('Siti Gamers')->assertSee('buyer@example.com')->assertSee('Zone Id')->assertSee('99');
    }

    public function test_index_numbers_rows_and_selects_only_ui_columns(): void
    {
        $this->order();
        $this->order();

        \Illuminate\Support\Facades\DB::enableQueryLog();
        $res = $this->actingAs($this->admin())->get(route('admin.orders.index'))->assertOk();
        $queries = collect(\Illuminate\Support\Facades\DB::getQueryLog())->pluck('query');

        $list = $queries->first(fn ($q) => str_contains($q, 'from `orders`') && str_contains($q, '`order_no`') && ! str_contains($q, 'count(*)'));
        $this->assertNotNull($list);
        $this->assertStringNotContainsString('select *', $list);
        $this->assertStringNotContainsString('account_data', $list);
        $this->assertStringNotContainsString('qris_image_url', $list);

        $customerQ = $queries->first(fn ($q) => str_contains($q, 'from `customers`'));
        if ($customerQ) {
            $this->assertStringNotContainsString('select *', $customerQ);
        }

        $res->assertSee('>#<', false)->assertSee('>1</td>', false)->assertSee('>2</td>', false);
    }

    public function test_tabs_filter_orders_by_source(): void
    {
        $game = $this->order(['product_name' => 'Diamond Game ABC']);
        $pulsa = $this->order([
            'order_no' => Order::generateOrderNo(Order::prefixFor(Order::SOURCE_PULSA)),
            'source' => Order::SOURCE_PULSA, 'product_name' => 'Pulsa Telkomsel 10.000',
        ]);
        $admin = $this->admin();

        $this->actingAs($admin)->get(route('admin.orders.index', ['source' => 'pulsa']))
            ->assertOk()->assertSee($pulsa->order_no)->assertDontSee($game->order_no)
            ->assertSee('aria-current="page"', false)->assertSee('Top Up Game')->assertSee('Paket Data');

        $this->actingAs($admin)->get(route('admin.orders.index', ['source' => 'topup_game']))
            ->assertOk()->assertSee($game->order_no)->assertDontSee($pulsa->order_no);

        // Source tak dikenal = tab "Semua".
        $this->actingAs($admin)->get(route('admin.orders.index', ['source' => 'ngawur']))
            ->assertOk()->assertSee($game->order_no)->assertSee($pulsa->order_no);
    }

    public function test_old_topup_orders_urls_redirect(): void
    {
        $o = $this->order();

        $this->get('/admin/topup-orders')->assertRedirect('/admin/orders?source=topup_game');
        $this->get("/admin/topup-orders/{$o->id}")->assertRedirect(route('admin.orders.show', $o));
    }
}
