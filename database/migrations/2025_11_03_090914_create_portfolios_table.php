<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained('portfolios')->onDelete('cascade');
            $table->string('image_url', 255);
            $table->string('caption', 255)->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamp('created_at')->useCurrent();

            // index tambahan
            $table->index('portfolio_id');
            $table->index('display_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_images');
    }
};
