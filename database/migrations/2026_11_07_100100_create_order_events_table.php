<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Jejak audit order yang append-only (forensik, ISO 27001 A.8.15 Logging).
 * Baris tidak pernah di-update/di-hapus oleh aplikasi; tiap baris membawa hash berantai
 * (hash baris sebelumnya untuk order yang sama) sehingga perubahan/penghapusan bisa terdeteksi.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_events', function (Blueprint $table) {
            $table->id();
            // Tanpa FK cascade: jejak audit tetap ada walau order dihapus.
            $table->unsignedBigInteger('order_id')->index();
            $table->string('order_no', 50)->index();
            $table->string('event', 50)->index(); // order.created, wallet.debited, provider.sent, ...
            $table->string('status_from', 20)->nullable();
            $table->string('status_to', 20)->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->unsignedBigInteger('wallet_mutation_id')->nullable()->index();
            $table->string('actor_type', 30); // affiliate, customer, system, digiflazz, payment_gateway, admin
            $table->unsignedBigInteger('actor_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->json('context')->nullable();
            $table->char('prev_hash', 64)->nullable();
            $table->char('hash', 64);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_events');
    }
};
