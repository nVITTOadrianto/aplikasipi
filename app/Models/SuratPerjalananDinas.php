<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPerjalananDinas extends Model
{
    use HasFactory;
    protected $table = 'surat_perjalanan_dinas';
    protected $fillable = [
        'sub_kegiatan',
        'nama_pegawai',
        'nip_pegawai',
        'pangkat_golongan',
        'jabatan',
        'tingkat_biaya',
        'maksud',
        'alat_angkut',
        'tempat_berangkat',
        'tempat_tujuan',
        'tanggal_berangkat',
        'tanggal_kembali',
        'nama_pengikut_1',
        'tgl_lahir_pengikut_1',
        'keterangan_pengikut_1',
        'nama_pengikut_2',
        'tgl_lahir_pengikut_2',
        'keterangan_pengikut_2',
        'nama_pengikut_3',
        'tgl_lahir_pengikut_3',
        'keterangan_pengikut_3',
        'instansi_pembebanan_anggaran',
        'akun_pembebanan_anggaran',
        'keterangan',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'tanggal_berangkat',
        'tanggal_kembali',
        'tgl_lahir_pengikut_1',
        'tgl_lahir_pengikut_2',
        'tgl_lahir_pengikut_3',
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $keyType = 'int';
}
