<x-layouts.admin title="Detail Tipe Tiket">
    <div class="container mx-auto p-10">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-6">Detail Tipe Tiket</h2>

                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700">Nama Tipe Tiket</p>
                    <p class="text-lg font-semibold">{{ $ticketType->nama }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700">Dibuat pada</p>
                    <p class="text-gray-600">
                        {{ $ticketType->created_at->format('d M Y H:i:s') }}
                    </p>
                </div>

                <div class="mb-6">
                    <p class="text-sm font-medium text-gray-700">Terakhir diperbarui</p>
                    <p class="text-gray-600">
                        {{ $ticketType->updated_at->format('d M Y H:i:s') }}
                    </p>
                </div>

                <div class="card-actions justify-end mt-6">
                    <a href="{{ route('admin.ticket-types.index') }}" class="btn btn-ghost">
                        Kembali
                    </a>

                    <a href="{{ route('admin.ticket-types.edit', $ticketType->id) }}"
                       class="btn btn-primary">
                        Edit
                    </a>

                    <button
                        class="btn bg-red-500 text-white"
                        onclick="openDeleteModal(this)"
                        data-id="{{ $ticketType->id }}"
                    >
                        Hapus
                    </button>
                </div>
            </div>
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
