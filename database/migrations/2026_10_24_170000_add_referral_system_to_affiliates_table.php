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
        // 1. Tambah referred_by_id ke tabel affiliates
        Schema::table('affiliates', function (Blueprint $table) {
            $table->foreignId('referred_by_id')
                ->nullable()
                ->after('affiliate_code')
                ->constrained('affiliates')
                ->nullOnDelete();
        });

        // 2. Buat tabel audit log komisi referral multi-tier
        Schema::create('affiliate_referral_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upline_id')->constrained('affiliates')->cascadeOnDelete();
            $table->foreignId('downline_id')->constrained('affiliates')->cascadeOnDelete();
            $table->string('order_id', 50)->index();
            $table->unsignedTinyInteger('level'); // 1, 2, or 3
            $table->unsignedInteger('card_quantity');
            $table->decimal('rate_per_unit', 10, 2);
            $table->decimal('total_amount', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_referral_commissions');

        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropForeign(['referred_by_id']);
            $table->dropColumn('referred_by_id');
        });
    }
};
