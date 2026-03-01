<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'setoran_mulai',
        'setoran_selesai'
    ];

    protected $casts = [
        'setoran_mulai' => 'date',
        'setoran_selesai' => 'date',
    ];
}