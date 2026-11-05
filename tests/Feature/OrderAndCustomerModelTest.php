<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\DigitalProduct;
use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class OrderAndCustomerModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_customer_model_handles_email_password_and_orders(): void
    {
        $customer = Customer::create([
            'name'     => 'Budi Gamers',
            'email'    => 'budi_' . uniqid() . '@example.com',
            'password' => 'secret123',
            'phone'    => '081234567890',
            'points'   => 150,
        ]);

        $this->assertNotNull($customer->id);
        $this->assertTrue(Hash::check('secret123', $customer->password));
        $this->assertEquals(150, $customer->points);
        $this->assertArrayNotHasKey('password', $customer->toArray());
    }

    public function test_order_can_be_created_with_relations_and_casts(): void
    {
        $customer = Customer::create([
            'name'     => 'Siti Topup',
            'email'    => 'siti_' . uniqid() . '@example.com',
            'password' => 'password123',
            'phone'    => '08987654321',
        ]);

        $product = DigitalProduct::create([
            'name'        => '86 Diamonds Mobile Legends Test',
            'slug'        => 'ml-86-dm-' . uniqid(),
            'sku_code'    => 'ML86-' . uniqid(),
            'provider'    => 'digiflazz',
            'cost_price'  => 19000,
            'price'       => 21000,
            'is_active'   => true,
        ]);

        $order = Order::create([
            'order_no'           => 'ORD-' . strtoupper(Str::random(10)),
            'customer_id'        => $customer->id,
            'digital_product_id' => $product->id,
            'customer_no'        => '123456789',
            'account_data'       => ['user_id' => '123456789', 'zone_id' => '1234'],
            'product_name'       => $product->name,
            'sku_code'           => $product->sku_code,
            'cost_price'         => 19000,
            'price'              => 21000,
            'admin_fee'          => 1000,
            'total_amount'       => 22000,
            'status'             => Order::STATUS_PENDING,
            'payment_status'     => Order::PAYMENT_UNPAID,
            'notes'              => 'Tolong cepat ya min',
        ]);

        $this->assertDatabaseHas('orders', [
            'id'          => $order->id,
            'order_no'    => $order->order_no,
            'customer_no' => '123456789',
            'status'      => 'pending',
        ]);

        // Test relationship
        $this->assertEquals($customer->id, $order->customer->id);
        $this->assertEquals($product->id, $order->digitalProduct->id);
        $this->assertTrue($customer->orders->contains($order));
        $this->assertTrue($product->orders->contains($order));

        // Test helper methods
        $this->assertFalse($order->isPaid());
        $this->assertFalse($order->isSuccess());

        $order->update([
            'status'         => Order::STATUS_SUCCESS,
            'payment_status' => Order::PAYMENT_PAID,
            'sn'             => 'SN-DIGI-998877',
            'paid_at'        => now(),
            'completed_at'   => now(),
        ]);

        $this->assertTrue($order->fresh()->isPaid());
        $this->assertTrue($order->fresh()->isSuccess());
        $this->assertEquals('SN-DIGI-998877', $order->fresh()->sn);
        $this->assertEquals('1234', $order->fresh()->account_data['zone_id']);
    }

    public function test_guest_order_can_be_created_without_customer_id(): void
    {
        $product = DigitalProduct::create([
            'name'        => 'Free Fire 140 Diamonds Test',
            'slug'        => 'ff-140-' . uniqid(),
            'sku_code'    => 'FF140-' . uniqid(),
            'provider'    => 'digiflazz',
            'cost_price'  => 18000,
            'price'       => 20000,
            'is_active'   => true,
        ]);

        $order = Order::create([
            'order_no'           => 'ORD-' . strtoupper(Str::random(10)),
            'customer_id'        => null,
            'digital_product_id' => $product->id,
            'customer_no'        => '987654321',
            'product_name'       => $product->name,
            'sku_code'           => $product->sku_code,
            'cost_price'         => 18000,
            'price'              => 20000,
            'total_amount'       => 20000,
            'status'             => Order::STATUS_PENDING,
            'payment_status'     => Order::PAYMENT_UNPAID,
        ]);

        $this->assertNull($order->customer_id);
        $this->assertNull($order->customer);
        $this->assertEquals('987654321', $order->customer_no);
    }
}

