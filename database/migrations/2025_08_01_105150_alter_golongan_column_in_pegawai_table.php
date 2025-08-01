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
        Schema::table('pegawai', function (Blueprint $table) {
            //
            $table->enum('golongan', ['I', 'II', 'III', 'IV', 'V', 'VII', 'IX'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            //
            $table->enum('golongan', ['I', 'II', 'III', 'IV'])->nullable()->change();
        });
    }
};
