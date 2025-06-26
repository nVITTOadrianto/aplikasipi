<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;
    protected $table = 'surat_masuk';
    protected $fillable = [
        'nomor_surat',
        'pengirim',
        'tanggal_surat',
        'perihal',
        'file_surat',
        'sifat',
    ];
    protected $casts = [
        'tanggal_surat' => 'date',
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
