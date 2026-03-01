<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Pembinaan extends Model
{
    use HasFactory;

    protected $table = 'pembinaans'; // pastikan sesuai nama tabel kamu

    protected $fillable = [
        'user_id',
        'pembina_id',
        'tanggal_setor',
        'hafalan',
        'hadir_status',      // ganti dari 'hadir'
        'keterangan_hafalan',
        'catatan',
        'status_pencairan',  // ganti dari 'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */

    // Anak bimbing
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Admin / Pembina
    public function pembina()
    {
        return $this->belongsTo(User::class, 'pembina_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor (Optional tapi bagus buat clean UI)
    |--------------------------------------------------------------------------
    */

    public function getStatusKehadiranAttribute()
    {
        return ucfirst($this->hadir_status);
    }

    public function getStatusUangAttribute()
    {
        return $this->status_pencairan === 'sudah'
            ? 'Sudah Dicairkan'
            : 'Belum Dicairkan';
    }
}