<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'reminder';

    public $timestamps = false;

    protected $fillable = [
        'tugas_id',
        'reminder_date',
        'status',
    ];

    protected $casts = [
        'reminder_date' => 'datetime',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
