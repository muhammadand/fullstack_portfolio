<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('portfolio_categories')->onDelete('cascade');
            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->string('client_name', 100)->nullable();
            $table->string('project_type', 100)->nullable()->comment('E-Commerce, Corporate Website');
            $table->string('short_description', 255);
            $table->text('full_description');
            $table->text('challenge')->nullable();
            $table->text('solution')->nullable();
            $table->text('result')->nullable();
            $table->string('thumbnail_image', 255);
            $table->string('featured_image', 255)->nullable();
            $table->json('technologies')->nullable()->comment('Array: React, Node.js, MongoDB');
            $table->string('project_url', 255)->nullable();
            $table->string('github_url', 255)->nullable();
            $table->date('completion_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('view_count')->default(0);
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // index tambahan
            $table->index('category_id');
            $table->index('is_featured');
            $table->index('display_order');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
