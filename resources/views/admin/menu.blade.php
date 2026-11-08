@extends('layouts.admin.app')

{{-- Semua menu admin dalam bentuk grid (tab "Menu" di bottom nav HP). Data dari App\Support\AdminMenu. --}}
@section('content')
@php
    $items = \App\Support\AdminMenu::items();
    $single = collect($items)->filter(fn ($m) => isset($m['route']) && ! isset($m['submenu']));
    $groups = collect($items)->filter(fn ($m) => isset($m['submenu']));
    $tile = 'flex flex-col items-center justify-center gap-2 rounded-2xl bg-white border border-slate-200 p-3 min-h-[88px] text-center active:scale-95 transition';
@endphp

<div class="space-y-6">
    <section>
        <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2.5">Umum</h2>
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-2.5">
            @foreach($single as $m)
            @continue(! \Illuminate\Support\Facades\Route::has($m['route']))
            <a href="{{ route($m['route']) }}" class="{{ $tile }}">
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"><i class="{{ $m['icon'] }}"></i></span>
                <span class="text-[11px] font-medium text-slate-700 leading-tight">{{ $m['label'] }}</span>
            </a>
            @endforeach
        </div>
    </section>

    @foreach($groups as $g)
    <section>
        <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2.5 flex items-center gap-1.5"><i class="{{ $g['icon'] ?? 'fa-solid fa-folder' }}"></i> {{ $g['label'] }}</h2>
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-2.5">
            @foreach($g['submenu'] as $m)
            @continue(! \Illuminate\Support\Facades\Route::has($m['route']))
            <a href="{{ route($m['route']) }}" class="{{ $tile }}">
                <span class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center"><i class="{{ $m['icon'] }}"></i></span>
                <span class="text-[11px] font-medium text-slate-700 leading-tight">{{ $m['label'] }}</span>
            </a>
            @endforeach
        </div>
    </section>
    @endforeach

    <section class="grid grid-cols-2 gap-2.5">
        <a href="{{ route('profile.edit') }}" class="flex items-center justify-center gap-2 rounded-xl bg-white border border-slate-200 py-3 text-sm font-medium text-slate-700"><i class="fa-solid fa-user-pen"></i> Profil</a>
        <form method="POST" action="{{ route('logout') }}" data-confirm="Keluar dari admin panel?">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl bg-white border border-red-200 py-3 text-sm font-medium text-red-600"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</button>
        </form>
    </section>
</div>
@endsection
