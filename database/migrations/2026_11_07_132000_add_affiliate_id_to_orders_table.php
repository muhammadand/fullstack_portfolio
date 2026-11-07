<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'source')) {
                $table->string('source', 30)->default('topup_game')->after('order_no')->index();
            }

            if (!Schema::hasColumn('orders', 'affiliate_id')) {
                $table->foreignId('affiliate_id')->nullable()->after('customer_id')->constrained('affiliates')->nullOnDelete();
            }

            if (!Schema::hasColumn('orders', 'idempotency_key')) {
                $table->string('idempotency_key', 64)->nullable()->after('affiliate_id');
            }

            if (!Schema::hasColumn('orders', 'refunded_at')) {
                $table->timestamp('refunded_at')->nullable()->after('completed_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'affiliate_id')) {
                $table->dropConstrainedForeignId('affiliate_id');
            }
            if (Schema::hasColumn('orders', 'idempotency_key')) {
                $table->dropColumn('idempotency_key');
            }
            if (Schema::hasColumn('orders', 'source')) {
                $table->dropColumn('source');
            }
            if (Schema::hasColumn('orders', 'refunded_at')) {
                $table->dropColumn('refunded_at');
            }
        });
    }
};
