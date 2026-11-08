@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Daftar Customer" subtitle="Pelanggan yang mendaftar di top up game maupun yang tercatat dari pesanan travel." />

{{-- Ringkasan per sumber --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 lg:gap-4 mb-5 lg:mb-6">
    <x-admin.stat label="Total Customer" :value="$stats->total" icon="fa-solid fa-user-group" tone="slate" />
    <x-admin.stat label="Top Up Game" :value="$stats->topup" icon="fa-solid fa-gamepad" tone="blue" />
    <x-admin.stat label="Travel & Shuttle" :value="$stats->travel" icon="fa-solid fa-van-shuttle" tone="amber" />
    <x-admin.stat label="Google Review Card" :value="$stats->google_card" icon="fa-solid fa-qrcode" tone="emerald" />
</div>

<x-admin.card :padding="false">
    <x-admin.filter-bar :action="route('admin.customers.index')" name="q" :value="$search" placeholder="Cari nama, email, atau no. HP..."
        :active="(int) filled($source)" :reset="route('admin.customers.index')">
        <x-admin.select name="source" :options="collect(\App\Models\Customer::SOURCE_META)->map(fn ($m) => $m[0])->all()" :selected="$source" placeholder="Semua Sumber" class="col-span-2 lg:w-56" />
    </x-admin.filter-bar>

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
