<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lead_offerings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_proposal_id')->constrained('client_proposals')->onDelete('cascade');
            $table->foreignId('affiliate_id')->constrained('affiliates')->onDelete('cascade');
            $table->string('product_type', 50)->comment('website, review_card, etc.');
            $table->string('status', 50)->default('contacted')->comment('contacted, interested, won, lost');
            $table->timestamp('contacted_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // 1 Bisnis / Proposal hanya boleh di-claim oleh 1 affiliate per jenis produk
            $table->unique(['client_proposal_id', 'product_type'], 'unique_lead_product_offering');
            $table->index(['affiliate_id', 'product_type'], 'idx_affiliate_product_offering');
        });

        // Migrasikan klaim penawaran website yang sudah ada di client_proposals
        if (Schema::hasTable('client_proposals') && Schema::hasColumn('client_proposals', 'affiliate_id')) {
            $existing = DB::table('client_proposals')->whereNotNull('affiliate_id')->get();
            foreach ($existing as $cp) {
                DB::table('lead_offerings')->insertOrIgnore([
                    'client_proposal_id' => $cp->id,
                    'affiliate_id'       => $cp->affiliate_id,
                    'product_type'       => 'website',
                    'status'             => $cp->status ?? 'contacted',
                    'contacted_at'       => $cp->updated_at ?? now(),
                    'created_at'         => $cp->created_at ?? now(),
                    'updated_at'         => $cp->updated_at ?? now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_offerings');
    }
};
