@extends('layouts.admin.app')

@section('content')

{{-- Beranda versi HP: hal yang butuh tindakan + shortcut. Desktop memakai dashboard di bawah. --}}
@php
    $c = \App\Support\AdminMenu::counts();
    $actions = [
        ['Order diproses', $c['orders_processing'], 'fa-receipt', route('admin.orders.index', ['status' => 'processing']), 'blue'],
        ['Partner perlu approval', $c['partner_pending'], 'fa-user-clock', route('admin.affiliates.index', ['status' => 'pending']), 'amber'],
        ['Penarikan partner', $c['withdrawals_pending'], 'fa-money-bill-transfer', route('admin.withdrawals.index'), 'emerald'],
        ['Penarikan customer', $c['customer_withdrawals_pending'], 'fa-wallet', route('admin.customer_withdrawals.index'), 'emerald'],
    ];
    $tone = [
        'blue' => 'bg-blue-50 text-blue-600 border-blue-200', 'amber' => 'bg-amber-50 text-amber-600 border-amber-200',
        'emerald' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
    ];
    $shortcuts = collect([
        ['Order', 'fa-solid fa-receipt', 'admin.orders.index'],
        ['Cek Saldo', 'fa-solid fa-wallet', 'admin.ppob.index'],
        ['Produk Digital', 'fa-solid fa-cubes-stacked', 'admin.digital_products.index'],
        ['Customers', 'fa-solid fa-user-group', 'admin.customers.index'],
        ['Travel', 'fa-solid fa-van-shuttle', 'admin.travel_bookings.index'],
        ['Review Cards', 'fa-solid fa-qrcode', 'admin.review_cards.index'],
        ['Blogs', 'fa-solid fa-newspaper', 'blogs.index'],
        ['Semua Menu', 'fa-solid fa-grip', 'admin.menu'],
    ])->filter(fn ($s) => \Illuminate\Support\Facades\Route::has($s[2]));
@endphp
<div class="lg:hidden space-y-5 mb-8" data-mobile-home>
    <section>
        <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2.5">Perlu tindakan</h2>
        <div class="grid grid-cols-2 gap-2.5">
            @foreach($actions as [$label, $count, $icon, $href, $color])
            <a href="{{ $href }}" class="rounded-2xl border p-3.5 active:scale-[0.98] transition {{ $count > 0 ? $tone[$color] : 'bg-white border-slate-200 text-slate-400' }}">
                <div class="flex items-center justify-between">
                    <i class="fa-solid {{ $icon }}"></i>
                    @if($count > 0)<span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>@endif
                </div>
                <p class="mt-2 text-2xl font-bold {{ $count > 0 ? '' : 'text-slate-300' }}">{{ number_format($count) }}</p>
                <p class="text-[11px] font-medium {{ $count > 0 ? '' : 'text-slate-500' }}">{{ $label }}</p>
            </a>
            @endforeach
        </div>
    </section>

    <section>
        <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2.5">Menu cepat</h2>
        <div class="grid grid-cols-4 gap-2">
            @foreach($shortcuts as [$label, $icon, $routeName])
            <a href="{{ route($routeName) }}" class="flex flex-col items-center gap-1.5 rounded-xl py-2.5 active:bg-slate-100">
                <span class="w-11 h-11 rounded-2xl bg-white border border-slate-200 text-blue-600 flex items-center justify-center"><i class="{{ $icon }}"></i></span>
                <span class="text-[10px] font-medium text-slate-600 text-center leading-tight">{{ $label }}</span>
            </a>
            @endforeach
        </div>
    </section>

    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Statistik konten</p>
</div>

{{-- Page Intro Bar --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <p class="text-[10px] sm:text-xs text-slate-400 font-medium uppercase tracking-widest mb-0.5">Overview</p>
        <h2 class="text-slate-800 font-bold text-xl sm:text-lg leading-tight">Dashboard Analytics</h2>
    </div>
    <div class="flex items-center gap-2.5 w-full sm:w-auto">
        <span class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-medium text-slate-500">
            <i class="fa-regular fa-calendar text-slate-400"></i>
            {{ now()->format('d M Y') }}
        </span>
        <a href="{{ route('blogs.index') }}" class="w-full sm:w-auto flex justify-center items-center gap-1.5 px-4 py-2.5 sm:py-1.5 rounded-lg text-sm sm:text-xs font-semibold text-white shadow-sm" style="background: linear-gradient(90deg, #1E3A8A, #2563EB);">
            <i class="fa-solid fa-plus"></i> New Content
        </a>
    </div>
</div>

{{-- Stats Cards --}}
@include('dashboard.card')

{{-- Chart & Donut --}}
@include('dashboard.chart')

{{-- Top Lists --}}
@include('dashboard.popular')

@endsection
