<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained('blog_categories')
                  ->onDelete('cascade');

            $table->foreignId('author_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->string('excerpt', 255);
            $table->text('content');
            $table->string('featured_image', 255);
            $table->json('tags')->nullable()->comment('Array: Web Dev, React, Tutorial');
            $table->string('meta_title', 60)->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->integer('reading_time')->nullable()->comment('Dalam menit');
            $table->integer('view_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Index tambahan
            $table->index('category_id');
            $table->index('author_id');
            $table->index('is_published');
            $table->index('is_featured');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
