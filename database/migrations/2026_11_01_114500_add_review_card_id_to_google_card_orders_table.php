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
        Schema::table('google_card_orders', function (Blueprint $table) {
            $table->foreignId('review_card_id')
                ->nullable()
                ->after('affiliate_id')
                ->constrained('review_cards')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('google_card_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('review_card_id');
        });
    }
};

