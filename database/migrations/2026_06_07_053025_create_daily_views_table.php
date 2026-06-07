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
        Schema::create('daily_views', function (Blueprint $table) {
            $table->id();
            $table->string('viewable_type');
            $table->unsignedBigInteger('viewable_id');
            $table->date('date');
            $table->integer('views_count')->default(0);
            $table->timestamps();

            // Indexing for faster queries
            $table->index(['viewable_type', 'viewable_id']);
            $table->index('date');
            $table->unique(['viewable_type', 'viewable_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_views');
    }
};
