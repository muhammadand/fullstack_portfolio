<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Saldo customer top up: refund otomatis order gagal + penarikan ke e-wallet (diproses admin, potongan 2%).
 * Setiap perubahan saldo dicatat di customer_balance_mutations (append-only).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'balance')) {
                $table->decimal('balance', 15, 2)->default(0)->after('points');
            }
        });

        Schema::create('customer_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->string('withdrawal_no', 40)->unique();
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->decimal('amount', 15, 2);      // nominal yang dipotong dari saldo
            $table->decimal('fee', 15, 2);         // potongan admin
            $table->decimal('net_amount', 15, 2);  // yang ditransfer ke customer
            $table->string('ewallet', 30);
            $table->string('account_no', 30);
            $table->string('account_name', 100);
            $table->string('status', 20)->default('pending')->index(); // pending | completed | rejected
            $table->string('admin_note')->nullable();
            $table->string('transfer_reference', 100)->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();     // users.id admin
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->index(['customer_id', 'created_at']);
        });

        Schema::create('customer_balance_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->string('type', 10);       // CREDIT | DEBIT
            $table->string('category', 30);   // ORDER_REFUND | WITHDRAWAL | WITHDRAWAL_REVERSAL
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_before', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->nullableMorphs('reference');
            $table->string('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['customer_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_balance_mutations');
        Schema::dropIfExists('customer_withdrawals');
        Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'balance')) {
                $table->dropColumn('balance');
            }
        });
    }
};
