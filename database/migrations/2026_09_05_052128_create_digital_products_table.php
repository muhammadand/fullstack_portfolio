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
        Schema::create('digital_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('lynk_slug'); // Kode produk di Lynk.id (contoh: 1mk10gqm4olk atau 4pngq6kwqwzl)
            $table->string('category')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('commission_rate', 5, 2)->default(10.00); // Persentase komisi, default 10%
            $table->string('thumbnail')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('demo_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_products');
    }
};
