<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_page_visits', function (Blueprint $table) {
            $table->id();
            $table->date('visited_at');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('device_type', 20)->nullable(); // mobile, tablet, desktop
            $table->string('referer', 500)->nullable();
            $table->timestamps();

            $table->index('visited_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_page_visits');
    }
};
