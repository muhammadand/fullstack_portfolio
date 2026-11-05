<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pencarian customer selalu (source + phone).
        Schema::table('customers', function (Blueprint $table) {
            $table->index(['source', 'phone'], 'customers_source_phone_index');
        });

        // Pembeli Google Review Card tercatat sebagai customer (source = google_card).
        Schema::table('google_card_orders', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('order_id')->constrained('customers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('google_card_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_id');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('customers_source_phone_index');
        });
    }
};
