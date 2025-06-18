<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nomor_pendaftaran',
        'nisn',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_sekolah',
        'jalur',
        'pilihan_1',
        'skor_pilihan_1',
        'pilihan_2',
        'skor_pilihan_2',
        'pilihan_3',
        'skor_pilihan_3',
        'pilihan_ke',
        'pilihan_diterima',
        'skor_akhir'
    ];
    
}
