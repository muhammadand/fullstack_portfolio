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
        Schema::create('google_card_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique()->index();
            $table->string('business_name');
            $table->string('customer_name');
            $table->string('phone', 30)->index();
            $table->text('google_maps_url')->nullable();
            $table->string('design_type')->default('Standee Meja Akrilik');
            $table->string('theme')->default('Classic White');
            $table->decimal('amount', 12, 2)->default(20000);
            $table->string('payment_method', 50)->default('qris');
            $table->string('payment_status', 50)->default('pending')->index(); // pending, paid, expired, failed
            $table->string('transaction_id')->nullable()->index();
            $table->text('qris_payload')->nullable();
            $table->text('qris_image_url')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('raw_response')->nullable();
            $table->foreignId('affiliate_id')->nullable()->constrained('affiliates')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_card_orders');
    }
};

