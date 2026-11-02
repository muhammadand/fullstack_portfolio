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
        Schema::table('digiflazz_webhooks', function (Blueprint $table) {
            $table->boolean('is_valid_signature')->nullable()->after('signature');
            $table->string('customer_name')->nullable()->after('customer_no');
            $table->string('message')->nullable()->after('status');
            $table->decimal('buyer_last_saldo', 15, 2)->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('digiflazz_webhooks', function (Blueprint $table) {
            $table->dropColumn([
                'is_valid_signature',
                'customer_name',
                'message',
                'buyer_last_saldo',
            ]);
        });
    }
};

