@extends('layouts.admin.app')

@section('content')

{{-- Page Intro Bar --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-xs text-slate-400 font-medium uppercase tracking-widest mb-0.5">Overview</p>
        <h2 class="text-slate-800 font-bold text-lg leading-tight">Dashboard Analytics</h2>
    </div>
    <div class="flex items-center gap-2.5">
        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-medium text-slate-500">
            <i class="fa-regular fa-calendar text-slate-400"></i>
            {{ now()->format('d M Y') }}
        </span>
        <a href="{{ route('blogs.index') }}" class="flex items-center gap-1.5 px-4 py-1.5 rounded-lg text-xs font-semibold text-white" style="background: linear-gradient(90deg, #1E3A8A, #2563EB);">
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
