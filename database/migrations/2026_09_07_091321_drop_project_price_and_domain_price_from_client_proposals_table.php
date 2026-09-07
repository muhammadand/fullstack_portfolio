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
        Schema::table('client_proposals', function (Blueprint $table) {
            if (Schema::hasColumn('client_proposals', 'project_price')) {
                $table->dropColumn('project_price');
            }
            if (Schema::hasColumn('client_proposals', 'domain_price')) {
                $table->dropColumn('domain_price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_proposals', function (Blueprint $table) {
            $table->integer('project_price')->nullable()->default(4500000);
            $table->integer('domain_price')->nullable()->default(1200000);
        });
    }
};
