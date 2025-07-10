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
            $table->boolean('menginap')->nullable()->after('biaya_pulang')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rincian_biaya_sppd', function (Blueprint $table) {
            //
            $table->dropColumn('menginap');
        });
    }
};
