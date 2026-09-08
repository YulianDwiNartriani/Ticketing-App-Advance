<x-layouts.admin>
    @push('content-class', 'overflow-hidden')

    <div class="h-[calc(100vh-2.5rem)] w-full overflow-hidden p-3 lg:p-4 bg-gray-50 flex flex-col justify-between">

        <!-- Header Judul & Sapaan -->
        <div class="shrink-0 flex items-start justify-between mb-3 w-full">
            <div class="flex items-center gap-3">
                <label for="my-drawer-4" aria-label="open sidebar" class="btn btn-square btn-sm btn-ghost lg:hidden bg-white shadow-sm border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor" class="size-4 text-gray-700">
                        <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                        <path d="M9 4v16"></path>
                        <path d="M14 10l2 2l-2 2"></path>
                    </svg>
                </label>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-black text-gray-900 tracking-tight leading-tight">Dashboard Admin</h1>
                    <p class="text-xs lg:text-sm text-gray-500 mt-0.5">Kelola data event dan pantau transaksi LokaTix secara real-time.</p>
                </div>
            </div>

            <!-- Sapaan User di Pojok Kanan Atas -->
            <div class="flex items-center gap-3 text-right">
                <div>
                    <p class="text-xs text-gray-400 font-medium">Selamat datang,</p>
                    <p class="text-sm font-extrabold text-gray-800">{{ Auth::user()->name ?? 'Admin User' }}</p>
                </div>
                <div class="size-10 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-sm shadow-sm shrink-0">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </div>

        <!-- Baris 1: Kartu Statistik -->
        <div class="shrink-0 grid grid-cols-1 md:grid-cols-4 gap-2.5 mb-2.5">
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-medium text-gray-500">Total Event</p>
                    <h3 class="text-xl font-extrabold text-gray-900">{{ $totalEvents ?? 0 }}</h3>
                </div>
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>

            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-medium text-gray-500">Kategori</p>
                    <h3 class="text-xl font-extrabold text-gray-900">{{ $totalCategories ?? 0 }}</h3>
                </div>
                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-medium text-gray-500">Total Transaksi</p>
                    <h3 class="text-xl font-extrabold text-gray-900">{{ $totalOrders ?? 0 }}</h3>
                </div>
                <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-medium text-gray-500">Pendapatan</p>
                    <h3 class="text-lg font-extrabold text-gray-900">Rp {{ number_format($pendapatan ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Baris 2: Konten Utama -->
        <div class="flex-1 min-h-0 grid grid-cols-1 lg:grid-cols-3 gap-2.5">
            <!-- Tabel Transaksi Terbaru -->
            <div class="lg:col-span-2 min-h-0 bg-white rounded-xl shadow-sm border border-gray-100 p-3.5 flex flex-col overflow-hidden">
                <div class="shrink-0 flex justify-between items-center mb-2">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wide">Transaksi Terbaru</h3>
                    <a href="#" class="text-[11px] text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
                </div>
                <div class="min-h-0 overflow-y-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">
                                <th class="pb-1.5">ID / Pembeli</th>
                                <th class="pb-1.5">Event</th>
                                <th class="pb-1.5">Total</th>
                                <th class="pb-1.5">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-xs">
                            @forelse($transaksiTerbaru ?? [] as $trx)
                                <tr>
                                    <td class="py-2">
                                        <p class="font-bold text-gray-800">#TRX-{{ $trx->id }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $trx->user->name ?? 'Guest' }}</p>
                                    </td>
                                    <td class="py-2 text-gray-600">{{ $trx->event->judul ?? '-' }}</td>
                                    <td class="py-2 font-semibold text-gray-900">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                                    <td class="py-2">
                                        <span class="px-2 py-0.5 text-[10px] font-semibold {{ strtolower($trx->status_pembayaran) == 'berhasil' || strtolower($trx->status_pembayaran) == 'paid' ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700' }} rounded-full">
                                            {{ ucfirst($trx->status_pembayaran) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-400 text-xs">Belum ada transaksi terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kolom Kanan: Tiket Terlaris & Event Mendatang -->
            <div class="flex flex-col gap-2.5 min-h-0">
                <!-- Tiket Terlaris -->
                <div class="shrink-0 bg-blue-600 text-white p-4 rounded-xl shadow-sm relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-blue-100 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Tiket Terlaris Saat Ini
                        </div>
                        <h3 class="font-bold text-base leading-snug mb-2">{{ $eventTerlaris->judul ?? 'Belum ada data' }}</h3>
                        <p class="text-xs text-blue-100">
                            Terjual <span class="font-bold text-white">{{ $totalTerjual ?? 0 }}</span> tiket
                        </p>
                    </div>
                </div>

                <!-- Event Mendatang -->
                <div class="flex-1 min-h-0 bg-white rounded-xl shadow-sm border border-gray-100 p-3.5 flex flex-col overflow-hidden">
                    <h3 class="shrink-0 text-xs font-bold text-gray-900 uppercase tracking-wide mb-2">Event Mendatang</h3>
                    <div class="min-h-0 overflow-y-auto space-y-2 pr-1">
                        @forelse($eventMendatang ?? [] as $ev)
                            <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-lg text-xs">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $ev->judul ?? 'Event' }}</p>
                                    <p class="text-[10px] text-gray-500">
                                        {{ $ev->tanggal_waktu ? \Carbon\Carbon::parse($ev->tanggal_waktu)->format('d M Y, H:i') : '-' }}
                                    </p>
                                </div>
                                <span class="text-[10px] font-bold text-blue-600 bg-blue-100 px-2 py-0.5 rounded shrink-0">
                                    {{ $ev->kategori->nama ?? 'Event' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-4">Tidak ada event mendatang.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts.admin>