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
        Schema::create('wallet_mutations', function (Blueprint $table) {
            $table->id();
            $table->string('mutation_no', 50)->unique();
            $table->foreignId('affiliate_id')->constrained('affiliates')->cascadeOnDelete();
            $table->foreignId('wallet_id')->constrained('wallets')->cascadeOnDelete();
            $table->string('type', 10); // CREDIT (uang masuk), DEBIT (uang keluar)
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_before', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->string('category', 50)->index(); // DEPOSIT, PPOB_ORDER, PPOB_REFUND, MANUAL_ADJUSTMENT, WITHDRAWAL
            $table->nullableMorphs('reference'); // reference_type & reference_id
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_mutations');
    }
};
