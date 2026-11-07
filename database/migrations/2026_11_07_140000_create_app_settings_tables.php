<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pengaturan aplikasi yang bisa diubah admin tanpa deploy (mis. mode Digiflazz dev/prod).
 * Rahasia (API key, secret) TIDAK disimpan di sini, tetap di .env.
 * Setiap perubahan dicatat append-only di app_setting_logs (jejak audit).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('app_setting_logs', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->index();
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index(); // tanpa FK: log tetap ada walau user dihapus
            $table->string('user_email')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_setting_logs');
        Schema::dropIfExists('app_settings');
    }
};
