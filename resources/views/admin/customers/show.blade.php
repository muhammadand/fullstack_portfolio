@extends('layouts.admin.app')

@section('content')
@php $dt = 'text-xs font-semibold uppercase tracking-wider text-slate-400'; @endphp

<x-admin.page-header :title="$customer->name" :subtitle="'Bergabung ' . $customer->created_at->translatedFormat('d F Y')" :back="route('admin.customers.index')">
    @include('admin.customers.partials.source-badge', ['source' => $customer->source])
</x-admin.page-header>

{{-- Ringkasan --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Poin', number_format($customer->points), 'fa-solid fa-gift', 'bg-amber-50 text-amber-600'],
        ['Order Top Up', number_format($customer->orders_count), 'fa-solid fa-receipt', 'bg-blue-50 text-blue-600'],
        ['Total Belanja', 'Rp ' . number_format($customer->total_spent ?? 0, 0, ',', '.'), 'fa-solid fa-wallet', 'bg-emerald-50 text-emerald-600'],
        ['Pesanan Travel', number_format($customer->bookings_count), 'fa-solid fa-ticket', 'bg-indigo-50 text-indigo-600'],
    ] as [$label, $value, $icon, $iconCls])
    <x-admin.card>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ $iconCls }} flex items-center justify-center shrink-0"><i class="{{ $icon }}"></i></div>
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $label }}</p>
                <p class="mt-0.5 text-lg font-semibold text-slate-900 truncate">{{ $value }}</p>
            </div>
        </div>
    </x-admin.card>
    @endforeach
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
                            <a href="{{ route('admin.topup_orders.show', $order->id) }}" class="font-mono text-xs font-semibold text-blue-600 hover:underline">{{ $order->order_no }}</a>
                            <span class="block text-xs text-slate-400 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </td>
                        <td class="px-4 py-3 max-w-[200px]"><span class="block truncate text-slate-900">{{ $order->product_name }}</span></td>
                        <td class="px-4 py-3 whitespace-nowrap font-mono text-xs font-semibold text-slate-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">@include('admin.topup_orders.partials.badge', ['type' => 'payment', 'value' => $order->payment_status])</td>
                        <td class="px-4 py-3 whitespace-nowrap">@include('admin.topup_orders.partials.badge', ['type' => 'status', 'value' => $order->status])</td>
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
