<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftarans';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        // RELASI
        'user_id',

        // ================= DATA DIRI =================
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nim_nisn',
        'no_hp',
        'alamat',

        // ================= DOKUMEN =================
        'ktp',
        'kk',
        'surat_tidak_mampu',
        'surat_aktif',
        'rapor_khs',
        'surat_berakhlak',
        'surat_ibadah',
        'pas_foto',

        // ================= STATUS =================
        'status', // lama
        'status_berkas',
        'status_survey',
        'status_pencairan',
        'status_anbimm',

        // ================= TIMESTAMP KHUSUS =================
        'verifikasi_at',
        'diterima_at',
        'ditolak_at',
        'alasan_ditolak',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTING
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'tanggal_lahir' => 'date',
        'verifikasi_at' => 'datetime',
        'diterima_at'   => 'datetime',
        'ditolak_at'    => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke pembinaan
    public function pembinaans()
    {
        return $this->hasMany(Pembinaan::class);
    }

    // Relasi ke penilaian survey
    public function penilaian()
    {
        return $this->hasOne(PenilaianBeasiswa::class);
    }
}