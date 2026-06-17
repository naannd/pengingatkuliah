<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';

    // tugas has created_at (auto by MySQL) but NO updated_at
    public $timestamps = false;

    const CREATED_AT = 'created_at';

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'deadline',
        'progress',
        'status',
    ];

    protected $casts = [
        'deadline'   => 'datetime',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        // Cascade-delete related reminders before removing the tugas.
        static::deleting(function (Tugas $tugas) {
            $tugas->reminder()->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reminder()
    {
        return $this->hasMany(Reminder::class);
    }

    public function isSelesai(): bool
    {
        return $this->status === 'Selesai';
    }

    public function isOverdue(): bool
    {
        return !$this->isSelesai() && $this->deadline->isPast();
    }
}
