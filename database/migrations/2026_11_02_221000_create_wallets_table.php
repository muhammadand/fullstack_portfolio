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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            // Berelasi strictly ke affiliates
            $table->foreignId('affiliate_id')->unique()->constrained('affiliates')->cascadeOnDelete();
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->decimal('hold_balance', 15, 2)->default(0.00);
            $table->string('status', 20)->default('active'); // active, suspended, locked
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};

