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
            $table->integer('jumlah_hari_penginapan')->nullable()->after('menginap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rincian_biaya_sppd', function (Blueprint $table) {
            //
            $table->dropColumn('jumlah_hari_penginapan');
        });
    }
};
