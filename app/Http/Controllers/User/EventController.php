<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\PaymentType;
use App\Models\Diskon;


class EventController extends Controller
{
    public function show(Event $event)
    {
        $event->load(['tikets', 'kategori', 'user']);
        $paymentTypes = PaymentType::all();
        //diskon global
        // $diskonAktif = Diskon::where('aktif', true)
        // ->where('mulai_at', '<=', now())
        // ->where('berakhir_at', '>=', now())
        // ->first();

        //diskon perevent
        //$event = Event::findOrFail($id);

        $diskonAktif = Diskon::where('aktif', true)
            ->where(function ($q) use ($event) {
                $q->whereNull('event_id')        // diskon global
                ->orWhere('event_id', $event->id); // diskon event ini
            })
            ->where('mulai_at', '<=', now())
            ->where('berakhir_at', '>=', now())
            ->first();

        return view('events.show', compact('event', 'paymentTypes', 'diskonAktif'));
    }
}
