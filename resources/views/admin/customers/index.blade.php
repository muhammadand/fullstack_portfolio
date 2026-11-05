@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Daftar Customer" subtitle="Pelanggan yang mendaftar di top up game maupun yang tercatat dari pesanan travel." />

{{-- Ringkasan per sumber --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Total Customer', $stats->total, 'fa-solid fa-user-group', 'bg-slate-100 text-slate-600'],
        ['Top Up Game', $stats->topup, 'fa-solid fa-gamepad', 'bg-blue-50 text-blue-600'],
        ['Travel & Shuttle', $stats->travel, 'fa-solid fa-van-shuttle', 'bg-orange-50 text-orange-600'],
        ['Google Review Card', $stats->google_card, 'fa-solid fa-qrcode', 'bg-emerald-50 text-emerald-600'],
    ] as [$label, $value, $icon, $iconCls])
    <x-admin.card>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ $iconCls }} flex items-center justify-center shrink-0"><i class="{{ $icon }}"></i></div>
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 truncate">{{ $label }}</p>
                <p class="mt-0.5 text-xl font-semibold text-slate-900">{{ number_format($value) }}</p>
            </div>
        </div>
    </x-admin.card>
    @endforeach
</div>

<x-admin.card :padding="false">
    <form method="GET" action="{{ route('admin.customers.index') }}" class="flex flex-col sm:flex-row gap-2 p-4 border-b border-slate-200">
        <div class="relative flex-1 sm:max-w-sm">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
            <x-admin.input name="q" :value="$search" placeholder="Cari nama, email, atau no. HP..." class="pl-9" />
        </div>
        <x-admin.select name="source" :options="collect(\App\Models\Customer::SOURCE_META)->map(fn ($m) => $m[0])->all()" :selected="$source" placeholder="Semua Sumber" class="sm:w-56" />
        <div class="flex gap-2">
            <x-admin.button type="submit" variant="secondary">Cari</x-admin.button>
            @if($search || $source)
            <x-admin.button variant="secondary" icon="fa-solid fa-xmark" :href="route('admin.customers.index')">Reset</x-admin.button>
            @endif
        </div>
    </form>

    {{-- Desktop: tabel --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3 w-12">#</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">No. HP</th>
                    <th class="px-4 py-3">Sumber</th>
                    <th class="px-4 py-3">Poin</th>
                    <th class="px-4 py-3">Order Top Up</th>
                    <th class="px-4 py-3">Total Belanja</th>
                    <th class="px-4 py-3">Bergabung</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @forelse($customers as $i => $c)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-4 py-3 text-slate-400">{{ $customers->firstItem() + $i }}</td>
                    <td class="px-4 py-3 max-w-xs">
                        <a href="{{ route('admin.customers.show', $c->id) }}" class="block font-medium text-slate-900 hover:text-blue-600 truncate" title="{{ $c->name }}">{{ $c->name }}</a>
                        <span class="block text-xs text-slate-500 truncate">{{ $c->email ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap font-mono text-xs text-slate-600">{{ $c->phone ?? '-' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @include('admin.customers.partials.source-badge', ['source' => $c->source])
                        @unless($c->has_account)<span class="block text-[11px] text-slate-400 mt-0.5">Belum punya akun</span>@endunless
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-900">{{ number_format($c->points) }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ number_format($c->orders_count) }}
                        @if($c->bookings_count)<span class="text-xs text-slate-400"> · {{ $c->bookings_count }} travel</span>@endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap font-mono text-xs font-semibold text-slate-900">Rp {{ number_format($c->total_spent ?? 0, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-xs text-slate-500">{{ $c->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end">
                            <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-eye" :href="route('admin.customers.show', $c->id)">Detail</x-admin.button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-12 text-center">
                        <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2"></i>
                        <p class="text-sm text-slate-500">{{ ($search || $source) ? 'Tidak ada customer yang cocok dengan pencarian.' : 'Belum ada customer.' }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile: kartu --}}
    <div class="md:hidden divide-y divide-slate-100">
        @forelse($customers as $i => $c)
        <a href="{{ route('admin.customers.show', $c->id) }}" class="block p-4 hover:bg-slate-50/70 transition-colors">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-slate-900 truncate"><span class="text-slate-400">#{{ $customers->firstItem() + $i }}</span> · {{ $c->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ $c->email ?? $c->phone ?? '-' }}</p>
                </div>
                @include('admin.customers.partials.source-badge', ['source' => $c->source])
            </div>
            <div class="mt-2.5 flex items-center justify-between text-xs text-slate-500">
                <span>{{ number_format($c->points) }} poin · {{ $c->orders_count }} order</span>
                <span class="font-mono font-semibold text-slate-900">Rp {{ number_format($c->total_spent ?? 0, 0, ',', '.') }}</span>
            </div>
        </a>
        @empty
        <div class="px-4 py-12 text-center">
            <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2"></i>
            <p class="text-sm text-slate-500">Belum ada customer.</p>
        </div>
        @endforelse
    </div>

    @if($customers->hasPages())
    <div class="px-4 py-3 border-t border-slate-200">
        {{ $customers->links('pagination::tailwind') }}
    </div>
    @endif
</x-admin.card>
@endsection
