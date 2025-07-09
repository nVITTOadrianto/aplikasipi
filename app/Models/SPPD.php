<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPPD extends Model
{
    use HasFactory;
    protected $table = 'sppd';
    protected $fillable = [
        'sub_kegiatan',
        'lembar',
        'kode',
        'nomor_surat',
        'pegawai_pemberi_wewenang',
        'pegawai_pelaksana',
        'tingkat_biaya',
        'maksud',
        'alat_angkut',
        'tempat_berangkat',
        'tempat_kedudukan',
        'tempat_tujuan',
        'jumlah_hari',
        'tanggal_berangkat',
        'tanggal_kembali',
        'pegawai_pengikut_1',
        'pegawai_pengikut_2',
        'pegawai_pengikut_3',
        'instansi_pembebanan_anggaran',
        'akun_pembebanan_anggaran',
        'keterangan',
        'tanggal_tiba',
        'pegawai_mengetahui',
        'kepala_jabatan_di_tempat',
        'nama_di_tempat',
        'nip_di_tempat',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'tanggal_berangkat',
        'tanggal_kembali',
        'tanggal_tiba',
    ];
    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_tiba' => 'date',
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $keyType = 'int';
    /**
     * Relasi ke Pegawai yang memberi wewenang.
     * Foreign key-nya adalah 'pegawai_pemberi_wewenang'.
     */
    public function pemberi_wewenang()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_pemberi_wewenang');
    }

    /**
     * Relasi ke Pegawai pelaksana.
     * Foreign key-nya adalah 'pegawai_pelaksana'.
     */
    public function pelaksana()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_pelaksana');
    }

    /**
     * Relasi ke Pegawai pengikut 1.
     */
    public function pengikut_1()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_pengikut_1');
    }

    /**
     * Relasi ke Pegawai pengikut 2.
     */
    public function pengikut_2()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_pengikut_2');
    }

    /**
     * Relasi ke Pegawai pengikut 3.
     */
    public function pengikut_3()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_pengikut_3');
    }

    /**
     * Relasi ke Pegawai yang mengetahui.
     */
    public function mengetahui()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_mengetahui');
    }

    public function rincian_biaya() {
        return $this->hasOne(RincianBiayaSPPD::class, 'id_sppd');
    }
}
