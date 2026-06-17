<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'user_id',
        'mata_kuliah',
        'dosen',
        'ruangan',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public $timestamps = false;
}