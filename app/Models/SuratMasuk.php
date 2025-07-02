<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;
    protected $table = 'surat_masuk';
    protected $fillable = [
        'sub_kegiatan',
        'pengirim',
        'nomor_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'nomor_agenda',
        'sifat',
        'perihal',
        'file_surat',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'tanggal_surat',
        'tanggal_diterima',
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $keyType = 'int';
}
