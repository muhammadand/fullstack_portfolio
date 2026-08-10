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
        Schema::create('client_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // untuk URL
            $table->string('brand_name'); // e.g. "Permata Qiana Wedding"
            $table->string('client_name')->nullable(); // e.g. "Manajemen Permata Qiana Wedding"
            $table->string('wa_number')->nullable(); // e.g. "6281234567890"
            $table->text('wa_template')->nullable();
            $table->integer('project_price')->default(4500000);
            $table->integer('domain_price')->default(1200000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_proposals');
    }
};
