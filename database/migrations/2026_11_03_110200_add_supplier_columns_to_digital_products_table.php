<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            // Kolom khusus Lynk.id jadi opsional agar bisa berbagi tabel dengan produk Digiflazz.
            $table->string('lynk_slug')->nullable()->change();

            $table->string('provider', 20)->default('lynk')->after('id')->index(); // lynk | digiflazz
            $table->string('sku_code', 100)->nullable()->unique()->after('provider'); // buyer_sku_code
            $table->foreignId('digital_product_brand_id')->nullable()->after('sku_code')
                ->constrained('digital_product_brands')->nullOnDelete();
            $table->string('type', 50)->nullable()->after('digital_product_brand_id'); // Umum / Khusus

            // Data dari supplier (ditimpa saat sync)
            $table->decimal('cost_price', 15, 2)->default(0)->after('price'); // modal
            $table->string('seller_name', 100)->nullable();
            $table->boolean('buyer_product_status')->default(true);
            $table->boolean('seller_product_status')->default(true);
            $table->boolean('unlimited_stock')->default(true);
            $table->integer('stock')->default(0);
            $table->boolean('multi')->default(false);
            $table->time('start_cut_off')->nullable();
            $table->time('end_cut_off')->nullable();
            $table->json('raw_payload')->nullable();

            // Status sinkronisasi
            $table->boolean('is_missing')->default(false); // hilang dari price-list terbaru
            $table->timestamp('last_synced_at')->nullable();

            $table->index(['provider', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            $table->dropIndex(['provider', 'is_active']);
            $table->dropConstrainedForeignId('digital_product_brand_id');
            $table->dropUnique(['sku_code']);
            $table->dropIndex(['provider']);
            $table->dropColumn([
                'provider', 'sku_code', 'type', 'cost_price', 'seller_name',
                'buyer_product_status', 'seller_product_status', 'unlimited_stock',
                'stock', 'multi', 'start_cut_off', 'end_cut_off', 'raw_payload',
                'is_missing', 'last_synced_at',
            ]);
        });
    }
};
