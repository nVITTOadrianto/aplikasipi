<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    protected $fillable = [
        'nama',
        'nip',
        'golongan',
        'ruang',
        'pangkat',
        'jabatan',
        'jabatan_ttd',
        'tempat_lahir',
        'tanggal_lahir'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'tanggal_lahir',
    ];
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $keyType = 'int';
    /**
     * Daftar SPPD di mana pegawai ini menjadi pemberi wewenang.
     */
    public function sppd_pemberi_wewenang()
    {
        return $this->hasMany(SPPD::class, 'pegawai_pemberi_wewenang');
    }

    /**
     * Daftar SPPD di mana pegawai ini menjadi pelaksana.
     */
    public function sppd_pelaksana()
    {
        return $this->hasMany(SPPD::class, 'pegawai_pelaksana');
    }

    /**
     * Daftar SPPD di mana pegawai ini menjadi pengikut 1.
     */
    public function sppd_pengikut_1()
    {
        return $this->hasMany(SPPD::class, 'pegawai_pengikut_1');
    }

    /**
     * Daftar SPPD di mana pegawai ini menjadi pengikut 2.
     */
    public function sppd_pengikut_2()
    {
        return $this->hasMany(SPPD::class, 'pegawai_pengikut_2');
    }

    /**
     * Daftar SPPD di mana pegawai ini menjadi pengikut 3.
     */
    public function sppd_pengikut_3()
    {
        return $this->hasMany(SPPD::class, 'pegawai_pengikut_3');
    }

    /**
     * Daftar SPPD di mana pegawai ini menjadi saksi.
     */
    public function sppd_mengetahui()
    {
        return $this->belongsTo(SPPD::class, 'pegawai_mengetahui');
    }
}
