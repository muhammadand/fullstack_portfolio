@extends('layouts.app')

@section('meta_tags')
<title>Akun Saya | Scalify Intelligence</title>
<meta name="robots" content="noindex, nofollow" />
@endsection

@section('content')
@php
    $statusStyle = [
        'success'    => ['Berhasil', 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30'],
        'processing' => ['Diproses', 'bg-blue-500/20 text-blue-300 border-blue-500/30'],
        'pending'    => ['Menunggu', 'bg-amber-500/20 text-amber-300 border-amber-500/30'],
    ];
    $fallback = ['Gagal', 'bg-red-500/20 text-red-300 border-red-500/30'];
    $wdStyle = [
        'pending'   => 'bg-amber-500/20 text-amber-300 border-amber-500/30',
        'completed' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
        'rejected'  => 'bg-red-500/20 text-red-300 border-red-500/30',
    ];
    $rp = fn ($v) => 'Rp ' . number_format((float) $v, 0, ',', '.');
@endphp

{{-- Mobile-first: satu kolom, lebar maks. ponsel besar di desktop. --}}
<div class="max-w-md mx-auto px-4 pt-6 pb-16" x-data="{ tab: 'orders' }">

    @if(session('success'))
    <div class="mb-4 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200" role="status">
        <i class="fa-solid fa-circle-check mr-1.5"></i>{{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200" role="alert">
        <i class="fa-solid fa-circle-exclamation mr-1.5"></i>{{ session('error') }}
    </div>
    @endif

    {{-- Profil singkat --}}
    <div class="flex items-center justify-between gap-3 mb-4">
        <div class="min-w-0">
            <p class="text-xs text-white/45">Halo,</p>
            <h1 class="font-display font-bold text-lg text-white truncate">{{ $customer->name }}</h1>
        </div>
        <form method="POST" action="{{ route('customer.logout') }}">
            @csrf
            <button type="submit" class="text-xs text-white/50 hover:text-white px-3 py-2 rounded-lg border border-white/10"><i class="fa-solid fa-arrow-right-from-bracket mr-1"></i>Keluar</button>
        </form>
    </div>

    {{-- Kartu saldo --}}
    <div class="rounded-2xl p-5 bg-gradient-to-br from-blue-600/30 via-indigo-600/20 to-transparent border border-white/10">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-[11px] uppercase tracking-wider text-white/50">Saldo</p>
                <p class="mt-1 text-3xl font-black text-white" data-balance>{{ $rp($customer->balance) }}</p>
            </div>
            <div class="text-right">
                <p class="text-[11px] uppercase tracking-wider text-white/50">Poin</p>
                <p class="mt-1 text-lg font-black text-brand-accent">{{ number_format($customer->points, 0, ',', '.') }}</p>
            </div>
        </div>
        <p class="mt-2 text-[11px] text-white/45">Saldo berasal dari pengembalian dana pesanan yang gagal.</p>

        @if($pendingWithdrawal)
        <div class="mt-4 rounded-xl bg-amber-500/10 border border-amber-500/30 px-3 py-2.5 text-xs text-amber-200">
            <i class="fa-solid fa-hourglass-half mr-1"></i>
            Penarikan {{ $rp($pendingWithdrawal->net_amount) }} ke {{ $pendingWithdrawal->ewallet }} sedang diproses admin.
        </div>
        @elseif($customer->balance >= \App\Models\CustomerWithdrawal::MIN_AMOUNT)
        <a href="{{ route('customer.withdraw') }}" class="mt-4 flex items-center justify-center gap-2 w-full py-3 rounded-xl bg-white text-slate-900 text-sm font-bold active:scale-[0.98] transition">
            <i class="fa-solid fa-money-bill-transfer"></i> Tarik ke E-Wallet
        </a>
        @else
        <p class="mt-4 text-[11px] text-white/40">Minimal penarikan {{ $rp(\App\Models\CustomerWithdrawal::MIN_AMOUNT) }}.</p>
        @endif
    </div>

    {{-- Tab --}}
    <div class="mt-6 grid grid-cols-3 gap-1 p-1 rounded-xl bg-white/[0.04] border border-white/10 text-xs font-semibold" role="tablist">
        @foreach(['orders' => 'Pesanan', 'balance' => 'Mutasi Saldo', 'withdrawals' => 'Penarikan'] as $key => $label)
        <button type="button" role="tab" @click="tab = '{{ $key }}'" :aria-selected="tab === '{{ $key }}'"
                :class="tab === '{{ $key }}' ? 'bg-white text-slate-900' : 'text-white/60'"
                class="py-2 rounded-lg transition-colors">{{ $label }}</button>
        @endforeach
    </div>

    {{-- Riwayat pesanan --}}
    <div class="mt-4 space-y-2.5" x-show="tab === 'orders'">
        @forelse($orders as $order)
        @php [$label, $cls] = $statusStyle[$order->status] ?? $fallback; @endphp
        <div class="rounded-xl bg-white/[0.04] border border-white/10 p-4">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ $order->product_name }}</p>
                    <p class="text-[11px] text-white/45 mt-0.5">{{ $order->order_no }} · {{ $order->created_at->translatedFormat('d M Y H:i') }}</p>
                </div>
                <span class="shrink-0 px-2 py-0.5 rounded-full border text-[10px] font-bold {{ $cls }}">{{ $label }}</span>
            </div>
            <div class="flex items-center justify-between mt-2 text-xs">
                <span class="text-white/50 truncate">Tujuan: {{ $order->customer_no }}</span>
                <span class="font-bold text-white">{{ $rp($order->total_amount) }}</span>
            </div>
            @if($order->refunded_at)
            <p class="mt-2 text-[11px] text-emerald-300"><i class="fa-solid fa-rotate-left mr-1"></i>Dana dikembalikan ke saldo</p>
            @endif
        </div>
        @empty
        <div class="rounded-xl border border-dashed border-white/15 p-8 text-center">
            <p class="text-sm text-white/60">Belum ada pesanan.</p>
            <a href="{{ route('topup.index') }}" class="inline-block mt-3 text-xs font-bold text-brand-accent hover:underline">Mulai top up</a>
        </div>
        @endforelse
        <div class="pt-2">{{ $orders->links() }}</div>
    </div>

    {{-- Mutasi saldo --}}
    <div class="mt-4 space-y-2" x-show="tab === 'balance'" x-cloak>
        @forelse($mutations as $m)
        <div class="flex items-center justify-between gap-3 rounded-xl bg-white/[0.04] border border-white/10 px-4 py-3">
            <div class="min-w-0">
                <p class="text-sm text-white truncate">{{ $m->label() }}</p>
                <p class="text-[11px] text-white/40">{{ $m->created_at->translatedFormat('d M Y H:i') }}</p>
            </div>
            <span class="shrink-0 text-sm font-bold {{ $m->type === 'CREDIT' ? 'text-emerald-300' : 'text-white' }}">{{ $m->type === 'CREDIT' ? '+' : '−' }}{{ $rp($m->amount) }}</span>
        </div>
        @empty
        <p class="text-center text-sm text-white/50 py-8">Belum ada mutasi saldo.</p>
        @endforelse
    </div>

    {{-- Penarikan --}}
    <div class="mt-4 space-y-2" x-show="tab === 'withdrawals'" x-cloak>
        @forelse($withdrawals as $w)
        <div class="rounded-xl bg-white/[0.04] border border-white/10 p-4">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white">{{ $w->ewallet }} · {{ $w->account_no }}</p>
                    <p class="text-[11px] text-white/45">{{ $w->withdrawal_no }} · {{ $w->created_at->translatedFormat('d M Y H:i') }}</p>
                </div>
                <span class="shrink-0 px-2 py-0.5 rounded-full border text-[10px] font-bold {{ $wdStyle[$w->status] ?? '' }}">{{ $w->statusLabel() }}</span>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-2 text-[11px]">
                <div><p class="text-white/40">Ditarik</p><p class="text-white font-semibold">{{ $rp($w->amount) }}</p></div>
                <div><p class="text-white/40">Biaya {{ \App\Models\CustomerWithdrawal::FEE_PERCENT }}%</p><p class="text-white font-semibold">{{ $rp($w->fee) }}</p></div>
                <div><p class="text-white/40">Diterima</p><p class="text-emerald-300 font-semibold">{{ $rp($w->net_amount) }}</p></div>
            </div>
            @if($w->status === 'rejected' && $w->admin_note)
            <p class="mt-2 text-[11px] text-red-300">Alasan: {{ $w->admin_note }} (saldo sudah dikembalikan)</p>
            @endif
        </div>
        @empty
        <p class="text-center text-sm text-white/50 py-8">Belum ada penarikan.</p>
        @endforelse
    </div>
</div>
@endsection
