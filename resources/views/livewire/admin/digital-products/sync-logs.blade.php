<x-admin.card title="Riwayat Sinkronisasi" icon="fa-solid fa-clock-rotate-left" :padding="false" class="mt-4">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3 w-12">No</th>
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Diterima</th>
                    <th class="px-4 py-3 text-right">Baru</th>
                    <th class="px-4 py-3 text-right">Diperbarui</th>
                    <th class="px-4 py-3 text-right">Modal Berubah</th>
                    <th class="px-4 py-3 text-right">Hilang</th>
                    <th class="px-4 py-3">Oleh</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @forelse($this->syncLogs as $log)
                <tr wire:key="log-{{ $log->id }}">
                    <td class="px-4 py-3 text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $log->started_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($log->status === 'success')
                        <x-admin.badge color="green">Berhasil</x-admin.badge>
                        @elseif($log->status === 'failed')
                        <x-admin.badge color="orange" title="{{ $log->error_message }}">Gagal</x-admin.badge>
                        @else
                        <x-admin.badge color="blue">Berjalan</x-admin.badge>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">{{ $log->total_received }}</td>
                    <td class="px-4 py-3 text-right">{{ $log->total_new }}</td>
                    <td class="px-4 py-3 text-right">{{ $log->total_updated }}</td>
                    <td class="px-4 py-3 text-right">{{ $log->total_cost_changed }}</td>
                    <td class="px-4 py-3 text-right">{{ $log->total_missing }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $log->user?->name ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-6 text-center text-xs text-slate-400">Belum ada riwayat sinkronisasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin.card>
