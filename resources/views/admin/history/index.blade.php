<x-layouts.admin title="History Pembelian">
    <div class="container mx-auto p-6 lg:p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl lg:text-3xl font-black text-gray-900 tracking-tight">History Pembelian</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-[11px] font-semibold text-gray-400 uppercase tracking-wider bg-gray-50/50">
                            <th class="py-3 px-4 w-12">No</th>
                            <th class="py-3 px-4">Nama Pembeli</th>
                            <th class="py-3 px-4">Event</th>
                            <th class="py-3 px-4">Tanggal Pembelian</th>
                            <th class="py-3 px-4">Total Harga</th>
                            <th class="py-3 px-4">Status Pembayaran</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs">
                        @forelse ($histories as $index => $history)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3 px-4 font-bold text-gray-700">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 font-semibold text-gray-900">{{ $history->user->name ?? '-' }}</td>
                                <td class="py-3 px-4 text-gray-600 max-w-xs truncate" title="{{ $history->event?->judul ?? '-' }}">
                                    {{ $history->event?->judul ?? '-' }}
                                </td>
                                <td class="py-3 px-4 text-gray-600 whitespace-nowrap">{{ $history->created_at->format('d M Y H:i') }}</td>
                                <td class="py-3 px-4 font-bold text-gray-900 whitespace-nowrap">Rp {{ number_format($history->total_bayar, 0, ',', '.') }}</td>
                                <!-- STATUS -->
                                <td class="py-3 px-4 whitespace-nowrap">
                                    @if ($history->status_pembayaran === 'paid')
                                        <span class="px-2 py-0.5 text-[10px] font-bold text-green-700 bg-green-50 rounded-md">Paid</span>
                                    @elseif ($history->status_pembayaran === 'cancelled')
                                        <span class="px-2 py-0.5 text-[10px] font-bold text-red-700 bg-red-50 rounded-md">Cancelled</span>
                                    @else
                                        <span class="px-2 py-0.5 text-[10px] font-bold text-amber-700 bg-amber-50 rounded-md">Pending</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.histories.show', $history->id) }}" class="px-2.5 py-1 text-[11px] font-medium bg-blue-600 text-white rounded hover:bg-blue-700 transition">Detail</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400 text-xs">Tidak ada history pembelian tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>