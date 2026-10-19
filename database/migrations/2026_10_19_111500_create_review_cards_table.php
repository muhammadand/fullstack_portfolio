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
        Schema::create('review_cards', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number', 64)->unique();
            $table->string('slug', 64)->unique()->index();
            $table->string('activation_code', 32);
            $table->string('business_name')->nullable();
            $table->text('google_review_url')->nullable();
            $table->string('status', 20)->default('pending')->index(); // pending, active, inactive
            $table->string('owner_name')->nullable();
            $table->string('owner_phone', 50)->nullable();
            $table->unsignedBigInteger('total_scans')->default(0);
            $table->timestamp('activated_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_cards');
    }
};
