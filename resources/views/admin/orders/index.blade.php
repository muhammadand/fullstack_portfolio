@extends('layouts.admin.app')

@section('content')
@php
    $activeLabel = $source ? \App\Models\Order::SOURCES[$source][0] : null;
    $filtered = $search || $status || $payment || $date;
    $emptyText = $filtered ? 'Tidak ada order yang cocok dengan filter.' : 'Belum ada order' . ($activeLabel ? ' ' . $activeLabel : '') . '.';
@endphp
<x-admin.page-header title="Order Produk Digital" subtitle="Pantau semua pesanan produk digital (top up game, pulsa, dan lainnya), status pembayaran, dan pengiriman.">
    @if(in_array($source, [null, \App\Models\Order::SOURCE_TOPUP_GAME], true))
    <x-admin.button variant="secondary" icon="fa-solid fa-arrow-up-right-from-square" :href="route('topup.index')" target="_blank">Buka Halaman Top Up</x-admin.button>
    @endif
</x-admin.page-header>

{{-- Tab per source order --}}
<nav class="mb-5 -mx-1 overflow-x-auto" aria-label="Jenis order">
    <div class="flex gap-1 px-1 border-b border-slate-200 min-w-max">
        @foreach($tabs as $tab)
        @php $active = $source === $tab['key']; @endphp
        <a href="{{ route('admin.orders.index', array_filter(['source' => $tab['key']])) }}"
           @class(['flex items-center gap-2 px-4 py-2.5 -mb-px border-b-2 text-sm font-medium whitespace-nowrap transition-colors',
                   'border-blue-600 text-blue-600' => $active,
                   'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' => ! $active])
           @if($active) aria-current="page" @endif>
            {{ $tab['label'] }}
            <span @class(['rounded-full px-2 py-0.5 text-xs font-semibold', 'bg-blue-50 text-blue-600' => $active, 'bg-slate-100 text-slate-500' => ! $active])>{{ number_format($tab['count']) }}</span>
        </a>
        @endforeach
    </div>
</nav>

{{-- Ringkasan (mengikuti tab aktif) --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Total Order', number_format($stats->total), 'fa-solid fa-receipt', 'bg-blue-50 text-blue-600', 'text-slate-900'],
        ['Belum Bayar', number_format($stats->unpaid), 'fa-solid fa-hourglass-half', 'bg-amber-50 text-amber-600', 'text-amber-600'],
        ['Perlu Diproses', number_format($stats->processing), 'fa-solid fa-bolt', 'bg-indigo-50 text-indigo-600', 'text-indigo-600'],
        ['Omzet Lunas', 'Rp ' . number_format($stats->revenue, 0, ',', '.'), 'fa-solid fa-wallet', 'bg-emerald-50 text-emerald-600', 'text-slate-900'],
    ] as [$label, $value, $icon, $iconCls, $valCls])
    <x-admin.card>
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl {{ $iconCls }} flex items-center justify-center text-lg shrink-0"><i class="{{ $icon }}"></i></div>
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $label }}</p>
                <p class="mt-0.5 text-xl font-semibold truncate {{ $valCls }}">{{ $value }}</p>
            </div>
        </div>
    </x-admin.card>
    @endforeach
</div>

