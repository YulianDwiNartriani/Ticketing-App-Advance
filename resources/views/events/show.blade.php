<x-layouts.app>
  <section class="max-w-7xl mx-auto py-12 px-6">
    <nav class="mb-6">
      <div class="breadcrumbs text-sm">
        <ul>
          <li><a href="{{ route('home') }}" class="link link-neutral">Beranda</a></li>
          <li><a href="#" class="link link-neutral">Event</a></li>
          <li class="text-gray-500">{{ $event->judul }}</li>
        </ul>
      </div>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
      <!-- Left / Main area -->
      <div class="lg:col-span-2">
        <div class="card bg-base-100 shadow-sm border border-gray-100 overflow-hidden">
          <figure>
            <img src="{{ $event->gambar ? asset('storage/' . $event->gambar) : 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}" alt="{{ $event->judul }}" class="w-full h-96 object-cover" />
          </figure>
          <div class="card-body p-6 lg:p-8">
            <div class="flex justify-between items-start gap-4">
              <div>
                <h1 class="text-2xl lg:text-3xl font-black text-gray-900 tracking-tight">{{ $event->judul }}</h1>
                <p class="text-xs lg:text-sm text-gray-500 mt-2 flex items-center gap-2">
                  <span>{{ \Carbon\Carbon::parse($event->tanggal_waktu)->locale('id')->translatedFormat('d F Y, H:i') }}</span>
                  <span>•</span>
                  <span class="flex items-center gap-1">📍 {{ $event->lokasi }}</span>
                </p>

                <div class="mt-4 flex gap-2 items-center">
                  <span class="px-2.5 py-1 text-xs font-bold text-blue-600 bg-blue-50 rounded-md">{{ $event->kategori?->nama ?? 'Tanpa Kategori' }}</span>
                  <span class="px-2.5 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-md">{{ $event->user?->name ?? 'Penyelenggara' }}</span>
                </div>
              </div>
            </div>

            <p class="mt-6 text-sm text-gray-700 leading-relaxed">{{ $event->deskripsi }}</p>

            <div class="divider my-6"></div>

            <h3 class="text-lg font-bold text-gray-900">Pilih Tiket</h3>

            <div class="mt-4 space-y-4">
              @forelse($event->tikets as $tiket)
              <div class="card card-side bg-white border border-gray-100 shadow-xs p-4 items-center rounded-xl">
                <div class="flex-1 pr-4">
                  <h4 class="font-bold text-gray-900 text-sm lg:text-base">{{ $tiket->tipe }}</h4>
                  <p class="text-xs text-gray-500 mt-0.5">Stok: <span id="stock-{{ $tiket->id }}" class="font-semibold text-gray-700">{{ $tiket->stok }}</span></p>
                  <p class="text-xs text-gray-600 mt-2">{{ $tiket->keterangan ?? '' }}</p>
                </div>

                <div class="w-48 text-right flex flex-col items-end">
                  <div class="text-sm lg:text-base font-black text-blue-600">
                    {{ $tiket->harga ? 'Rp ' . number_format($tiket->harga, 0, ',', '.') : 'Gratis' }}
                  </div>

                  <div class="mt-3 flex items-center gap-1.5">
                    <button type="button" class="btn btn-sm btn-outline h-8 min-h-0 px-2.5" data-action="dec" data-id="{{ $tiket->id }}" aria-label="Kurangi satu">−</button>
                    <input id="qty-{{ $tiket->id }}" type="number" min="0" max="{{ $tiket->stok }}" value="0" class="input input-bordered input-sm w-14 text-center text-xs" data-id="{{ $tiket->id }}" />
                    <button type="button" class="btn btn-sm btn-outline h-8 min-h-0 px-2.5" data-action="inc" data-id="{{ $tiket->id }}" aria-label="Tambah satu">+</button>
                  </div>

                  <div class="text-xs text-gray-500 mt-2">Subtotal: <span id="subtotal-{{ $tiket->id }}" class="font-semibold text-gray-800">Rp 0</span></div>
                </div>
              </div>
              @empty
              <div class="alert alert-info text-xs">Tiket belum tersedia untuk acara ini.</div>
              @endforelse
            </div>

          </div>
        </div>
      </div>

      <!-- Right / Summary -->
      <div class="lg:col-span-1">
        <div class="card bg-base-100 shadow-sm border border-gray-100 p-6 sticky top-24 rounded-xl">
          <!-- DISKON UI -->
          @if($diskonAktif)
            <div class="mb-3">
              <span class="px-2.5 py-1 text-[11px] font-bold text-amber-700 bg-amber-50 rounded-md">
                Promo {{ $diskonAktif->nilai }}%
              </span>
            </div>
          @endif
          
          <h4 class="font-bold text-base text-gray-900">Ringkasan Pembelian</h4>

          <div class="mt-4 space-y-2">
            <div class="flex justify-between text-xs text-gray-500"><span>Item</span><span id="summaryItems" class="font-semibold text-gray-800">0</span></div>
            <div class="flex justify-between text-lg font-black text-gray-950 mt-1"><span>Total</span><span id="summaryTotal" class="text-blue-600">Rp 0</span></div>
            @if($diskonAktif)
              <p class="mt-1 text-[11px] text-gray-400 italic">
                * Promo {{ $diskonAktif->nilai }}% akan diterapkan saat checkout
              </p>
            @endif
          </div>

          <div class="divider my-4"></div>

          <div id="selectedList" class="space-y-2 text-xs text-gray-600">
            <p class="text-gray-400 italic">Belum ada tiket dipilih</p>
          </div>

          <div class="form-control mt-4">
            <label class="label pb-1">
              <span class="label-text text-xs font-semibold text-gray-600">Metode Pembayaran</span>
            </label>
            <select id="payment_type_id" class="select select-bordered select-sm w-full text-xs">
              <option value="" disabled selected>Pilih metode pembayaran</option>
              @foreach ($paymentTypes as $paymentType)
                <option value="{{ $paymentType->id }}">
                  {{ $paymentType->nama }}
                </option>
              @endforeach
            </select>
          </div>

          @auth
            <button id="checkoutButton" class="btn btn-primary btn-sm lg:btn-md !bg-blue-900 text-white btn-block mt-6" onclick="openCheckout()" disabled>Checkout</button>
          @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm lg:btn-md btn-block mt-6 text-white !bg-blue-900">Login untuk Checkout</a>
          @endauth
        </div>
      </div>
    </div>

    <!-- Checkout Modal -->
    <dialog id="checkout_modal" class="modal">
      <form method="dialog" class="modal-box rounded-2xl">
        <h3 class="font-bold text-base text-gray-900">Konfirmasi Pembelian</h3>
        <div class="mt-4 space-y-3 text-xs">
          <div id="modalItems" class="space-y-1">
            <p class="text-gray-400">Belum ada item.</p>
          </div>

          <div class="divider my-2"></div>
          <div class="flex justify-between items-center">
            <span class="font-bold text-gray-700">Total</span>
            <span class="font-black text-sm text-blue-600" id="modalTotal">Rp 0</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="font-bold text-gray-700">Metode Pembayaran</span>
            <span class="font-semibold text-gray-900" id="modalPaymentType">-</span>
          </div>
        </div>

        <div class="modal-action mt-6">
          <button class="btn btn-sm">Tutup</button>
          <button type="button" class="btn btn-sm btn-primary px-4 !bg-blue-900 text-white" id="confirmCheckout">Konfirmasi</button>
        </div>
      </form>
    </dialog>
  </section>

  <script>
    (function () {
      const formatRupiah = (value) => {
        return 'Rp ' + Number(value).toLocaleString('id-ID');
      }

      const tickets = {
        @foreach($event->tikets as $tiket)
            {{ $tiket->id }}: {
            id: {{ $tiket->id }},
            price: {{ $tiket->harga ?? 0 }},
            stock: {{ $tiket->stok }},
            tipe: "{{ e($tiket->tipe) }}"
          },
        @endforeach
      };

      const summaryItemsEl = document.getElementById('summaryItems');
      const summaryTotalEl = document.getElementById('summaryTotal');
      const selectedListEl = document.getElementById('selectedList');
      const checkoutButton = document.getElementById('checkoutButton');
      const paymentSelect = document.getElementById('payment_type_id');
      const modalPaymentType = document.getElementById('modalPaymentType');

      function updateSummary() {
        let totalQty = 0;
        let totalPrice = 0;
        let selectedHtml = '';

        Object.values(tickets).forEach(t => {
          const qtyInput = document.getElementById('qty-' + t.id);
          if (!qtyInput) return;
          const qty = Number(qtyInput.value || 0);
          if (qty > 0) {
            totalQty += qty;
            totalPrice += qty * t.price;
            selectedHtml += `<div class="flex justify-between text-xs"><span>${t.tipe} x ${qty}</span><span class="font-semibold">${formatRupiah(qty * t.price)}</span></div>`;
          }
        });

        summaryItemsEl.textContent = totalQty;
        summaryTotalEl.textContent = formatRupiah(totalPrice);
        selectedListEl.innerHTML = selectedHtml || '<p class="text-gray-400 italic">Belum ada tiket dipilih</p>';
        updateCheckoutState();
      }

      function updateCheckoutState() {
        if (!checkoutButton || !paymentSelect) return;
        const totalQty = Number(summaryItemsEl.textContent || 0);
        const hasPayment = !!paymentSelect.value;

        if (totalQty > 0 && hasPayment) {
          checkoutButton.disabled = false;
          checkoutButton.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
          checkoutButton.disabled = true;
          checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
      }

      if (checkoutButton) {
        checkoutButton.disabled = true;
        checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
      }

      if (paymentSelect) {
        paymentSelect.addEventListener('change', () => {
          updateCheckoutState();
        });
      }

      document.querySelectorAll('[data-action="inc"]').forEach(btn => {
        btn.addEventListener('click', (e) => {
          const id = e.currentTarget.dataset.id;
          const input = document.getElementById('qty-' + id);
          const info = tickets[id];
          if (!input || !info) return;
          let val = Number(input.value || 0);
          if (val < info.stock) val++;
          input.value = val;
          updateTicketSubtotal(id);
          updateSummary();
        });
      });

      document.querySelectorAll('[data-action="dec"]').forEach(btn => {
        btn.addEventListener('click', (e) => {
          const id = e.currentTarget.dataset.id;
          const input = document.getElementById('qty-' + id);
          if (!input) return;
          let val = Number(input.value || 0);
          if (val > 0) val--;
          input.value = val;
          updateTicketSubtotal(id);
          updateSummary();
        });
      });

      document.querySelectorAll('input[id^="qty-"]').forEach(input => {
        input.addEventListener('change', (e) => {
          const el = e.currentTarget;
          const id = el.dataset.id;
          const info = tickets[id];
          let val = Number(el.value || 0);
          if (val < 0) val = 0;
          if (val > info.stock) val = info.stock;
          el.value = val;
          updateTicketSubtotal(id);
          updateSummary();
        });
      });

      function updateTicketSubtotal(id) {
        const t = tickets[id];
        const qty = Number(document.getElementById('qty-' + id).value || 0);
        const subtotalEl = document.getElementById('subtotal-' + id);
        if (subtotalEl) subtotalEl.textContent = formatRupiah(qty * t.price);
      }

      window.openCheckout = function () {
        const modal = document.getElementById('checkout_modal');
        const modalItems = document.getElementById('modalItems');
        const modalTotal = document.getElementById('modalTotal');

        let itemsHtml = '';
        let total = 0;
        Object.values(tickets).forEach(t => {
          const qty = Number(document.getElementById('qty-' + t.id).value || 0);
          if (qty > 0) {
            itemsHtml += `<div class="flex justify-between text-xs"><span>${t.tipe} x ${qty}</span><span class="font-semibold">${formatRupiah(qty * t.price)}</span></div>`;
            total += qty * t.price;
          }
        });

        modalItems.innerHTML = itemsHtml || '<p class="text-gray-400">Belum ada item.</p>';
        modalTotal.textContent = formatRupiah(total);

        const selectedPaymentText = paymentSelect.options[paymentSelect.selectedIndex]?.text || '-';
        modalPaymentType.textContent = selectedPaymentText;

        if (typeof modal.showModal === 'function') {
          modal.showModal();
        } else {
          modal.classList.add('modal-open');
        }
      }

      updateSummary();

      const confirmBtn = document.getElementById('confirmCheckout');
      if (confirmBtn) {
        confirmBtn.addEventListener('click', async () => {
          confirmBtn.setAttribute('disabled', 'disabled');
          confirmBtn.textContent = 'Memproses...';

          const items = [];
          Object.values(tickets).forEach(t => {
            const qty = Number(document.getElementById('qty-' + t.id).value || 0);
            if (qty > 0) items.push({ tiket_id: t.id, jumlah: qty });
          });

          if (items.length === 0) {
            alert('Tidak ada tiket dipilih');
            confirmBtn.removeAttribute('disabled');
            confirmBtn.textContent = 'Konfirmasi';
            return;
          }

          try {
            const res = await fetch("{{ route('orders.store') }}", {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({ event_id: {{ $event->id }}, payment_type_id: paymentSelect.value, items })
            });

            if (!res.ok) {
              const text = await res.text();
              throw new Error(text || 'Gagal membuat pesanan');
            }

            const data = await res.json();
            window.location.href = data.redirect || '{{ route('orders.index') }}';
          } catch (err) {
            console.log(err);
            alert('Terjadi kesalahan saat memproses pesanan: ' + err.message);
            confirmBtn.removeAttribute('disabled');
            confirmBtn.textContent = 'Konfirmasi';
          }
        });
      }
    })(); 
  </script>
</x-layouts.app>