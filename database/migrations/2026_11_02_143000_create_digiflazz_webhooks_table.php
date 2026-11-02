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
        Schema::create('digiflazz_webhooks', function (Blueprint $table) {
            $table->id();
            $table->string('event')->nullable()->index(); // Header: X-Digiflazz-Event
            $table->string('signature')->nullable();      // Header: X-Hub-Signature (sha1 HMAC)
            $table->string('user_agent')->nullable();     // Header: User-Agent (indikator prepaid/postpaid)
            $table->string('ip_address', 45)->nullable(); // IP address pengirim callback
            $table->string('ref_id')->nullable()->index(); // Ref ID transaksi unik
            $table->string('customer_no')->nullable()->index(); // Nomor Pelanggan
            $table->string('buyer_sku_code')->nullable(); // Kode Produk Buyer
            $table->string('status')->nullable()->index(); // Status (Sukses, Gagal, Pending)
            $table->string('rc', 10)->nullable();         // Response Code Digiflazz (00, 45, dll)
            $table->string('sn')->nullable();             // Serial Number / SN produk
            $table->decimal('price', 15, 2)->nullable();  // Harga beli final
            $table->json('payload');                      // Seluruh raw payload JSON dari Digiflazz
            $table->json('headers')->nullable();          // Seluruh HTTP Headers dari Digiflazz
            $table->boolean('is_processed')->default(false)->index(); // Penanda apakah sudah dieksekusi
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digiflazz_webhooks');
    }
};

