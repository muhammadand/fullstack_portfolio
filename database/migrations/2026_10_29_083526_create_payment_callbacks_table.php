<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_callbacks', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->index();
            $table->string('transaction_id')->nullable()->index();
            $table->string('transaction_status', 50)->nullable();
            $table->json('raw_response'); // Menyimpan seluruh respons mentah dari Midtrans
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_callbacks');
    }
};
