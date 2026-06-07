@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-white py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <h2 class="text-xl tracking-tight font-bold text-slate-900">Tambah Kategori Portfolio</h2>
            <p class="text-[13px] text-slate-500">Buat kategori baru untuk portfolio Anda</p>
        </div>

        <form action="{{ route('portfolio-categories.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-6">
            @csrf
            @include('portfolio_categories.form')

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('portfolio-categories.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-gray-700 hover:bg-slate-50 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md text-[13px] font-medium flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="bg-slate-900 text-white px-5 py-2.5 rounded-xl text-[13px] font-medium transition-all duration-300 hover:bg-slate-800 hover:-translate-y-0.5 hover:shadow-lg flex items-center justify-center">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
