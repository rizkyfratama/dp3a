<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';

    protected $fillable = [
        'tanggal',
        'nama',
        'no_hp',
        'kategori',
        'isi_pengaduan',
        'lampiran',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
