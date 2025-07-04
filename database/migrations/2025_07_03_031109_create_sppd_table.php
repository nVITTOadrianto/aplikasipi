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
        Schema::create('sppd', function (Blueprint $table) {
            # Halaman 1
            $table->id();
            $table->enum('sub_kegiatan', ['Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat', 'Lain-Lain'])
                ->default('Lain-Lain');
            $table->integer('lembar')->nullable();
            $table->integer('kode')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->foreignId('pegawai_pemberi_wewenang')->constrained('pegawai')->onDelete('cascade');
            $table->foreignId('pegawai_pelaksana')->constrained('pegawai')->onDelete('cascade');
            $table->string('tingkat_biaya');
            $table->string('maksud');
            $table->string('alat_angkut');
            $table->string('tempat_berangkat');
            $table->string('tempat_kedudukan')->nullable();
            $table->string('tempat_tujuan');
            $table->integer('jumlah_hari');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->foreignId('pegawai_pengikut_1')->nullable()->constrained('pegawai')->onDelete('set null');
            $table->foreignId('pegawai_pengikut_2')->nullable()->constrained('pegawai')->onDelete('set null');
            $table->foreignId('pegawai_pengikut_3')->nullable()->constrained('pegawai')->onDelete('set null');
            $table->string('instansi_pembebanan_anggaran');
            $table->string('akun_pembebanan_anggaran');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            # Halaman 2 (yg blm ada)
            $table->date('tanggal_tiba')->nullable();
            $table->foreignId('pegawai_mengetahui')->nullable()->constrained('pegawai')->onDelete('set null');
            $table->string('kepala_jabatan_di_tempat')->nullable();
            $table->string('nama_di_tempat')->nullable();
            $table->string('nip_di_tempat')->nullable();

            # File Surat
            $table->string('file_surat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sppd');
    }
};
