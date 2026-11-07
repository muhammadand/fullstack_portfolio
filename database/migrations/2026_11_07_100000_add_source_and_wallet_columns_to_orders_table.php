<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Jenis produk/sumber order: topup_game, pulsa, paket_data, pln, ...
            $table->string('source', 30)->default('topup_game')->after('order_no')->index();
            // Partner pembeli (order dibayar dengan saldo wallet partner). Null = customer/guest.
            $table->foreignId('affiliate_id')->nullable()->after('customer_id')->constrained('affiliates')->nullOnDelete();
            // Kunci idempoten dari form checkout partner agar double-tap tidak membuat order ganda.
            $table->string('idempotency_key', 64)->nullable()->after('affiliate_id');
            // Saldo dikembalikan (order wallet yang gagal). Diisi sekali secara atomik agar refund tidak ganda.
            $table->timestamp('refunded_at')->nullable()->after('completed_at');

            $table->unique(['affiliate_id', 'idempotency_key']);
            $table->index(['affiliate_id', 'source', 'created_at']);
        });

        // Order lama: tentukan source dari awalan nomor order.
        DB::table('orders')->where('order_no', 'like', 'PLN-%')->update(['source' => 'pln']);
        DB::table('orders')->where('order_no', 'like', 'PL-%')->update(['source' => 'pulsa']);
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['affiliate_id', 'source', 'created_at']);
            $table->dropUnique(['affiliate_id', 'idempotency_key']);
            $table->dropConstrainedForeignId('affiliate_id');
            $table->dropColumn(['source', 'idempotency_key', 'refunded_at']);
        });
    }
};
