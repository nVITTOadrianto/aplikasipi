<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianBiayaSPPD extends Model
{
    use HasFactory;
    protected $table = 'rincian_biaya_sppd';
    protected $fillable = [
        'id_sppd', 'biaya_pergi', 'biaya_pulang',
        'biaya_penginapan_4', 'biaya_penginapan_3', 'biaya_penginapan_2', 'biaya_penginapan_1',
        'uang_harian', 'keterangan_penerbangan', 'keterangan_tol', 'keterangan_lain',
        'biaya_penerbangan', 'biaya_tol', 'biaya_lain',
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $keyType = 'int';
    public function sppd() {
        return $this->belongsTo(SPPD::class, 'id_sppd');
    }
}
