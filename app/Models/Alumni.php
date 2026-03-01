<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni'; // <-- TAMBAHKAN INI

    protected $fillable = [
    'user_id',
    'nama',
    'nik',
    'alamat',
    'tahun_kelulusan',
    'kegiatan_selanjutnya',
    'jurusan',
    'instansi_asal',
    'email',
    'hp',
    'foto_ijazah'
    ];
}