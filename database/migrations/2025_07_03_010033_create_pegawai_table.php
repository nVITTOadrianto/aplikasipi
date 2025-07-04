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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip');
            $table->enum('golongan', ['I', 'II', 'III', 'IV']);
            $table->enum('ruang', ['a', 'b', 'c', 'd', 'e']);
            $table->string('pangkat');
            $table->string('jabatan');
            $table->string('jabatan_ttd')->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
