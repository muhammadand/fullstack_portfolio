<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('digital_product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique(); // Pulsa, Data, PLN, Games, dll
            $table->string('slug', 120)->unique();
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        Schema::table('digital_product_brands', function (Blueprint $table) {
            $table->foreignId('digital_product_category_id')->nullable()->after('id')
                ->constrained('digital_product_categories')->cascadeOnDelete();
        });

        // Pindahkan string kategori lama di brand menjadi baris kategori + FK.
        $now = now();
        foreach (DB::table('digital_product_brands')->distinct()->pluck('category') as $name) {
            $id = DB::table('digital_product_categories')->insertGetId([
                'name' => $name,
                'slug' => Str::slug($name) ?: Str::random(8),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('digital_product_brands')->where('category', $name)->update(['digital_product_category_id' => $id]);
        }

        Schema::table('digital_product_brands', function (Blueprint $table) {
            $table->dropUnique(['category', 'name']);
            $table->dropIndex(['category']);
            $table->dropColumn('category');
        });

        Schema::table('digital_product_brands', function (Blueprint $table) {
            $table->unique(['digital_product_category_id', 'name'], 'dp_brands_category_name_unique');
        });
    }

    public function down(): void
    {
        Schema::table('digital_product_brands', function (Blueprint $table) {
            $table->string('category', 100)->default('')->after('id');
        });

        DB::table('digital_product_brands')->update([
            'category' => DB::raw('(select name from digital_product_categories where digital_product_categories.id = digital_product_brands.digital_product_category_id)'),
        ]);

        // Urutan penting: lepas FK, lepas unique gabungan, baru hapus kolom.
        Schema::table('digital_product_brands', function (Blueprint $table) {
            $table->dropForeign(['digital_product_category_id']);
        });

        Schema::table('digital_product_brands', function (Blueprint $table) {
            $table->dropUnique('dp_brands_category_name_unique');
        });

        Schema::table('digital_product_brands', function (Blueprint $table) {
            $table->dropColumn('digital_product_category_id');
            $table->index('category');
            $table->unique(['category', 'name']);
        });

        Schema::dropIfExists('digital_product_categories');
    }
};
