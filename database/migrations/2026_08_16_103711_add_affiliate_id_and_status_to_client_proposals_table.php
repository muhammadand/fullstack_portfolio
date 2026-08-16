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
            $table->unsignedBigInteger('affiliate_id')->nullable()->after('id')->comment('Affiliate who claimed this lead');
            $table->string('status')->default('open')->after('wa_template')->comment('open, contacted, won, lost');
            
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_proposals', function (Blueprint $table) {
            $table->dropForeign(['affiliate_id']);
            $table->dropColumn(['affiliate_id', 'status']);
        });
    }
};
