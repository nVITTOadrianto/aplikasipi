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
        Schema::create('rincian_biaya_sppd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sppd')->constrained('sppd')->onDelete('cascade');
            $table->double('biaya_pergi')->nullable();
            $table->double('biaya_pulang')->nullable();
            $table->double('biaya_penginapan_4')->nullable();
            $table->double('biaya_penginapan_3')->nullable();
            $table->double('biaya_penginapan_2')->nullable();
            $table->double('biaya_penginapan_1')->nullable();
            $table->double('uang_harian')->nullable();
            $table->string('keterangan_penerbangan')->nullable();
            $table->string('keterangan_tol')->nullable();
            $table->string('keterangan_lain')->nullable();
            $table->double('biaya_penerbangan')->nullable();
            $table->double('biaya_tol')->nullable();
            $table->double('biaya_lain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_biaya_sppd');
    }
};
