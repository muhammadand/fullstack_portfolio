@extends('layouts.admin.app')

@section('content')
@php
    $rp = fn ($v) => 'Rp ' . number_format((float) $v, 0, ',', '.');
    $badge = ['amber' => 'yellow', 'emerald' => 'green', 'red' => 'red'];
@endphp

<x-admin.page-header title="Penarikan Saldo Customer"
    subtitle="Transfer manual ke e-wallet customer sebesar nominal diterima (sudah dipotong biaya admin {{ \App\Models\CustomerWithdrawal::FEE_PERCENT }}%), lalu tandai selesai." />

@if($errors->any())
<x-admin.alert type="error">{{ $errors->first() }}</x-admin.alert>
@endif

{{-- Tab status --}}
<nav class="mb-5 -mx-1 overflow-x-auto" aria-label="Status penarikan">
    <div class="flex gap-1 px-1 border-b border-slate-200 min-w-max">
        @foreach(\App\Models\CustomerWithdrawal::STATUS_META as $key => [$label])
        @php $active = $status === $key; @endphp
        <a href="{{ route('admin.customer_withdrawals.index', ['status' => $key]) }}" @if($active) aria-current="page" @endif
           @class(['flex items-center gap-2 px-4 py-2.5 -mb-px border-b-2 text-sm font-medium whitespace-nowrap',
                   'border-blue-600 text-blue-600' => $active, 'border-transparent text-slate-500 hover:text-slate-800' => ! $active])>
            {{ $label }}
            <span @class(['rounded-full px-2 py-0.5 text-xs font-semibold', 'bg-blue-50 text-blue-600' => $active, 'bg-slate-100 text-slate-500' => ! $active])>{{ number_format($counts[$key] ?? 0) }}</span>
        </a>
        @endforeach
    </div>
</nav>

@if($status === 'pending' && $pendingTotal > 0)
<x-admin.alert type="info">Total yang perlu ditransfer: <b>{{ $rp($pendingTotal) }}</b></x-admin.alert>
@endif

<x-admin.card :padding="false">
    <div class="divide-y divide-slate-100">
        @forelse($withdrawals as $w)
        <div class="p-4 flex flex-col lg:flex-row lg:items-start gap-4">
            <div class="flex-1 min-w-0 grid grid-cols-2 sm:grid-cols-4 gap-x-4 gap-y-2 text-sm">
                <div class="col-span-2">
                    <p class="font-mono text-xs font-semibold text-slate-500">{{ $w->withdrawal_no }} · {{ $w->created_at->format('d M Y, H:i') }}</p>
                    <p class="font-medium text-slate-900">{{ $w->customer?->name ?? '-' }}</p>
                    <p class="text-xs text-slate-400">{{ $w->customer?->email }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-slate-500">Transfer ke</p>
                    <p class="font-semibold text-slate-900">{{ $w->ewallet }} · <span class="font-mono">{{ $w->account_no }}</span>
                        <button type="button" class="ml-1 text-xs text-blue-600 hover:underline" onclick="navigator.clipboard.writeText({{ \Illuminate\Support\Js::from($w->account_no) }}).then(() => toast('success', 'Nomor disalin'))">Salin</button>
                    </p>
                    <p class="text-xs text-slate-500">a.n. {{ $w->account_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Ditarik</p>
                    <p class="font-mono text-slate-900">{{ $rp($w->amount) }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Biaya {{ \App\Models\CustomerWithdrawal::FEE_PERCENT }}%</p>
                    <p class="font-mono text-slate-900">{{ $rp($w->fee) }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-slate-500">Ditransfer ke customer</p>
                    <p class="font-mono text-lg font-bold text-emerald-600">{{ $rp($w->net_amount) }}</p>
                </div>
                @if(! $w->isPending())
                <div class="col-span-2 sm:col-span-4 text-xs text-slate-500">
                    <x-admin.badge :color="$badge[\App\Models\CustomerWithdrawal::STATUS_META[$w->status][1]] ?? 'slate'">{{ $w->statusLabel() }}</x-admin.badge>
                    {{ $w->processed_at?->format('d M Y, H:i') }} oleh {{ $w->processor?->name ?? '-' }}
                    @if($w->transfer_reference) · Ref: <span class="font-mono">{{ $w->transfer_reference }}</span>@endif
                    @if($w->admin_note) · {{ $w->admin_note }}@endif
                </div>
                @endif
            </div>

            @if($w->isPending())
            <div class="lg:w-72 shrink-0 space-y-2">
                <form method="POST" action="{{ route('admin.customer_withdrawals.complete', $w) }}" class="flex gap-2"
                      data-confirm-title="Tandai sudah ditransfer?" data-confirm="Pastikan {{ $rp($w->net_amount) }} sudah masuk ke {{ $w->ewallet }} {{ $w->account_no }}." data-confirm-button="Ya, selesai">
                    @csrf
                    <x-admin.input name="transfer_reference" placeholder="No. ref transfer (opsional)" class="text-xs" />
                    <x-admin.button type="submit" size="sm" icon="fa-solid fa-check">Selesai</x-admin.button>
                </form>
                <details class="text-xs">
                    <summary class="cursor-pointer text-red-600 font-medium">Tolak penarikan</summary>
                    <form method="POST" action="{{ route('admin.customer_withdrawals.reject', $w) }}" class="mt-2 flex gap-2"
                          data-confirm-title="Tolak penarikan?" data-confirm="Saldo {{ $rp($w->amount) }} akan dikembalikan ke customer." data-confirm-button="Ya, tolak" data-confirm-danger>
                        @csrf
                        <x-admin.input name="reason" required maxlength="255" placeholder="Alasan (dilihat customer)" class="text-xs" />
                        <x-admin.button type="submit" size="sm" variant="danger">Tolak</x-admin.button>
                    </form>
                </details>
            </div>
            @endif
        </div>
        @empty
        <div class="px-4 py-12 text-center text-sm text-slate-500">
            <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2 block"></i>
            Tidak ada penarikan {{ strtolower(\App\Models\CustomerWithdrawal::STATUS_META[$status][0]) }}.
        </div>
        @endforelse
    </div>

    @if($withdrawals->hasPages())
    <div class="px-4 py-3 border-t border-slate-200">{{ $withdrawals->links('pagination::tailwind') }}</div>
    @endif
</x-admin.card>
@endsection
