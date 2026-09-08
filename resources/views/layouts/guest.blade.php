<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LokaTix') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100"> <!-- Background sedikit abu-abu (gray-200) -->
        <div class="min-h-screen flex flex-col justify-center items-center py-6 sm:px-6 lg:px-8">

            <!-- Kotak Form dengan Shadow yang Jelas dan Background Putih -->
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-2xl shadow-gray-400 overflow-hidden sm:rounded-2xl border border-gray-300">
                <!-- Logo LokaTix di Tengah Atas Form -->
                <div class="mb-6">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/images/lokatix.png') }}" alt="Logo LokaTix" class="h-12 w-auto mx-auto" />
                    </a>
                </div>
                {{ $slot }}
            </div>

            <!-- Link Kembali ke Beranda -->
            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-sm text-blue-700 hover:text-blue-900 font-medium transition">
                    &larr; Kembali ke Beranda LokaTix
                </a>
            </div>
        </div>
    </body>
</html>