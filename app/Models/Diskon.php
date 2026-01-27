<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    protected $fillable = [
        'nama',
        'nilai',
        'aktif',
        'mulai_at',
        'berakhir_at',
        'event_id',
    ];

     protected $casts = [
        'mulai_at' => 'datetime',
        'berakhir_at' => 'datetime',
        'aktif' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}
