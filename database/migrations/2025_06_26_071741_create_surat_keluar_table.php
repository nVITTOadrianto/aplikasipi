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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->enum('sub_kegiatan', ['Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat', 'Lain-Lain'])
                ->default('Lain-Lain');
            $table->string('penerima');
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat');
            $table->text('perihal');
            $table->string('file_surat');
            $table->enum('sifat', ['Segera', 'Biasa']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
