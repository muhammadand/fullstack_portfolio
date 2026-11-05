<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Asal customer: travel | topup | google_card. Default 'travel' karena modul travel
            // adalah satu-satunya penulis tabel ini sebelum ada kolom ini.
            $table->string('source', 30)->default('travel')->index()->after('phone');
        });

        // Backfill: yang punya password pasti mendaftar lewat web top up.
        DB::table('customers')->whereNotNull('password')->update(['source' => 'topup']);
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['source']);
            $table->dropColumn('source');
        });
    }
};
