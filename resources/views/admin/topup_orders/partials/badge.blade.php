@php
    // Warna meta order (amber/emerald/...) dipetakan ke warna komponen <x-admin.badge>.
    $map = ['amber' => 'yellow', 'emerald' => 'green', 'blue' => 'blue', 'red' => 'red', 'slate' => 'slate'];
    $meta = ($type === 'payment' ? \App\Models\Order::PAYMENT_META : \App\Models\Order::STATUS_META)[$value] ?? [ucfirst((string) $value), 'slate'];
@endphp
<x-admin.badge :color="$map[$meta[1]] ?? 'slate'"><i class="fa-solid fa-circle text-[6px]"></i> {{ $meta[0] }}</x-admin.badge>
