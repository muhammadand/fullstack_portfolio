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
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('career_id')
                ->constrained('careers')
                ->cascadeOnDelete();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('resume')->nullable(); // cv/resume pdf
            $table->string('portfolio_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->longText('cover_letter')->nullable();
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};