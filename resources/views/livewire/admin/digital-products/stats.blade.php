@php
$stats = $this->stats;
$cards = [
    ['label' => 'Total Produk', 'value' => number_format($stats['total'], 0, ',', '.'), 'icon' => 'fa-cubes-stacked', 'color' => 'text-blue-600 bg-blue-50'],
    ['label' => 'Aktif (Dijual)', 'value' => number_format($stats['active'], 0, ',', '.'), 'icon' => 'fa-circle-check', 'color' => 'text-emerald-600 bg-emerald-50'],
    ['label' => 'Belum Diaktifkan', 'value' => number_format($stats['inactive'], 0, ',', '.'), 'icon' => 'fa-hourglass-half', 'color' => 'text-amber-600 bg-amber-50'],
    ['label' => 'Hilang dari Katalog', 'value' => number_format($stats['missing'], 0, ',', '.'), 'icon' => 'fa-triangle-exclamation', 'color' => 'text-red-600 bg-red-50'],
    ['label' => 'Sync Terakhir', 'value' => $stats['last_synced_at']?->diffForHumans() ?? 'Belum pernah', 'icon' => 'fa-clock', 'color' => 'text-slate-600 bg-slate-100'],
];
@endphp

<div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-4">
    @foreach($cards as $card)
    <x-admin.card>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $card['color'] }}">
                <i class="fa-solid {{ $card['icon'] }}"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-500">{{ $card['label'] }}</p>
                <p class="text-base font-bold text-slate-900 truncate">{{ $card['value'] }}</p>
            </div>
        </div>
    </x-admin.card>
    @endforeach
</div>

<x-admin.card title="Level Harga" icon="fa-solid fa-tags" class="mb-4">
    <div class="flex flex-wrap gap-2 text-sm">
        @foreach($this->levels as $level)
        <x-admin.badge :color="$level->is_default ? 'blue' : 'slate'">
            {{ $level->name }}: margin {{ $level->margin_type === 'percent' ? rtrim(rtrim(number_format($level->margin_value, 2, ',', '.'), '0'), ',') . '%' : 'Rp ' . number_format($level->margin_value, 0, ',', '.') }}
        </x-admin.badge>
        @endforeach
    </div>
    <p class="text-xs text-slate-400 mt-2">Harga jual = modal + margin level, kecuali ada override manual per produk (menu Edit).</p>
</x-admin.card>
