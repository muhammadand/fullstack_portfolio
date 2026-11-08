@extends('layouts.admin.app')

@section('content')
@php $dt = 'text-xs font-semibold uppercase tracking-wider text-slate-400'; @endphp

<x-admin.page-header :title="$customer->name" :subtitle="'Bergabung ' . $customer->created_at->translatedFormat('d F Y')" :back="route('admin.customers.index')">
    @include('admin.customers.partials.source-badge', ['source' => $customer->source])
</x-admin.page-header>

{{-- Ringkasan --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 lg:gap-4 mb-4 lg:mb-6">
    <x-admin.stat label="Poin" :value="$customer->points" icon="fa-solid fa-gift" tone="amber" />
    <x-admin.stat label="Order Top Up" :value="$customer->orders_count" icon="fa-solid fa-receipt" tone="blue" />
    <x-admin.stat label="Total Belanja" :value="$customer->total_spent ?? 0" rupiah icon="fa-solid fa-wallet" tone="emerald" />
    <x-admin.stat label="Pesanan Travel" :value="$customer->bookings_count" icon="fa-solid fa-ticket" tone="indigo" />
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <x-admin.card title="Profil" icon="fa-solid fa-user">
        <dl class="space-y-4 text-sm">
            <div><dt class="{{ $dt }}">Nama</dt><dd class="mt-1 font-medium text-slate-900">{{ $customer->name }}</dd></div>
            <div><dt class="{{ $dt }}">Email</dt><dd class="mt-1 text-slate-900 break-all">{{ $customer->email ?? '-' }}</dd></div>
            <div><dt class="{{ $dt }}">No. HP</dt><dd class="mt-1 font-mono text-xs text-slate-900">{{ $customer->phone ?? '-' }}</dd></div>
            <div><dt class="{{ $dt }}">Sumber</dt><dd class="mt-1">@include('admin.customers.partials.source-badge', ['source' => $customer->source])</dd></div>
            <div><dt class="{{ $dt }}">Akun Login</dt><dd class="mt-1 text-slate-700">{{ $customer->password ? 'Punya akun (bisa login di web top up)' : 'Belum punya akun' }}</dd></div>
        </dl>
    </x-admin.card>

    <x-admin.card title="Order Top Up Terbaru" icon="fa-solid fa-receipt" :padding="false" class="lg:col-span-2">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Pembayaran</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="font-mono text-xs font-semibold text-blue-600 hover:underline">{{ $order->order_no }}</a>
                            <span class="block text-xs text-slate-400 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </td>
                        <td class="px-4 py-3 max-w-[200px]"><span class="block truncate text-slate-900">{{ $order->product_name }}</span></td>
                        <td class="px-4 py-3 whitespace-nowrap font-mono text-xs font-semibold text-slate-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">@include('admin.orders.partials.badge', ['type' => 'payment', 'value' => $order->payment_status])</td>
                        <td class="px-4 py-3 whitespace-nowrap">@include('admin.orders.partials.badge', ['type' => 'status', 'value' => $order->status])</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
                            <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2"></i>
                            <p class="text-sm text-slate-500">Belum ada order top up.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customer->orders_count > $orders->count())
        <div class="px-4 py-3 border-t border-slate-200 text-xs text-slate-500">Menampilkan {{ $orders->count() }} dari {{ $customer->orders_count }} order terbaru.</div>
        @endif
    </x-admin.card>
</div>
@endsection
