@extends('layouts.admin.app')

@section('content')
@php
    $profit = (float) $order->price - (float) $order->cost_price;
    $steps = [
        ['Order dibuat', $order->created_at, 'fa-solid fa-cart-shopping', true],
        ['Pembayaran diterima', $order->paid_at, 'fa-solid fa-circle-check', (bool) $order->paid_at],
        [$order->source === \App\Models\Order::SOURCE_TOPUP_GAME ? 'Item terkirim ke akun game' : 'Produk terkirim ke nomor tujuan', $order->completed_at, 'fa-solid fa-gem', (bool) $order->completed_at],
    ];
    if ($order->refunded_at) {
        $steps[] = ['Saldo dikembalikan ke wallet partner', $order->refunded_at, 'fa-solid fa-rotate-left', true];
    }
    $eventLabels = [
        'order.created' => 'Order dibuat', 'wallet.debited' => 'Saldo wallet dipotong', 'wallet.refunded' => 'Saldo dikembalikan',
        'wallet.refund_failed' => 'Refund GAGAL', 'provider.sent' => 'Dikirim ke Digiflazz', 'provider.send_failed' => 'Gagal kirim ke Digiflazz',
        'provider.result' => 'Hasil dari Digiflazz', 'notification.sent' => 'Email terkirim', 'notification.failed' => 'Email gagal',
    ];
    $dt = 'text-xs font-semibold uppercase tracking-wider text-slate-400';
@endphp

<x-admin.page-header :title="'Order ' . $order->order_no" :subtitle="$order->sourceLabel() . ' · Dibuat ' . $order->created_at->translatedFormat('d F Y, H:i')" :back="route('admin.orders.index', ['source' => $order->source])">
    @include('admin.orders.partials.badge', ['type' => 'status', 'value' => $order->status])
    @include('admin.orders.partials.badge', ['type' => 'payment', 'value' => $order->payment_status])
</x-admin.page-header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <div class="lg:col-span-2 space-y-5">

        <x-admin.card title="Produk & Tujuan" icon="fa-solid fa-gem">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                <div><dt class="{{ $dt }}">Jenis Order</dt><dd class="mt-1 font-medium text-slate-900">{{ $order->sourceLabel() }}</dd></div>
                <div><dt class="{{ $dt }}">Produk</dt><dd class="mt-1 font-medium text-slate-900">{{ $order->product_name }}</dd></div>
                <div><dt class="{{ $dt }}">Brand</dt><dd class="mt-1 font-medium text-slate-900">{{ $order->digitalProduct?->brand?->name ?? '-' }}</dd></div>
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
                <div class="flex justify-between gap-3 border-t border-slate-100 pt-2.5"><dt class="text-slate-500">Metode</dt><dd class="text-slate-900">{{ $order->isWalletPayment() ? 'Saldo Wallet' : strtoupper($order->payment_method ?? '-') }}</dd></div>
                <div><dt class="text-slate-500">Ref. pembayaran</dt><dd class="mt-0.5 font-mono text-xs text-slate-700 break-all">{{ $order->payment_reference ?? '-' }}</dd></div>
                @if($order->refunded_at)
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Refund</dt><dd class="text-emerald-600">{{ $order->refunded_at->format('d M Y, H:i') }}</dd></div>
                @endif
                @if($order->expires_at && ! $order->isPaid())
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Batas bayar</dt><dd class="text-slate-900">{{ $order->expires_at->format('d M Y, H:i') }}</dd></div>
                @endif
            </dl>
        </x-admin.card>

        <x-admin.card :title="$order->affiliate ? 'Partner' : 'Pelanggan'" :icon="$order->affiliate ? 'fa-solid fa-handshake' : 'fa-solid fa-user'">
            <div class="space-y-2 text-sm">
                @if($order->affiliate)
                <p class="font-semibold text-slate-900">{{ $order->affiliate->name }}</p>
                <p class="text-slate-500">{{ $order->affiliate->email }}</p>
                <p class="text-xs text-slate-400">Kode partner: <span class="font-mono">{{ $order->affiliate->affiliate_code }}</span></p>
                @elseif($order->customer)
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

@if($events->isNotEmpty())
<x-admin.card title="Jejak Audit" icon="fa-solid fa-shield-halved" class="mt-5">
    <div class="mb-3">
        @if($chainValid)
        <x-admin.badge color="green"><i class="fa-solid fa-lock"></i> Rantai hash utuh</x-admin.badge>
        @else
        <x-admin.badge color="red"><i class="fa-solid fa-triangle-exclamation"></i> Rantai hash tidak valid, data audit mungkin diubah</x-admin.badge>
        @endif
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-3 py-2">Waktu</th>
                    <th class="px-3 py-2">Kejadian</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Nominal</th>
                    <th class="px-3 py-2">Pelaku</th>
                    <th class="px-3 py-2">IP</th>
                    <th class="px-3 py-2">Hash</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @foreach($events as $event)
                <tr data-event="{{ $event->event }}">
                    <td class="px-3 py-2 whitespace-nowrap text-xs">{{ $event->created_at->format('d M Y, H:i:s') }}</td>
                    <td class="px-3 py-2">
                        <span @class(['font-medium', 'text-red-600' => str_ends_with($event->event, 'failed'), 'text-slate-900' => ! str_ends_with($event->event, 'failed')])>{{ $eventLabels[$event->event] ?? $event->event }}</span>
                        @if($event->context)
                        <details class="mt-1"><summary class="cursor-pointer text-xs text-slate-400">Detail</summary>
                            <pre class="mt-1 max-w-md whitespace-pre-wrap break-all rounded bg-slate-50 p-2 text-[11px] text-slate-600">{{ json_encode($event->context, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
                        </details>
                        @endif
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-xs">{{ $event->status_from || $event->status_to ? ($event->status_from ?? '-') . ' → ' . ($event->status_to ?? '-') : '-' }}</td>
                    <td class="px-3 py-2 whitespace-nowrap font-mono text-xs">{{ $event->amount !== null ? 'Rp ' . number_format($event->amount, 0, ',', '.') : '-' }}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-xs">{{ $event->actor_type }}{{ $event->actor_id ? ' #' . $event->actor_id : '' }}</td>
                    <td class="px-3 py-2 whitespace-nowrap font-mono text-xs">{{ $event->ip_address ?? '-' }}</td>
                    <td class="px-3 py-2 font-mono text-[11px] text-slate-400" title="{{ $event->hash }}">{{ \Illuminate\Support\Str::limit($event->hash, 12, '…') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin.card>
@endif
@endsection
