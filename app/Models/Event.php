<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_waktu',
        'lokasi',
        'kategori_id',
        'gambar',
        'user_id',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
    ];

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    // untuk diskon per event
    public function diskons()
    {
        return $this->hasMany(Diskon::class);
    }
    public function getDiskonAktifAttribute()
    {
        return $this->diskons()
            ->where('aktif', true)
            ->where('mulai_at', '<=', now())
            ->where('berakhir_at', '>=', now())
            ->first();
    }


}
