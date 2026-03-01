<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Pembinaan;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'name',
        'nik',
        'password',
        'status',          // status akun
        'status_anbimm',   // aktif / non_aktif / alumni
        'status_pencairan' // kalau kamu pakai ini juga
    ];

    /*
    |--------------------------------------------------------------------------
    | HIDDEN
    |--------------------------------------------------------------------------
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Relasi ke tabel pembinaans
    public function pembinaans()
    {
        return $this->hasMany(Pembinaan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR ROLE NAME (SPATIE)
    |--------------------------------------------------------------------------
    */
    public function getRoleNameAttribute()
    {
        return $this->getRoleNames()->first();
    }
}