<x-layouts.admin title="Manajemen Diskon">
    @if (session('success'))
        <div class="toast toast-bottom toast-center">
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
            </div>
        </div>

        <script>
            setTimeout(() => {
                document.querySelector('.toast')?.remove()
            }, 3000)
        </script>
    @endif

    <div class="container mx-auto p-10">
        <div class="flex">
            <h1 class="text-3xl font-semibold mb-4">Manajemen Diskon</h1>
            <a href="{{ route('admin.diskons.create') }}" class="btn btn-primary ml-auto">Tambah Diskon</a>
        </div>
        <div class="overflow-x-auto rounded-box bg-white p-5 shadow-xs">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Diskon</th>
                        <th>Nilai</th>
                        <th>Mulai</th>
                        <th>Berakhir</th>
                        <th>Aktif</th>
                        <th>Event</th>
                        <th>Dibuat pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($diskons as $index => $diskon)
                        <tr>
                            <th>{{ $index + 1 }}</th>
                            <td>{{ $diskon->nama }}</td>
                            <td>{{ $diskon->nilai }} %</td>
                            <td>{{ $diskon->mulai_at->format('d M Y H:i') }}</td>
                            <td>{{ $diskon->berakhir_at->format('d M Y H:i')}}</td>
                            <td>
                                @if ($diskon->aktif)
                                    <span class="text-green-600 font-semibold">Aktif</span>
                                @else
                                    <span class="text-red-600 font-semibold">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                @if ($diskon->event)
                                    <span class="badge badge-info">
                                        {{ $diskon->event->judul }}
                                    </span>
                                @else
                                    <span class="badge badge-ghost">
                                        Semua Event
                                    </span>
                                @endif
                            </td>

                            <td>{{ $diskon->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.diskons.show', $diskon->id) }}" class="btn btn-sm btn-info mr-2">Detail</a>
                                <a href="{{ route('admin.diskons.edit', $diskon->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
                                <button class="btn btn-sm bg-red-500 text-white" onclick="openDeleteModal(this)" data-id="{{ $diskon->id }}">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data diskon tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
     <!-- Delete Modal -->
    <dialog id="delete_modal" class="modal">
        <form method="POST" class="modal-box">
            @csrf
            @method('DELETE')

            <h3 class="text-lg font-bold mb-4">Hapus Diskon</h3>
            <p>Apakah Anda yakin ingin menghapus diskon ini?</p>
            <div class="modal-action">
                <button class="btn btn-primary" type="submit">Diskon</button>
                <button class="btn" onclick="delete_modal.close()" type="reset">Batal</button>
            </div>
        </form>
    </dialog>

    <script>
        function openDeleteModal(button) {
            const id = button.dataset.id;
            const form = document.querySelector('#delete_modal form');

            // Set action dengan parameter ID
            form.action = `/admin/diskons/${id}`

            delete_modal.showModal();
        }
    </script>

</x-layouts.admin>

