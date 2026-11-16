@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Payment Gateway" subtitle="Scalify Pay (QRIS) untuk top up game, isi saldo partner, travel, CV, dan Review Card." />

<x-admin.card :padding="false" class="mb-4 lg:mb-6">
    <div class="p-4 lg:p-5 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
            <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $mode === 'production' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                <i class="fa-solid {{ $mode === 'production' ? 'fa-circle-play' : 'fa-flask' }}"></i>
            </span>
            <div class="min-w-0">
                <p class="text-[11px] font-medium text-slate-500">Mode aktif</p>
                <p class="text-sm font-semibold {{ $mode === 'production' ? 'text-emerald-700' : 'text-amber-700' }}">{{ $mode === 'production' ? 'Production (pembayaran sungguhan)' : 'Sandbox (uji coba)' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.payment_gateway.mode') }}" class="shrink-0">
            @csrf
            <div class="grid grid-cols-2 rounded-lg bg-slate-100 p-0.5 text-xs font-semibold" role="radiogroup" aria-label="Mode Scalify Pay">
                @foreach(['sandbox' => ['Sandbox', 'fa-flask'], 'production' => ['Prod', 'fa-circle-play']] as $value => [$label, $icon])
                @php $active = $mode === $value; $ready = $modes[$value]['ready']; @endphp
                <button type="submit" name="mode" value="{{ $value }}" role="radio" aria-checked="{{ $active ? 'true' : 'false' }}"
                        @if($value === 'production') data-confirm-title="Pindah ke Production?" data-confirm="Semua pembayaran QRIS akan menagih uang sungguhan." data-confirm-button="Ya, pindah" data-confirm-danger @endif
                        @disabled($active || ! $ready)
                        title="{{ $ready ? ucfirst($value) : 'API key mode ini belum diisi di .env' }}"
                        @class(['inline-flex items-center justify-center gap-1 px-2.5 h-8 rounded-md transition-colors',
                                'bg-white shadow-xs ' . ($value === 'production' ? 'text-emerald-700' : 'text-amber-700') => $active,
                                'text-slate-500 hover:text-slate-800' => ! $active && $ready,
                                'text-slate-300 cursor-not-allowed' => ! $active && ! $ready])>
                    <i class="fa-solid {{ $icon }} text-[10px]"></i> {{ $label }}
                </button>
                @endforeach
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-slate-100 border-t border-slate-100">
        @foreach($modes as $m => $info)
        <div class="p-4 lg:p-5 min-w-0" data-mode="{{ $m }}">
            <div class="flex items-center justify-between gap-2">
                <p class="text-sm font-semibold text-slate-900">{{ $m === 'production' ? 'Production' : 'Sandbox' }}</p>
                @if($info['ready'])
                <x-admin.badge color="green">Key terpasang</x-admin.badge>
                @else
                <x-admin.badge color="yellow">Belum diisi</x-admin.badge>
                @endif
            </div>
            <dl class="mt-2 space-y-1.5 text-xs">
                <div class="flex justify-between gap-3"><dt class="text-slate-500">API key</dt><dd class="font-mono text-slate-700 truncate">{{ $info['key'] ?: '-' }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Base URL</dt><dd class="font-mono text-slate-700 truncate">{{ $info['url'] }}</dd></div>
            </dl>
            @unless($info['ready'])
            <p class="mt-2 text-[11px] text-amber-600">Isi <code class="break-all">{{ $info['env'] }}</code> di .env.</p>
            @endunless
        </div>
        @endforeach
    </div>
</x-admin.card>

<x-admin.card title="Riwayat perubahan mode" icon="fa-solid fa-clock-rotate-left">
    @forelse($logs as $log)
    <div class="flex items-center justify-between gap-3 py-2 text-xs border-b border-slate-100 last:border-0">
        <span class="text-slate-700">{{ $log->old_value ?? 'otomatis' }} → <b>{{ $log->new_value }}</b></span>
        <span class="text-slate-400 text-right">{{ $log->created_at->format('d M Y H:i') }} · {{ $log->user_email ?? 'system' }}</span>
    </div>
    @empty
    <p class="text-sm text-slate-400">Belum ada perubahan mode.</p>
    @endforelse
</x-admin.card>
@endsection
