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
        Schema::table('rincian_biaya_sppd', function (Blueprint $table) {
            //
            $table->foreignId('id_pegawai_bendahara')->nullable()->constrained('pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rincian_biaya_sppd', function (Blueprint $table) {
            //
            $table->dropColumn('id_pegawai_bendahara');
        });
    }
};
