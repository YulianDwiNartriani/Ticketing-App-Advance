@props(['title', 'date', 'location', 'price', 'image', 'diskon', 'href' => null])

@php
// Format Indonesian price
$formattedPrice = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Harga tidak tersedia';

$discountedPrice = null;

if ($price && $diskon) {
    $discountedPrice = $price - ($price * $diskon->nilai / 100);
}

$formattedDiscountedPrice = $discountedPrice
    ? 'Rp ' . number_format($discountedPrice, 0, ',', '.')
    : null;

$formattedDate = $date
? \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('d F Y, H:i')
: 'Tanggal tidak tersedia';

// Safe image URL: use external URL if provided, otherwise use asset (storage path)
$imageUrl = $image
    ? asset('storage/' . $image)
    : asset('assets/images/default-event.jpg');


@endphp

<a href="{{ $href ?? '#' }}" class="block">
    <div class="card bg-base-100 h-96 shadow-sm hover:shadow-md transition-shadow duration-300 relative">
        <div class="h-48 overflow-hidden bg-gray-100 rounded-t-lg flex items-center justify-center">
            <img src="{{ $imageUrl }}" alt="{{ $title }}" class="object-contain">

        </div>

        <div class="card-body">
                        @if ($diskon)
                <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full z-10">
                    PROMO {{ $diskon->nilai }}%
                </span>
            @endif

            <h2 class="card-title">
                {{ $title }}
            </h2>

            <p class="text-sm text-gray-500">
                {{ $formattedDate }}
            </p>

            <p class="text-sm">
                📍 {{ $location }}
            </p>

             @if ($diskon)
                <p class="text-sm text-gray-400 line-through">
                    {{ $formattedPrice }}
                </p>
                <p class="font-bold text-lg text-red-600">
                    {{ $formattedDiscountedPrice }}
                </p>
            @else
                <p class="font-bold text-lg mt-2">
                    {{ $formattedPrice }}
                </p>
            @endif


        </div>
    </div>
</a>