<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('digital_product_brands', 'image')) {
            return;
        }

        Schema::table('digital_product_brands', function (Blueprint $table) {
            // Gambar poster game untuk landing page top up (diunggah admin)
            $table->string('image')->nullable()->after('logo');
        });
    }

    public function down(): void
    {
        Schema::table('digital_product_brands', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
