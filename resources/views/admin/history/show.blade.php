<x-layouts.admin title="Detail Pemesanan">
  <section class="max-w-4xl mx-auto py-12 px-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Detail Pemesanan</h1>
      <div class="text-sm text-gray-500">Order #{{ $order->id }} •
        {{ $order->order_date->format('d M Y H:i') }}
      </div>
    </div>

    <div class="card bg-base-100 shadow-md">
      <div class="lg:flex ">
        <div class="lg:w-1/3 p-4">
          <img
            src="{{ $order->event?->gambar ? asset('storage/' . $order->event->gambar) : 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}"
            alt="{{ $order->event?->judul ?? 'Event' }}" class="w-full object-cover mb-2" />
          <h2 class="font-semibold text-lg">{{ $order->event?->judul ?? 'Event' }}</h2>
          <p class="text-sm text-gray-500 mt-1">{{ $order->event?->lokasi ?? '' }}</p>
        </div>
        <div class="card-body lg:w-2/3">


          <div class="space-y-3">
            @foreach($order->detailOrders as $d)
              <div class="flex justify-between items-center">
                <div>
                  <div class="font-bold">{{ $d->tiket->tipe }}</div>
                  <div class="text-sm text-gray-500">Qty: {{ $d->jumlah }}</div>
                </div>
                <div class="text-right">
                  <div class="font-bold">Rp {{ number_format($d->subtotal_harga, 0, ',', '.') }}</div>
                </div>
              </div>
            @endforeach
          </div>

          <div class="divider"></div>

        <div class="space-y-1 mt-2 text-sm">
        <div class="flex justify-between">
            <span>Subtotal</span>
            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
        </div>

        @if ($order->diskon_nominal > 0)
            <div class="flex justify-between text-red-600">
                <span>Diskon</span>
                <span>- Rp {{ number_format($order->diskon_nominal, 0, ',', '.') }}</span>
            </div>
        @endif

        <div class="flex justify-between font-bold text-lg">
            <span>Total Bayar</span>
            <span>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
        </div>
    </div>


           <!-- {{-- FORM UPDATE STATUS --}} -->
            <form action="{{ route('admin.histories.update', $order) }}"
                method="POST"
                class="flex gap-3 items-center">
              @csrf
              @method('PUT')

              <select name="status_pembayaran" class="select select-bordered">
                  <option value="pending" {{ $order->status_pembayaran === 'pending' ? 'selected' : '' }}>
                      Pending
                  </option>
                  <option value="paid" {{ $order->status_pembayaran === 'paid' ? 'selected' : '' }}>
                      Paid
                  </option>
                  <option value="cancelled" {{ $order->status_pembayaran === 'cancelled' ? 'selected' : '' }}>
                      Cancelled
                  </option>
              </select>

              <button class="btn btn-primary btn-sm">
                  Update
              </button>
          </form>
          
          <div class="sm:ml-auto sm:mt-auto sm:mr-0 mx-auto mt-3 flex gap-2">
            <a href="{{ route('admin.histories.index') }}" class="btn btn-primary">Kembali ke Riwayat</a>
          </div>
        </div>
      </div>

    </div>
  </section>
</x-layouts.admin>
