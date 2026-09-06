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
        Schema::table('client_proposals', function (Blueprint $table) {
            $table->integer('price_silver')->nullable()->default(700000)->after('domain_price');
            $table->integer('price_gold')->nullable()->default(1600000)->after('price_silver');
            $table->integer('price_diamond')->nullable()->default(2000000)->after('price_gold');
            $table->integer('price_platinum')->nullable()->default(3000000)->after('price_diamond');
            $table->string('renewal_silver')->nullable()->default('500rb/tahun')->after('price_platinum');
            $table->string('renewal_gold')->nullable()->default('600rb/tahun')->after('renewal_silver');
            $table->string('renewal_diamond')->nullable()->default('1juta/tahun')->after('renewal_gold');
            $table->string('renewal_platinum')->nullable()->default('50% per tahun')->after('renewal_diamond');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_proposals', function (Blueprint $table) {
            $table->dropColumn([
                'price_silver',
                'price_gold',
                'price_diamond',
                'price_platinum',
                'renewal_silver',
                'renewal_gold',
                'renewal_diamond',
                'renewal_platinum',
            ]);
        });
    }
};
