<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'payment_type_id',  
        'diskon_id',
        'order_date',
        'total_harga',
        'diskon_nominal',
        'total_bayar',
        'status_pembayaran',

    ];
    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tikets()
    {
        return $this->belongsToMany(Tiket::class, 'detail_orders')->withPivot('jumlah', 'subtotal_harga');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class);
    }
    public function paymentType()
    {
        return $this->belongsTo(\App\Models\PaymentType::class);
    }
    public function diskon()
    {
        return $this->belongsto(Diskon::class);
    }

}