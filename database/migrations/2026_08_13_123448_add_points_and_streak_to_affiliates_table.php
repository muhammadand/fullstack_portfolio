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
        Schema::table('affiliates', function (Blueprint $table) {
            $table->integer('points')->default(0)->after('balance');
            $table->integer('current_streak')->default(0)->after('points');
            $table->date('last_claim_date')->nullable()->after('current_streak');
            $table->integer('highest_streak')->default(0)->after('last_claim_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropColumn(['points', 'current_streak', 'last_claim_date', 'highest_streak']);
        });
    }
};
