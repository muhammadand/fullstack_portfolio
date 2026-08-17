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
        Schema::create('student_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('wa_number');
            $table->string('university')->nullable();
            $table->string('needs'); // e.g. "Website E-Commerce", "Tugas Akhir"
            $table->foreignId('affiliate_id')->nullable()->constrained('affiliates')->nullOnDelete();
            $table->string('status')->default('new'); // new, contacted, deal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_leads');
    }
};
