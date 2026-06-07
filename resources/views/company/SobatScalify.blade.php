@extends('layouts.app')
@section('content')

{{-- Hero Section --}}
<section class="pt-14 sm:pt-16 relative">
    {{-- Gradient atas: dari brand-dark ke transparan --}}
    <div class="absolute top-14 sm:top-16 left-0 right-0 h-32 bg-gradient-to-b from-[#0A0E2A] to-transparent z-10 pointer-events-none"></div>

    <img src="{{ asset('images/sobatscal.png') }}" alt="Sobat Scalify" class="w-full h-auto block">

    {{-- Gradient bawah: dari transparan ke brand-dark --}}
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-[#0A0E2A] to-transparent z-10 pointer-events-none"></div>
</section>

{{-- Documentation Gallery Section --}}
<section x-data="{ lightboxOpen: false, lightboxImage: '' }" class="bg-[#0A0E2A] py-16 px-4 sm:px-6 lg:px-8 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-10">
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mb-2">Documentation</h2>
            <p class="text-white/40 text-sm tracking-wide">Momen bersama Sobat Scalify</p>
        </div>

        @if($documentation->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 rounded-2xl text-center" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
            <i class="fa-solid fa-camera text-white/20 text-4xl mb-4"></i>
            <p class="text-white/40 text-sm">Belum ada dokumentasi untuk saat ini.</p>
        </div>
        @else
        {{--
            Grid Masonry Dinamis
            Menggunakan pola array untuk row-span agar terlihat asimetris dan artistik
        --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3" style="grid-auto-rows: 180px; grid-auto-flow: dense;">

            @php
            // Pola ukuran row span agar membentuk masonry yang estetik seperti referensi
            // 2 = Tinggi (TALL), 1 = Normal, 3 = Sangat Tinggi (SUPER TALL)
            $spans = ['row-span-2', 'row-span-1', 'row-span-3', 'row-span-1', 'row-span-2', 'row-span-2', 'row-span-1'];
            @endphp

            @foreach($documentation as $doc)
            <div @click="lightboxOpen = true; lightboxImage = '{{ $doc->images ? asset('images/' . $doc->images) : '' }}'" class="relative group overflow-hidden rounded-xl cursor-pointer {{ $spans[$loop->index % count($spans)] }}">
                @if($doc->images)
                <img src="{{ asset('images/' . $doc->images) }}" alt="{{ $doc->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                @else
                <div class="w-full h-full bg-white/5 flex items-center justify-center">
                    <i class="fa-solid fa-image text-white/20 text-3xl"></i>
                </div>
                @endif

                {{-- Gradient Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300"></div>

                {{-- Text Content --}}
                <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-3 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                    <p class="text-white font-semibold text-sm drop-shadow-md">{{ $doc->title }}</p>
                    <p class="text-white/70 text-xs mt-0.5 drop-shadow-md">Sobat Scalify</p>
                </div>
            </div>
            @endforeach

        </div>
        @endif
    </div>

    {{-- Lightbox Modal --}}
    <div x-show="lightboxOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-md" x-transition.opacity.duration.300ms @keydown.escape.window="lightboxOpen = false">

        {{-- Close button --}}
        <button @click="lightboxOpen = false" class="absolute top-6 right-6 sm:top-8 sm:right-8 text-white/50 hover:text-white transition-colors z-50 focus:outline-none">
            <i class="fa-solid fa-xmark text-4xl"></i>
        </button>

        {{-- Image container --}}
        <div @click.away="lightboxOpen = false" class="relative max-w-6xl max-h-[90vh] w-full p-4 flex justify-center items-center">
            <img :src="lightboxImage" x-show="lightboxImage" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl" x-transition.scale.80.duration.300ms>
        </div>
    </div>
</section>
@endsection
