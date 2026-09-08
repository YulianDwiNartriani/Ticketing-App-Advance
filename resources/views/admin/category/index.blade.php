<x-layouts.admin title="Manajemen Kategori">
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
            <h1 class="text-2xl lg:text-3xl font-black text-gray-900 tracking-tight">Manajemen Kategori</h1>
            <button class="btn btn-primary btn-sm lg:btn-md" onclick="add_modal.showModal()">Tambah Kategori</button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[11px] font-semibold text-gray-400 uppercase tracking-wider bg-gray-50/50">
                            <th class="py-3 px-4 w-16">No</th>
                            <th class="py-3 px-4">Nama Kategori</th>
                            <th class="py-3 px-4 text-center w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs">
                        @forelse ($categories as $index => $category)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3 px-4 font-bold text-gray-700">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 font-semibold text-gray-900">{{ $category->nama }}</td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <button type="button" class="px-2.5 py-1 text-[11px] font-medium bg-amber-500 text-white rounded hover:bg-amber-600 transition" onclick="openEditModal(this)" data-id="{{ $category->id }}" data-nama="{{ $category->nama }}">Edit</button>
                                        <button type="button" class="px-2.5 py-1 text-[11px] font-medium bg-red-500 text-white rounded hover:bg-red-600 transition" onclick="openDeleteModal(this)" data-id="{{ $category->id }}">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-gray-400 text-xs">Tidak ada kategori tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <dialog id="add_modal" class="modal">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="modal-box">
            @csrf
            <h3 class="text-lg font-bold mb-3">Tambah Kategori</h3>
            <div class="form-control w-full mb-4">
                <label class="label mb-1">
                    <span class="label-text text-xs font-semibold text-gray-600">Nama Kategori</span>
                </label>
                <input type="text" placeholder="Masukkan nama kategori" class="input input-bordered input-sm lg:input-md w-full" name="nama" required />
            </div>
            <div class="modal-action mt-4">
                <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                <button class="btn btn-sm" onclick="add_modal.close(); return false;" type="button">Batal</button>
            </div>
        </form>
    </dialog>

    <!-- Edit Category Modal -->
    <dialog id="edit_modal" class="modal">
        <form method="POST" class="modal-box">
            @csrf
            @method('PUT')

            <input type="hidden" name="category_id" id="edit_category_id">

            <h3 class="text-lg font-bold mb-3">Edit Kategori</h3>
            <div class="form-control w-full mb-4">
                <label class="label mb-1">
                    <span class="label-text text-xs font-semibold text-gray-600">Nama Kategori</span>
                </label>
                <input type="text" placeholder="Masukkan nama kategori" class="input input-bordered input-sm lg:input-md w-full" id="edit_category_name" name="nama" required />
            </div>
            <div class="modal-action mt-4">
                <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                <button class="btn btn-sm" onclick="edit_modal.close(); return false;" type="button">Batal</button>
            </div>
        </form>
    </dialog>

    <!-- Delete Modal -->
    <dialog id="delete_modal" class="modal">
        <form method="POST" class="modal-box">
            @csrf
            @method('DELETE')

            <input type="hidden" name="category_id" id="delete_category_id">

            <h3 class="text-lg font-bold mb-2">Hapus Kategori</h3>
            <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus kategori ini?</p>
            <div class="modal-action mt-4">
                <button class="btn btn-error btn-sm text-white" type="submit">Hapus</button>
                <button class="btn btn-sm" onclick="delete_modal.close(); return false;" type="button">Batal</button>
            </div>
        </form>
    </dialog>

    <script>
        function openEditModal(button) {
            const name = button.dataset.nama;
            const id = button.dataset.id;
            const form = document.querySelector('#edit_modal form');
            
            document.getElementById("edit_category_name").value = name;
            document.getElementById("edit_category_id").value = id;

            // Set action dengan parameter ID
            form.action = `/admin/categories/${id}`;

            edit_modal.showModal();
        }

        function openDeleteModal(button) {
            const id = button.dataset.id;
            const form = document.querySelector('#delete_modal form');
            document.getElementById("delete_category_id").value = id;

            // Set action dengan parameter ID
            form.action = `/admin/categories/${id}`;

            delete_modal.showModal();
        }
    </script>
</x-layouts.admin>