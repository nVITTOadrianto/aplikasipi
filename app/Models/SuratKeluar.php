<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;
    protected $table = 'surat_keluar';
    protected $fillable = [
        'penerima',
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'file_surat',
        'sifat',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'tanggal_surat',
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $keyType = 'int';
}
