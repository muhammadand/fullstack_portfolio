<?php

use App\Models\BookingDetail;
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
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('item_type')->nullable();
            $table->string('item_name');
            $table->string('seat_number')->nullable();
            $table->string('passenger_name')->nullable();
            $table->string('passenger_phone')->nullable();
            $table->string('pickup_point')->nullable();
            $table->string('drop_point')->nullable();
            $table->decimal('price')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('subtotal')->nullable();
            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
