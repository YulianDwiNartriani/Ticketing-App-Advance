<x-layouts.admin title="Manajemen Tipe Tiket">
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
        <div class="flex items-center mb-4">
            <h1 class="text-3xl font-semibold">Manajemen Tipe Tiket</h1>
            <a href="{{ route('admin.ticket-types.create') }}" class="btn btn-primary ml-auto">
                Tambah Tipe Tiket
            </a>
        </div>

        <div class="overflow-x-auto rounded-box bg-white p-5 shadow-xs">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tipe Tiket</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ticketTypes as $index => $ticketType)
                        <tr>
                            <th>{{ $index + 1 }}</th>
                            <td>{{ $ticketType->nama }}</td>
                            <td>{{ $ticketType->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.ticket-types.edit', $ticketType->id) }}"
                                   class="btn btn-sm btn-primary mr-2">
                                    Edit
                                </a>
                                <button
                                    class="btn btn-sm bg-red-500 text-white"
                                    onclick="openDeleteModal(this)"
                                    data-id="{{ $ticketType->id }}"
                                >
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                Belum ada tipe tiket tersedia.
                            </td>
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

            <h3 class="text-lg font-bold mb-4">Hapus Tipe Tiket</h3>
            <p>Apakah Anda yakin ingin menghapus tipe tiket ini?</p>

            <div class="modal-action">
                <button class="btn btn-primary" type="submit">Hapus</button>
                <button class="btn" type="reset" onclick="delete_modal.close()">Batal</button>
            </div>
        </form>
    </dialog>

    <script>
        function openDeleteModal(button) {
            const id = button.dataset.id;
            const form = document.querySelector('#delete_modal form');

            form.action = `/admin/ticket-types/${id}`;
            delete_modal.showModal();
        }
    </script>
</x-layouts.admin>
