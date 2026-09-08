<x-layouts.admin title="Manajemen Event">
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
            <h1 class="text-2xl lg:text-3xl font-black text-gray-900 tracking-tight">Manajemen Event</h1>
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm lg:btn-md">Tambah Event</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[11px] font-semibold text-gray-400 uppercase tracking-wider bg-gray-50/50">
                            <th class="py-3 px-4 w-12">No</th>
                            <th class="py-3 px-4">Judul</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Lokasi</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs">
                        @forelse ($events as $index => $event)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3 px-4 font-bold text-gray-700">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 font-semibold text-gray-900 max-w-xs truncate" title="{{ $event->judul }}">
                                    {{ $event->judul }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 text-[10px] font-bold text-blue-600 bg-blue-50 rounded-md">
                                        {{ $event->kategori->nama ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-gray-600 whitespace-nowrap">
                                    {{ $event->tanggal_waktu ? \Carbon\Carbon::parse($event->tanggal_waktu)->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="py-3 px-4 text-gray-600 max-w-xs truncate" title="{{ $event->lokasi }}">
                                    {{ $event->lokasi }}
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.events.show', $event->id) }}" class="px-2.5 py-1 text-[11px] font-medium bg-blue-500 text-white rounded hover:bg-cyan-600 transition">Detail</a>
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="px-2.5 py-1 text-[11px] font-medium bg-amber-500 text-white rounded hover:bg-amber-600 transition">Edit</a>
                                        <button type="button" class="px-2.5 py-1 text-[11px] font-medium bg-red-500 text-white rounded hover:bg-red-600 transition" onclick="openDeleteModal(this)" data-id="{{ $event->id }}">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400 text-xs">Tidak ada event tersedia.</td>
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

            <input type="hidden" name="event_id" id="delete_event_id">

            <h3 class="text-lg font-bold mb-2">Hapus Event</h3>
            <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus event ini?</p>
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
            document.getElementById("delete_event_id").value = id;

            // Set action dengan parameter ID
            form.action = `/admin/events/${id}`;

            delete_modal.showModal();
        }
    </script>
</x-layouts.admin>