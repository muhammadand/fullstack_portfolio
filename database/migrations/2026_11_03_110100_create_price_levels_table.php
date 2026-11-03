<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_levels', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique(); // retail, partner
            $table->string('name', 100);
            $table->string('margin_type', 10)->default('percent'); // percent | fixed
            $table->decimal('margin_value', 15, 2)->default(0);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        $now = now();
        DB::table('price_levels')->insert([
            ['code' => 'retail', 'name' => 'Retail (Customer Langsung)', 'margin_type' => 'percent', 'margin_value' => 5, 'is_default' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'partner', 'name' => 'Partner (Scalify)', 'margin_type' => 'percent', 'margin_value' => 2, 'is_default' => false, 'created_at' => $now, 'updated_at' => $now],
        ]);

        Schema::table('affiliates', function (Blueprint $table) {
            $table->foreignId('price_level_id')->nullable()->after('status')->constrained('price_levels')->nullOnDelete();
        });

        // Semua partner yang sudah ada otomatis masuk level "partner".
        $partnerId = DB::table('price_levels')->where('code', 'partner')->value('id');
        DB::table('affiliates')->update(['price_level_id' => $partnerId]);
    }

    public function down(): void
    {
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropConstrainedForeignId('price_level_id');
        });

        Schema::dropIfExists('price_levels');
    }
};
