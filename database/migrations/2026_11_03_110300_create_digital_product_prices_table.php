<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Override harga jual manual per produk per level.
        // Tanpa baris di sini, harga = cost_price + margin level.
        Schema::create('digital_product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_product_id')->constrained('digital_products')->cascadeOnDelete();
            $table->foreignId('price_level_id')->constrained('price_levels')->cascadeOnDelete();
            $table->decimal('selling_price', 15, 2);
            $table->timestamps();

            $table->unique(['digital_product_id', 'price_level_id']);
        });

        Schema::create('digital_product_cost_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_product_id')->constrained('digital_products')->cascadeOnDelete();
            $table->decimal('old_cost', 15, 2);
            $table->decimal('new_cost', 15, 2);
            $table->timestamp('changed_at')->useCurrent();

            $table->index(['digital_product_id', 'changed_at'], 'dp_cost_hist_product_changed_idx');
        });

        Schema::create('digital_product_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('status', 20)->default('running'); // running | success | failed
            $table->unsignedInteger('total_received')->default(0);
            $table->unsignedInteger('total_new')->default(0);
            $table->unsignedInteger('total_updated')->default(0);
            $table->unsignedInteger('total_cost_changed')->default(0);
            $table->unsignedInteger('total_missing')->default(0);
            $table->text('error_message')->nullable();
            $table->foreignId('triggered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('finished_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('digital_product_sync_logs');
        Schema::dropIfExists('digital_product_cost_histories');
        Schema::dropIfExists('digital_product_prices');
    }
};
