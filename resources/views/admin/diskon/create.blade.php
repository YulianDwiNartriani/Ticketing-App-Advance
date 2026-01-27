<x-layouts.admin title="Tambah Diskon Baru">
    <div class="container mx-auto p-10">
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-6">Tambah Diskon Baru</h2>

                <form action="{{ route('admin.diskons.store') }}" method="POST">
                    @csrf

                    <div class="form-control w-full mb-4">
                        <span class="label-text">Nama Diskon</span>
                            </label>
                            <input type="text"
                                name="nama"
                                value="{{ old('nama') }}"
                                placeholder="Contoh: Promo Akhir Tahun"
                                class="input input-bordered w-full @error('nama') input-error @enderror">
                            @error('nama')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Nilai Diskon (%)</span>
                            </label>
                            <input type="number"
                                name="nilai"
                                value="{{ old('nilai') }}"
                                min="1"
                                max="100"
                                placeholder="Contoh: 20"
                                class="input input-bordered w-full @error('nilai') input-error @enderror">
                            @error('nilai')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Mulai Berlaku</span>
                            </label>
                            <input type="datetime-local"
                                name="mulai_at"
                                value="{{ old('mulai_at') }}"
                                class="input input-bordered w-full @error('mulai_at') input-error @enderror">
                            @error('mulai_at')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Berakhir Pada</span>
                            </label>
                            <input type="datetime-local"
                                name="berakhir_at"
                                value="{{ old('berakhir_at') }}"
                                class="input input-bordered w-full @error('berakhir_at') input-error @enderror">
                            @error('berakhir_at')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- DISKON PER EVENT -->
                        <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Berlaku untuk Event</span>
                        </label>

                        <select name="event_id" class="select select-bordered w-full">
                            <option value="">Semua Event</option>
                            @foreach($events as $event)
                            <option value="{{ $event->id }}"
                                {{ old('event_id', $diskon->event_id ?? null) == $event->id ? 'selected' : '' }}>
                                {{ $event->judul }}
                            </option>
                            @endforeach
                        </select>
                        </div>


                        <div class="form-control w-full mb-4">
                            <label class="label cursor-pointer">
                                <input type="hidden" name="aktif" value="0">
                                <span class="label-text">Status Diskon</span>
                                <input type="checkbox"
                                    name="aktif"
                                    value="1"
                                    class="toggle toggle-success"
                                    {{ old('aktif', true) ? 'checked' : '' }}>
                            </label>
                        </div>

                    <div class="card-actions justify-end mt-6">
                        <a href="{{ route('admin.diskons.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>