<x-admin.card :padding="false">
    {{-- Toolbar pencarian & filter --}}
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col lg:flex-row gap-2 p-4 border-b border-slate-200">
        @if($source)<input type="hidden" name="source" value="{{ $source }}">@endif
        <div class="relative flex-1">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
            <x-admin.input name="search" :value="$search" placeholder="Cari no. order, nomor tujuan, email, produk, atau nama..." class="pl-9" />
        </div>
        <x-admin.select name="status" :options="collect(\App\Models\Order::STATUS_META)->map(fn ($m) => $m[0])->all()" :selected="$status" placeholder="Semua Status" class="lg:w-44" />
        <x-admin.select name="payment_status" :options="collect(\App\Models\Order::PAYMENT_META)->map(fn ($m) => $m[0])->all()" :selected="$payment" placeholder="Semua Pembayaran" class="lg:w-48" />
        <x-admin.input name="date" type="date" :value="$date" class="lg:w-40" />
        <div class="flex gap-2">
            <x-admin.button type="submit" variant="secondary">Filter</x-admin.button>
            @if($filtered)
            <x-admin.button variant="secondary" icon="fa-solid fa-xmark" :href="route('admin.orders.index', array_filter(['source' => $source]))">Reset</x-admin.button>
            @endif
        </div>
    </form>

    {{-- Desktop: tabel --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3 w-12">#</th>
                    <th class="px-4 py-3">Order</th>
                    <th class="px-4 py-3">Produk</th>
                    <th class="px-4 py-3">Tujuan</th>
                    <th class="px-4 py-3">Pelanggan</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Pembayaran</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @forelse($orders as $i => $order)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-4 py-3 text-slate-400">{{ $orders->firstItem() + $i }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <a href="{{ route('admin.orders.show', $order) }}" class="font-mono text-xs font-semibold text-blue-600 hover:underline">{{ $order->order_no }}</a>
                        <span class="block text-xs text-slate-400 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </td>
                    <td class="px-4 py-3 max-w-[220px]">
                        <span class="block font-medium text-slate-900 truncate" title="{{ $order->product_name }}">{{ $order->product_name }}</span>
                        @unless($source)<span class="block text-xs text-slate-400 mt-0.5">{{ $order->sourceLabel() }}</span>@endunless
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap font-mono text-xs text-slate-600">{{ $order->customer_no }}</td>
                    <td class="px-4 py-3 max-w-[200px]">
                        @if($order->affiliate)
                        <span class="block text-slate-900 truncate">{{ $order->affiliate->name }}</span>
                        <span class="block text-xs text-indigo-500"><i class="fa-solid fa-handshake"></i> Partner</span>
                        @elseif($order->customer)
                        <span class="block text-slate-900 truncate">{{ $order->customer->name }}</span>
                        @else
                        <span class="text-xs text-slate-400"><i class="fa-regular fa-user"></i> Tamu</span>
                        @endif
                        @if($order->email)<span class="block text-xs text-slate-400 truncate">{{ $order->email }}</span>@endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap font-mono text-xs font-semibold text-slate-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">@include('admin.orders.partials.badge', ['type' => 'payment', 'value' => $order->payment_status])</td>
                    <td class="px-4 py-3 whitespace-nowrap">@include('admin.orders.partials.badge', ['type' => 'status', 'value' => $order->status])</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end">
                            <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-eye" :href="route('admin.orders.show', $order)">Detail</x-admin.button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-12 text-center">
                        <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2"></i>
                        <p class="text-sm text-slate-500">{{ $emptyText }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile: kartu --}}
    <div class="md:hidden divide-y divide-slate-100">
        @forelse($orders as $i => $order)
        <a href="{{ route('admin.orders.show', $order) }}" class="block p-4 hover:bg-slate-50/70 transition-colors">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="font-mono text-xs font-semibold text-blue-600"><span class="text-slate-400 font-sans font-medium">#{{ $orders->firstItem() + $i }}</span> · {{ $order->order_no }}</p>
                    <p class="mt-1 text-sm font-medium text-slate-900 truncate">{{ $order->product_name }}</p>
                </div>
                @include('admin.orders.partials.badge', ['type' => 'status', 'value' => $order->status])
            </div>
            <div class="mt-2.5 flex items-center justify-between gap-3 text-xs">
                <span class="text-slate-400 truncate">{{ $order->created_at->format('d M Y, H:i') }} · {{ $order->affiliate?->name ?? $order->customer?->name ?? 'Tamu' }}@unless($source) · {{ $order->sourceLabel() }}@endunless</span>
                <span class="font-mono font-semibold text-slate-900 whitespace-nowrap">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="mt-2">@include('admin.orders.partials.badge', ['type' => 'payment', 'value' => $order->payment_status])</div>
        </a>
        @empty
        <div class="px-4 py-12 text-center">
            <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2"></i>
            <p class="text-sm text-slate-500">{{ $emptyText }}</p>
        </div>
        @endforelse
    </div>

    @if($orders->hasPages())
    <div class="px-4 py-3 border-t border-slate-200">
        {{ $orders->links('pagination::tailwind') }}
    </div>
    @endif
</x-admin.card>
@endsection
