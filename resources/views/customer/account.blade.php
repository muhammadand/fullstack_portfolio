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
@endphp
<div class="max-w-3xl mx-auto px-4 py-8 sm:py-12">
    <div class="rounded-2xl bg-white/[0.04] border border-white/10 p-5 flex items-center justify-between gap-4">
        <div class="min-w-0">
            <h1 class="font-display font-bold text-xl text-white truncate">{{ $customer->name }}</h1>
            <p class="text-xs text-white/50 truncate">{{ $customer->email }}</p>
        </div>
        <div class="text-right shrink-0">
            <span class="block text-[10px] uppercase tracking-wider text-white/40">Poin</span>
            <span class="text-lg font-black text-brand-accent">{{ number_format($customer->points, 0, ',', '.') }}</span>
        </div>
    </div>

    <h2 class="font-display font-bold text-white mt-8 mb-3">Riwayat Pesanan</h2>

    <div class="space-y-2.5">
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
                <span class="font-bold text-white">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
        @empty
        <div class="rounded-xl border border-dashed border-white/15 p-8 text-center">
            <p class="text-sm text-white/60">Belum ada pesanan.</p>
            <a href="{{ route('topup.index') }}" class="inline-block mt-3 text-xs font-bold text-brand-accent hover:underline">Mulai top up</a>
        </div>
        @endforelse
    </div>

    <div class="mt-5">{{ $orders->links() }}</div>
</div>
@endsection
