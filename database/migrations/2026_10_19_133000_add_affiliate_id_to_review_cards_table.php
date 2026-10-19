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
        Schema::table('review_cards', function (Blueprint $table) {
            $table->foreignId('affiliate_id')
                ->nullable()
                ->after('id')
                ->constrained('affiliates')
                ->nullOnDelete();

            $table->unsignedInteger('buy_price')->nullable()->after('status');
            $table->string('payment_status', 20)->default('unpaid')->after('buy_price'); // unpaid, paid
            $table->timestamp('purchased_at')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_cards', function (Blueprint $table) {
            $table->dropForeign(['affiliate_id']);
            $table->dropColumn(['affiliate_id', 'buy_price', 'payment_status', 'purchased_at']);
        });
    }
};
