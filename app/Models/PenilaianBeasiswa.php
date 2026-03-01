<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianBeasiswa extends Model
{
    protected $table = 'penilaian_beasiswa';

    protected $fillable = [

        'pendaftaran_id',

        'skor_rumah',
        'skor_kepemilikan',
        'skor_dinding',
        'skor_lantai',
        'skor_atap',
        'skor_dapur',
        'skor_kursi',

        'skor_baca_quran',
        'skor_hafalan',
        'skor_shalat',
        'skor_ibadah',

        'total_skor',
        'nilai_akhir',
        'status_kelayakan'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}