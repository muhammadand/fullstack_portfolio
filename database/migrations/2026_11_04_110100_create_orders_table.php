<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique()->index();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('digital_product_id')->constrained('digital_products')->cascadeOnDelete();

            // Nomor tujuan pengisian (ID Game / Player ID / No HP / ID Pelanggan PLN)
            $table->string('customer_no')->index();

            // Data pelengkap form akun (contoh: zone_id, server_id)
            $table->json('account_data')->nullable();

            // Snapshot produk & finansial saat transaksi dibuat
            $table->string('product_name');
            $table->string('sku_code')->nullable()->index();
            $table->decimal('cost_price', 12, 2)->default(0);
            $table->decimal('price', 12, 2);
            $table->decimal('admin_fee', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);

            // Status order & pembayaran
            $table->string('status')->default('pending')->index(); // pending, processing, success, failed, expired, cancelled
            $table->string('payment_status')->default('unpaid')->index(); // unpaid, paid, expired, failed
            $table->string('payment_method')->nullable(); // qris, wallet, va_bca, etc.
            $table->string('payment_reference')->nullable()->index(); // ID transaksi dari payment gateway

            // Integrasi Provider (Digiflazz)
            $table->string('provider_ref_id')->nullable()->index(); // ref_id yang dikirim ke Digiflazz
            $table->string('sn')->nullable(); // Serial Number / Token PLN / Voucher Code
            $table->text('provider_message')->nullable();

            // Catatan pembeli
            $table->text('notes')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

