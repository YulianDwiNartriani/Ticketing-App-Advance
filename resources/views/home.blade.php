<x-layouts.app>
    <!-- Hero Section dengan Alpine.js Slider & Dark Overlay -->
<div 
    x-data="{ 
        images: [
            '{{ asset('assets/images/hero-1.jpg') }}',
            '{{ asset('assets/images/hero-2.jpg') }}',
            '{{ asset('assets/images/hero-3.jpg') }}'
        ],
        activeSlide: 0,
        init() {
            setInterval(() => {
                this.activeSlide = (this.activeSlide + 1) % this.images.length;
            }, 4000); // Ganti gambar setiap 4 detik (4000ms)
        }
    }" 
    class="relative h-[80vh] w-full overflow-hidden flex items-center justify-center text-center"
>
    <!-- Loop untuk Background Gambar yang Berganti -->
    <template x-for="(img, index) in images" :key="index">
        <div 
                x-show="activeSlide === index"
                x-transition:enter="transition opacity-100 duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition opacity-0 duration-1000"
                class="absolute inset-0 bg-cover bg-center"
                :style="`background-image: url('${img}')`"
            ></div>
        </template>

        <!-- Layer Hitam Transparan (Overlay) agar Tulisan Terbaca -->
        <div class="absolute inset-0 bg-black/60"></div>

        <!-- Konten / Teks di atas Background -->
        <div class="relative z-10 px-4 text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Hi, Amankan Tiketmu yuk.</h1>
            <p class="text-lg md:text-xl text-gray-200 mb-6">LokaTix: Temukan event konser, pameran, dan orkestra terbaik di Semarang.</p>
            <a href="#events" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                Jelajahi Event
            </a>
        </div>
    </div>

    <section id="events" class="max-w-7xl mx-auto py-12 px-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black uppercase italic">Event</h2>
            <div class="flex gap-2">
                <!-- Tambahkan #events di akhir route untuk tombol "Semua" -->
                <a href="{{ route('home') }}#events">
                    <x-user.category-pill :label="'Semua'" :active="!request('kategori')" />
                </a>
                
                @foreach($categories as $kategori)
                <!-- Tambahkan #events di akhir route untuk setiap kategori -->
                <a href="{{ route('home', ['kategori' => $kategori->id]) }}#events">
                    <x-user.category-pill :label="$kategori->nama" :active="request('kategori') == $kategori->id" />
                </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($events as $event)
                <x-user.event-card 
                    :title="$event->judul" 
                    :date="$event->tanggal_waktu" 
                    :location="$event->lokasi"
                    :price="$event->tikets_min_harga" 
                    :image="$event->gambar" 
                    :diskon="$event->diskonAktif ?? null"
                    :href="route('events.show', $event)"/>
            @endforeach
        </div>
    </section>
</x-layouts.app>