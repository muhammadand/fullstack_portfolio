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
        Schema::create('google_card_visits', function (Blueprint $table) {
            $table->id();
            $table->date('visited_at')->index();
            $table->string('session_id', 64)->nullable()->index();
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('source_type', 25)->default('direct')->index(); // 'seo', 'social', 'shared', 'direct'
            $table->string('source_name', 50)->default('Direct')->index(); // 'Google Search', 'Threads', 'WhatsApp', etc.
            $table->text('referer')->nullable();
            $table->string('utm_source', 100)->nullable()->index();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->string('device_type', 20)->default('mobile')->index(); // 'mobile', 'tablet', 'desktop'
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_card_visits');
    }
};
