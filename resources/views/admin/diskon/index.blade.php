<x-layouts.admin title="Manajemen Diskon">
    @if (session('success'))
        <div class="toast toast-bottom toast-center z-50">
            <div class="alert alert-success text-white">
                <span>{{ session('success') }}</span>
            </div>
        </div>

        <script>
            setTimeout(() => {
                document.querySelector('.toast')?.remove()
            }, 3000)
        </script>
    @endif

    <div class="container mx-auto p-6 lg:p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl lg:text-3xl font-black text-gray-900 tracking-tight">Manajemen Diskon</h1>
            <a href="{{ route('admin.diskons.create') }}" class="btn btn-primary btn-sm lg:btn-md">Tambah Diskon</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[11px] font-semibold text-gray-400 uppercase tracking-wider bg-gray-50/50">
                            <th class="py-3 px-4 w-12">No</th>
                            <th class="py-3 px-4">Nama Diskon</th>
                            <th class="py-3 px-4">Nilai</th>
                            <th class="py-3 px-4">Mulai</th>
                            <th class="py-3 px-4">Berakhir</th>
                            <th class="py-3 px-4">Aktif</th>
                            <th class="py-3 px-4">Event</th>
                            <th class="py-3 px-4">Dibuat pada</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs">
                        @forelse ($diskons as $index => $diskon)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3 px-4 font-bold text-gray-700">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 font-semibold text-gray-900">{{ $diskon->nama }}</td>
                                <td class="py-3 px-4 font-bold text-blue-600">{{ $diskon->nilai }}%</td>
                                <td class="py-3 px-4 text-gray-600 whitespace-nowrap">{{ $diskon->mulai_at->format('d M Y H:i') }}</td>
                                <td class="py-3 px-4 text-gray-600 whitespace-nowrap">{{ $diskon->berakhir_at->format('d M Y H:i') }}</td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    @if ($diskon->aktif)
                                        <span class="px-2 py-0.5 text-[10px] font-bold text-green-700 bg-green-50 rounded-md">Aktif</span>
                                    @else
                                        <span class="px-2 py-0.5 text-[10px] font-bold text-red-700 bg-red-50 rounded-md">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if ($diskon->event)
                                        <span class="px-2 py-0.5 text-[10px] font-bold text-blue-600 bg-blue-50 rounded-md max-w-xs truncate inline-block" title="{{ $diskon->event->judul }}">
                                            {{ $diskon->event->judul }}
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 text-[10px] font-medium text-gray-500 bg-gray-100 rounded-md">
                                            Semua Event
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-gray-500 whitespace-nowrap">{{ $diskon->created_at->format('d M Y H:i') }}</td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.diskons.show', $diskon->id) }}" class="px-2.5 py-1 text-[11px] font-medium bg-blue-600 text-white rounded hover:bg-blue-700 transition">Detail</a>
                                        <a href="{{ route('admin.diskons.edit', $diskon->id) }}" class="px-2.5 py-1 text-[11px] font-medium bg-amber-500 text-white rounded hover:bg-amber-600 transition">Edit</a>
                                        <button type="button" class="px-2.5 py-1 text-[11px] font-medium bg-red-500 text-white rounded hover:bg-red-600 transition" onclick="openDeleteModal(this)" data-id="{{ $diskon->id }}">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-gray-400 text-xs">Belum ada data diskon tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <dialog id="delete_modal" class="modal">
        <form method="POST" class="modal-box">
            @csrf
            @method('DELETE')

            <h3 class="text-lg font-bold mb-2">Hapus Diskon</h3>
            <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus diskon ini?</p>
            <div class="modal-action mt-4">
                <button class="btn btn-error btn-sm text-white" type="submit">Hapus</button>
                <button class="btn btn-sm" onclick="delete_modal.close(); return false;" type="button">Batal</button>
            </div>
        </form>
    </dialog>

    <script>
        function openDeleteModal(button) {
            const id = button.dataset.id;
            const form = document.querySelector('#delete_modal form');

            // Set action dengan parameter ID
            form.action = `/admin/diskons/${id}`;

            delete_modal.showModal();
        }
    </script>
</x-layouts.admin>