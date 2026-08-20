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
        Schema::table('blogs', function (Blueprint $table) {
            $table->foreignId('affiliate_id')->nullable()->after('author_id')->constrained('affiliates')->nullOnDelete();
            $table->foreignId('business_category_id')->nullable()->after('category_id')->constrained('business_categories')->nullOnDelete();
            $table->boolean('is_rewarded')->default(false)->after('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['affiliate_id']);
            $table->dropForeign(['business_category_id']);
            $table->dropColumn(['affiliate_id', 'business_category_id', 'is_rewarded']);
        });
    }
};
