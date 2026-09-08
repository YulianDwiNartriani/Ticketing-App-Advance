<x-layouts.admin title="Detail Pemesanan">
  <section class="max-w-4xl mx-auto py-8 px-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-black text-gray-900 tracking-tight">Detail Pemesanan</h1>
      <div class="text-sm text-gray-500 font-medium">
        Order <span class="text-primary font-bold">#{{ $order->id }}</span> • {{ $order->order_date->format('d M Y, H:i') }}
      </div>
    </div>

    <div class="card bg-white shadow-sm border border-gray-100 overflow-hidden">
      <div class="lg:flex">
        <!-- Bagian Kiri: Info Event -->
        <div class="lg:w-1/3 p-6 bg-gray-50/50 border-r border-gray-100 flex flex-col justify-between">
          <div>
            <div class="rounded-xl overflow-hidden shadow-sm mb-4 aspect-video bg-gray-200">
              <img
                src="{{ $order->event?->gambar ? asset('storage/' . $order->event->gambar) : 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}"
                alt="{{ $order->event?->judul ?? 'Event' }}" class="w-full h-full object-cover" />
            </div>
            <h2 class="font-bold text-lg text-gray-900 leading-snug">{{ $order->event?->judul ?? 'Event' }}</h2>
            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              {{ $order->event?->lokasi ?? '-' }}
            </p>
          </div>

          <div class="mt-6 pt-4 border-t border-gray-200/60 hidden lg:block">
            <a href="{{ route('admin.histories.index') }}" class="btn btn-outline btn-sm w-full gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
              Kembali ke Riwayat
            </a>
          </div>
        </div>

        <!-- Bagian Kanan: Detail Tiket, Harga, & Aksi -->
        <div class="card-body lg:w-2/3 p-6 flex flex-col justify-between">
          <div>
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Daftar Tiket Pesanan</h3>
            <div class="space-y-3 bg-gray-50/50 p-4 rounded-xl border border-gray-100 text-xs">
              @foreach($order->detailOrders as $d)
                <div class="flex justify-between items-center">
                  <div>
                    <!-- Mengambil nama tipe tiket dari relasi ticketType->nama -->
                    <div class="font-bold text-gray-900 text-sm">{{ $d->tiket->ticketType->nama ?? 'Tiket' }}</div>
                    <div class="text-gray-500">Jumlah: <span class="font-medium text-gray-700">{{ $d->jumlah }}x</span></div>
                  </div>
                  <div class="text-right">
                    <div class="font-bold text-gray-900 text-sm">Rp {{ number_format($d->subtotal_harga, 0, ',', '.') }}</div>
                  </div>
                </div>
              @endforeach
            </div>

            <div class="divider my-4"></div>

            <div class="space-y-2 text-sm text-gray-600">
              <div class="flex justify-between">
                <span>Subtotal</span>
                <span class="font-medium text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
              </div>

              @if ($order->diskon_nominal > 0)
                <div class="flex justify-between text-red-500">
                  <span>Diskon</span>
                  <span class="font-medium">- Rp {{ number_format($order->diskon_nominal, 0, ',', '.') }}</span>
                </div>
              @endif

              <div class="flex justify-between items-center text-base font-bold text-gray-900 pt-2 border-t border-gray-100">
                <span>Total Bayar</span>
                <span class="text-primary text-lg">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
              </div>
            </div>
          </div>

          <!-- Form Update Status & Tombol Kembali (Mobile) -->
          <div class="mt-8 pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            <form action="{{ route('admin.histories.update', $order) }}" method="POST" class="flex gap-2 items-center">
              @csrf
              @method('PUT')

              <select name="status_pembayaran" class="select select-bordered select-sm text-xs font-medium">
                <option value="pending" {{ $order->status_pembayaran === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ $order->status_pembayaran === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="cancelled" {{ $order->status_pembayaran === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
              </select>

              <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
            </form>

            <div class="block lg:hidden">
              <a href="{{ route('admin.histories.index') }}" class="btn btn-outline btn-sm w-full">Kembali ke Riwayat</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-layouts.admin>