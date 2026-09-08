<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $totalEvents = Event::count();
        $totalCategories = Kategori::count();
        $totalOrders = Order::count();
        
        // Menghitung total pendapatan dari order yang statusnya paid
        $pendapatan = Order::where('status_pembayaran', 'paid')->sum('total_bayar');

        // Mengambil 5 transaksi terbaru beserta relasi user dan event-nya
        $transaksiTerbaru = Order::with(['user', 'event'])
                            ->latest()
                            ->take(5)
                            ->get();

        // Mengambil event mendatang berdasarkan tanggal event
        $eventMendatang = Event::with('kategori')->where('tanggal_waktu', '>', now())
                         ->orderBy('tanggal_waktu', 'asc')
                         ->take(5)
                         ->get();

        $eventTerlaris= Event::withSum('detailOrders as total_tiket_terjual', 'jumlah')
            ->orderByDesc('total_tiket_terjual')
            ->first();
            
        $totalTerjual = $eventTerlaris->total_tiket_terjual ?? 0;

        return view('admin.dashboard', compact(
            'totalEvents', 
            'totalCategories', 
            'totalOrders', 
            'pendapatan', 
            'transaksiTerbaru', 
            'eventMendatang',
            'eventTerlaris',
            'totalTerjual'
        ));
    }
}