<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Kategori;
use App\Models\Diskon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function index(Request $request)
    {
        $categories = Kategori::all();

        $eventsQuery = Event::withMin('tikets', 'harga')
            ->orderBy('tanggal_waktu', 'asc');

        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori') && $request->kategori) {
            $eventsQuery->where('kategori_id', $request->kategori);
        }

        // Filter berdasarkan input pencarian
        if ($request->has('search') && $request->search) {
            $eventsQuery->where('judul', 'like', '%' . $request->search . '%');
        }

        $events = $eventsQuery->paginate(8)->withQueryString();

        $diskonAktif = Diskon::where('aktif', true)->where('mulai_at', '<=', now())->where('berakhir_at', '>=', now())->first();
        // $diskonAktif = Diskon::first();
        // dd($diskonAktif);

        return view('home', compact('events', 'categories', 'diskonAktif'));
    }
    public function search(Request $request)
    {
        $keyword = $request->get('q');

        if (strlen($keyword) < 3) {
            return response()->json([]);
        }

        $events = Event::where('judul', 'like', '%' . $keyword . '%')
            ->take(5)
            ->get();

        return response()->json($events);
    }
}
