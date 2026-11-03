<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            // Sumber dana penarikan: commission (Saldo Komisi) / wallet (Saldo Wallet)
            $table->string('source', 20)->default('commission')->after('affiliate_id')->index();
            $table->timestamp('processed_at')->nullable()->after('proof_of_payment');
        });
    }

    public function down(): void
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropIndex(['source']);
            $table->dropColumn(['source', 'processed_at']);
        });
    }
};
