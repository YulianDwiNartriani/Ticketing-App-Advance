<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactories;

class TicketType extends Model
{
    protected $fillable = [
        'nama',
    ];
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
