<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\GoogleCardOrder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CustomerSourceTest extends TestCase
{
    use DatabaseTransactions;

    protected function phone(): string
    {
        return '0812' . random_int(10000000, 99999999);
    }

    public function test_phone_variants_cover_08_62_and_bare_formats(): void
    {
        $this->assertEqualsCanonicalizing(['081234567890', '6281234567890'], Customer::phoneVariants('0812-3456-7890'));
        $this->assertEqualsCanonicalizing(['6281234567890', '081234567890'], Customer::phoneVariants('+62 812 3456 7890'));
        $this->assertSame([], Customer::phoneVariants('abc'));
    }

    public function test_same_phone_in_different_sources_stays_separate(): void
    {
        $phone = $this->phone();
        $topup = Customer::create(['name' => 'Budi Topup', 'email' => 'x_' . uniqid() . '@example.com', 'password' => 'secret123', 'phone' => $phone, 'source' => Customer::SOURCE_TOPUP]);

        // Travel dengan no. HP yang sama: harus membuat record baru, bukan menimpa akun top up.
        [$travel, $isNew] = Customer::findOrCreateByPhone($phone, Customer::SOURCE_TRAVEL, 'Budi Travel', 50);

        $this->assertTrue($isNew);
        $this->assertNotSame($topup->id, $travel->id);
        $this->assertSame('travel', $travel->source);
        $this->assertSame(50, $travel->points);
        $this->assertSame('Budi Topup', $topup->fresh()->name);

        // Panggilan kedua (format 62...) menemukan record travel yang sama, bukan duplikat.
        [$again, $isNew2] = Customer::findOrCreateByPhone('62' . substr($phone, 1), Customer::SOURCE_TRAVEL, 'Budi Travel Baru');
        $this->assertFalse($isNew2);
        $this->assertSame($travel->id, $again->id);
        $this->assertSame('Budi Travel Baru', $travel->fresh()->name);
        $this->assertSame(2, Customer::whereIn('phone', Customer::phoneVariants($phone))->count());
    }

    public function test_travel_profile_endpoint_only_sees_travel_customers(): void
    {
        $phone = $this->phone();
        Customer::create(['name' => 'Hanya Topup', 'phone' => $phone, 'source' => Customer::SOURCE_TOPUP]);

        $this->getJson(route('travell.customer.profile', ['phone' => $phone]))->assertNotFound();

        Customer::create(['name' => 'Penumpang Asli', 'phone' => $phone, 'source' => Customer::SOURCE_TRAVEL, 'points' => 50]);
        $this->getJson(route('travell.customer.profile', ['phone' => $phone]))
            ->assertOk()->assertJsonPath('customer.name', 'Penumpang Asli');
    }

    public function test_google_card_purchase_records_customer_with_google_card_source(): void
    {
        Http::fake(['*/payments/charge' => Http::response(['data' => [
            'transaction_id' => 'trx-g1',
            'payment_details' => ['actions' => [['name' => 'generate-qr-code', 'url' => 'https://qr.test/g.png']]],
        ]])]);

        $phone = $this->phone();
        $this->postJson(route('landing.google_card.qris'), [
            'business_name' => 'Warung Maju', 'customer_name' => 'Rina Owner', 'phone' => $phone,
        ])->assertOk();

        $customer = Customer::findByPhone($phone, Customer::SOURCE_GOOGLE_CARD);
        $this->assertNotNull($customer);
        $this->assertSame('Rina Owner', $customer->name);
        $this->assertSame(0, $customer->points);
        $this->assertSame($customer->id, GoogleCardOrder::latest('id')->first()->customer_id);

        // Beli lagi dengan no. HP sama: customer yang sama dipakai, tidak membuat duplikat.
        $this->postJson(route('landing.google_card.qris'), [
            'business_name' => 'Toko Dua', 'customer_name' => 'Rina Owner', 'phone' => $phone,
        ])->assertOk();
        $this->assertSame(1, Customer::fromSource(Customer::SOURCE_GOOGLE_CARD)->whereIn('phone', Customer::phoneVariants($phone))->count());
    }
}
