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
        Schema::create('surat_perjalanan_dinas', function (Blueprint $table) {
            $table->id();
            $table->string('sub_kegiatan');
            $table->string('nama_pegawai');
            $table->string('nip_pegawai');
            $table->string('pangkat_golongan');
            $table->string('jabatan');
            $table->string('tingkat_biaya');
            $table->string('maksud');
            $table->string('alat_angkut');
            $table->string('tempat_berangkat');
            $table->string('tempat_tujuan');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->string('nama_pengikut_1')->nullable();
            $table->string('tgl_lahir_pengikut_1')->nullable();
            $table->string('keterangan_pengikut_1')->nullable();
            $table->string('nama_pengikut_2')->nullable();
            $table->string('tgl_lahir_pengikut_2')->nullable();
            $table->string('keterangan_pengikut_2')->nullable();
            $table->string('nama_pengikut_3')->nullable();
            $table->string('tgl_lahir_pengikut_3')->nullable();
            $table->string('keterangan_pengikut_3')->nullable();
            $table->string('instansi_pembebanan_anggaran');
            $table->string('akun_pembebanan_anggaran');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_perjalanan_dinas');
    }
};
