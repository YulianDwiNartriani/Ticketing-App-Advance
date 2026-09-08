<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="h-screen overflow-hidden bg-gray-50 flex flex-col">
    <div class="drawer lg:drawer-open flex-1 h-full overflow-hidden">
        <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
        
        <!-- Area Konten Utama & Footer -->
        <div class="drawer-content flex flex-col h-full overflow-hidden">
            <!-- Tambahkan @stack('content-class') agar bisa diatur per halaman -->
            <div class="flex-1 @stack('content-class', 'overflow-y-auto')">
                {{ $slot }}
            </div>

            <footer class="shrink-0 text-center py-2 text-xs text-gray-500 bg-white border-t border-gray-100">
                <div class="container mx-auto">
                    <p>© {{ date('Y') }} MyLaravelApp. All rights reserved.</p>
                </div>
            </footer>
        </div>

        @include('components.admin.sidebar')
    </div>

    {{-- Section untuk script tambahan --}}
    @stack('scripts')
</body>

</html>