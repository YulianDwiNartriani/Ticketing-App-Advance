<x-layouts.admin title="Detail Diskon">
    <div class="container mx-auto p-10">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-6">Detail Diskon</h2>

                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700">Nama Diskon</p>
                    <p class="text-lg font-semibold">{{ $diskon->nama }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700">Nilai Diskon</p>
                    <p class="text-lg font-semibold">{{ $diskon->nilai }} %</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700">Dimulai</p>
                    <p class="text-lg font-semibold">{{ $diskon->mulai_at->format('d M Y H:i') }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700">Berakhir</p>
                    <p class="text-lg font-semibold">{{ $diskon->berakhir_at->format('d M Y H:i') }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700">Aktif</p>
                    <p class="text-lg font-semibold">
                        @if ($diskon->aktif)
                            <span class="text-green-600">Aktif</span>
                        @else
                            <span class="text-red-600">Nonaktif</span>
                        @endif
                    </p>

                </div>
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700">Dibuat pada</p>
                    <p class="text-gray-600">{{ $diskon->created_at->format('d M Y H:i:s') }}</p>
                </div>

                <div class="card-actions justify-end mt-6">
                    <a href="{{ route('admin.diskons.index') }}" class="btn btn-ghost">Kembali</a>
                    <a href="{{ route('admin.diskons.edit', $diskon->id) }}" class="btn btn-primary">Edit</a>
                    <button class="btn bg-red-500 text-white" onclick="openDeleteModal(this)"
                        data-id="{{ $diskon->id }}">Hapus</button>
                </div>
            </div>
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
                <button class="btn btn-primary" type="submit">Hapus</button>
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

