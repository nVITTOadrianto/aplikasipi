<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianBiayaSPPD extends Model
{
    use HasFactory;
    protected $table = 'rincian_biaya_sppd';
    protected $fillable = [
        'id_sppd', 'biaya_pergi', 'biaya_pulang', 'menginap', 'jumlah_hari_penginapan',
        'biaya_penginapan_4', 'biaya_penginapan_3', 'biaya_penginapan_2', 'biaya_penginapan_1',
        'uang_harian', 'keterangan_penerbangan', 'keterangan_tol', 'keterangan_lain',
        'biaya_penerbangan', 'biaya_tol', 'biaya_lain', 'id_pegawai_bendahara'
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $keyType = 'int';

    // Accessor to format biaya columns with thousand separator
    public function getBiayaPergiAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function getBiayaPulangAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function getBiayaPenginapan4Attribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function getBiayaPenginapan3Attribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function getBiayaPenginapan2Attribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function getBiayaPenginapan1Attribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function getUangHarianAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function getBiayaPenerbanganAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function getBiayaTolAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function getBiayaLainAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }
    public function sppd() {
        return $this->belongsTo(SPPD::class, 'id_sppd');
    }

    public function pegawai_bendahara() {
        return $this->belongsTo(Pegawai::class, 'id_pegawai_bendahara');
    }
}
