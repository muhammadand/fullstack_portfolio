<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('digital_product_brands', function (Blueprint $table) {
            $table->id();
            $table->string('category', 100)->index(); // Pulsa, Data, PLN, Games, dll
            $table->string('name', 100);
            $table->string('slug', 150)->unique();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();

            $table->unique(['category', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('digital_product_brands');
    }
};
