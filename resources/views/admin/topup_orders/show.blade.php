@extends('layouts.admin.app')

@section('content')
@php
    $profit = (float) $order->price - (float) $order->cost_price;
    $steps = [
        ['Order dibuat', $order->created_at, 'fa-solid fa-cart-shopping', true],
        ['Pembayaran diterima', $order->paid_at, 'fa-solid fa-circle-check', (bool) $order->paid_at],
        ['Item terkirim ke akun game', $order->completed_at, 'fa-solid fa-gem', (bool) $order->completed_at],
    ];
    $dt = 'text-xs font-semibold uppercase tracking-wider text-slate-400';
@endphp

<x-admin.page-header :title="'Order ' . $order->order_no" :subtitle="'Dibuat ' . $order->created_at->translatedFormat('d F Y, H:i')" :back="route('admin.topup_orders.index')">
    @include('admin.topup_orders.partials.badge', ['type' => 'status', 'value' => $order->status])
    @include('admin.topup_orders.partials.badge', ['type' => 'payment', 'value' => $order->payment_status])
</x-admin.page-header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <div class="lg:col-span-2 space-y-5">

        <x-admin.card title="Produk & Tujuan" icon="fa-solid fa-gem">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                <div><dt class="{{ $dt }}">Produk</dt><dd class="mt-1 font-medium text-slate-900">{{ $order->product_name }}</dd></div>
                <div><dt class="{{ $dt }}">Game / Brand</dt><dd class="mt-1 font-medium text-slate-900">{{ $order->digitalProduct?->brand?->name ?? '-' }}</dd></div>
                <div><dt class="{{ $dt }}">SKU Supplier</dt><dd class="mt-1 font-mono text-xs text-slate-700 break-all">{{ $order->sku_code ?? '-' }}</dd></div>
                <div><dt class="{{ $dt }}">Tujuan Pengisian</dt><dd class="mt-1 font-mono text-slate-900 break-all">{{ $order->customer_no }}</dd></div>
                @foreach(($order->account_data ?? []) as $key => $val)
                <div><dt class="{{ $dt }}">{{ \Illuminate\Support\Str::headline($key) }}</dt><dd class="mt-1 font-mono text-slate-900">{{ $val }}</dd></div>
                @endforeach
                @if($order->notes)
                <div class="sm:col-span-2"><dt class="{{ $dt }}">Catatan Pembeli</dt><dd class="mt-1 rounded-lg bg-slate-50 p-3 text-slate-700">{{ $order->notes }}</dd></div>
                @endif
            </dl>
        </x-admin.card>

        <x-admin.card title="Pengiriman (Digiflazz)" icon="fa-solid fa-bolt">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                <div><dt class="{{ $dt }}">Ref ID Provider</dt><dd class="mt-1 font-mono text-xs text-slate-800 break-all">{{ $order->provider_ref_id ?? 'Belum dikirim' }}</dd></div>
                <div><dt class="{{ $dt }}">Serial Number / Voucher</dt><dd class="mt-1 font-mono text-xs text-slate-800 break-all">{{ $order->sn ?? '-' }}</dd></div>
                <div class="sm:col-span-2"><dt class="{{ $dt }}">Pesan Provider</dt><dd class="mt-1 text-slate-700">{{ $order->provider_message ?: '-' }}</dd></div>
            </dl>
        </x-admin.card>
    </div>

    <div class="space-y-5">

        <x-admin.card title="Pembayaran" icon="fa-solid fa-wallet">
            <dl class="space-y-2.5 text-sm">
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Harga jual</dt><dd class="font-mono text-slate-900">Rp {{ number_format($order->price, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Biaya admin</dt><dd class="font-mono text-slate-900">Rp {{ number_format($order->admin_fee, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between gap-3 border-t border-slate-100 pt-2.5"><dt class="font-semibold text-slate-900">Total</dt><dd class="font-mono font-semibold text-slate-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between gap-3 border-t border-dashed border-slate-200 pt-2.5"><dt class="text-slate-500">Harga modal</dt><dd class="font-mono text-slate-500">Rp {{ number_format($order->cost_price, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Estimasi laba</dt><dd class="font-mono font-semibold {{ $profit >= 0 ? 'text-emerald-600' : 'text-red-600' }}">Rp {{ number_format($profit, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between gap-3 border-t border-slate-100 pt-2.5"><dt class="text-slate-500">Metode</dt><dd class="uppercase text-slate-900">{{ $order->payment_method ?? '-' }}</dd></div>
                <div><dt class="text-slate-500">Ref. pembayaran</dt><dd class="mt-0.5 font-mono text-xs text-slate-700 break-all">{{ $order->payment_reference ?? '-' }}</dd></div>
                @if($order->expires_at && ! $order->isPaid())
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Batas bayar</dt><dd class="text-slate-900">{{ $order->expires_at->format('d M Y, H:i') }}</dd></div>
                @endif
            </dl>
        </x-admin.card>

        <x-admin.card title="Pelanggan" icon="fa-solid fa-user">
            <div class="space-y-2 text-sm">
                @if($order->customer)
                <a href="{{ route('admin.customers.show', $order->customer_id) }}" class="font-semibold text-blue-600 hover:underline">{{ $order->customer->name }}</a>
                <p class="text-slate-500">{{ $order->customer->email ?? '-' }}</p>
                @if($order->customer->phone)<p class="text-slate-500">{{ $order->customer->phone }}</p>@endif
                @else
                <p class="text-slate-500"><i class="fa-regular fa-user mr-1"></i> Tamu (tanpa akun)</p>
                @endif
                <div class="border-t border-slate-100 pt-2">
                    <p class="{{ $dt }}">Email struk</p>
                    <p class="mt-1 text-slate-900 break-all">{{ $order->email ?? 'Tidak diisi' }}</p>
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Riwayat Status" icon="fa-solid fa-timeline">
            <ol class="space-y-4">
                @foreach($steps as [$label, $time, $icon, $done])
                <li class="flex items-start gap-3">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 text-xs {{ $done ? 'bg-emerald-50 text-emerald-600 ring-1 ring-inset ring-emerald-600/20' : 'bg-slate-50 text-slate-300 ring-1 ring-inset ring-slate-200' }}"><i class="{{ $icon }}"></i></span>
                    <div>
                        <p class="text-sm font-medium {{ $done ? 'text-slate-900' : 'text-slate-400' }}">{{ $label }}</p>
                        <p class="text-xs text-slate-400">{{ $time ? $time->format('d M Y, H:i') : 'Menunggu' }}</p>
                    </div>
                </li>
                @endforeach
            </ol>
        </x-admin.card>
    </div>
</div>
@endsection
