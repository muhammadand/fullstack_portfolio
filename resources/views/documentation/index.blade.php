@extends('layouts.admin.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-slate-800">Documentation</h2>
            <p class="text-slate-500 text-xs mt-1">Kelola foto dokumentasi Sobat Scalify</p>
        </div>
        <a href="{{ route('documentation.create') }}" class="flex items-center gap-2 bg-blue-900 text-white px-4 py-1.5 rounded-md text-sm font-medium shadow-sm hover:bg-blue-950 transition">
            <i class="fa-solid fa-plus text-[11px]"></i> Tambah Foto
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="mb-4 flex items-center gap-3 px-4 py-3 rounded-lg border text-sm font-medium bg-green-50 border-green-200 text-green-700">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 flex items-center gap-3 px-4 py-3 rounded-lg border text-sm font-medium bg-red-50 border-red-200 text-red-700">
        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
    </div>
    @endif

    {{-- Empty State --}}
    @if($documentation->isEmpty())
    <div class="flex flex-col items-center justify-center py-12 rounded-lg text-center bg-white border border-slate-200 shadow-sm">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-3 bg-blue-50 border border-blue-100">
            <i class="fa-solid fa-camera text-blue-500 text-xl"></i>
        </div>
        <p class="text-slate-700 font-medium mb-1 text-sm">Belum ada dokumentasi</p>
        <p class="text-slate-400 text-xs">Klik "Tambah Foto" untuk mulai mengunggah</p>
    </div>

    @else

    {{-- Stats --}}
    <div class="mb-4 flex items-center gap-2 text-[13px] text-slate-500 font-medium">
        <i class="fa-solid fa-images"></i>
        <span>{{ $documentation->count() }} foto tersimpan</span>
    </div>

    {{-- Photo Grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($documentation as $doc)
        <div class="group relative rounded-lg overflow-hidden cursor-pointer bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow" style="aspect-ratio: 3/4;">

            {{-- Foto --}}
            @if($doc->images)
            <img src="{{ asset('images/' . $doc->images) }}" alt="{{ $doc->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            @else
            <div class="w-full h-full flex items-center justify-center bg-slate-50">
                <i class="fa-solid fa-image text-slate-300 text-3xl"></i>
            </div>
            @endif

            {{-- Overlay Info --}}
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-between p-3 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent">

                {{-- Action buttons (top) --}}
                <div class="flex justify-end gap-1.5 translate-y-[-8px] group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300 delay-75">
                    <a href="{{ route('documentation.edit', $doc->slug) }}" class="w-7 h-7 rounded-md flex items-center justify-center text-[10px] bg-yellow-50 text-yellow-600 border border-yellow-200 hover:bg-yellow-100 transition-all shadow-sm" title="Edit">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <form action="{{ route('documentation.destroy', $doc->slug) }}" method="POST" onsubmit="return confirm('Yakin hapus foto ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-7 h-7 rounded-md flex items-center justify-center text-[10px] bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 transition-all shadow-sm" title="Hapus">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>

                {{-- Name (bottom) --}}
                <div class="translate-y-2 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <p class="text-white font-medium text-[13px] leading-tight truncate drop-shadow-md">{{ $doc->title }}</p>
                    <p class="text-slate-200 text-[10px] mt-0.5 drop-shadow-md">Sobat Scalify</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection
