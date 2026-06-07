@extends('layouts.admin.app')

@section('content')

<div class="min-h-screen bg-white py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('blogs.index') }}" class="p-1.5 hover:bg-slate-100 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl tracking-tight font-bold text-slate-900">Detail Blog</h1>
                    <p class="text-[13px] text-slate-500">Lihat preview dan informasi lengkap blog</p>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('blogs.edit', $blog->id) }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-[13px] font-medium transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Yakin hapus blog ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl text-[13px] font-medium transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Card Konten --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col gap-6">

            {{-- Featured Image --}}
            @if($blog->featured_image)
            <img src="{{ asset('storage/' . $blog->featured_image) }}" class="w-full h-80 object-cover rounded-xl shadow-sm border border-slate-100" alt="{{ $blog->title }}">
            @endif

            {{-- Judul --}}
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ $blog->title }}
            </h1>

            {{-- Informasi --}}
            <div class="flex flex-wrap gap-4 text-[13px] text-slate-500 border-b border-slate-100 pb-4">
                <div><strong class="text-slate-700 font-medium">Kategori:</strong> {{ $blog->category->name ?? '-' }}</div>
                <div><strong class="text-slate-700 font-medium">Penulis:</strong> {{ $blog->author->name ?? '-' }}</div>
                <div>
                    <strong class="text-slate-700 font-medium">Diterbitkan:</strong>
                    {{ $blog->published_at ? $blog->published_at->format('d M Y') : '-' }}
                </div>
                <div class="flex items-center gap-1.5">
                    <strong class="text-slate-700 font-medium">Status:</strong>
                    @if($blog->is_published)
                    <span class="px-2 py-0.5 bg-slate-900 text-white rounded-full text-[11px] font-medium tracking-wide">Published</span>
                    @else
                    <span class="px-2 py-0.5 bg-slate-200 text-slate-700 rounded-full text-[11px] font-medium tracking-wide">Draft</span>
                    @endif
                </div>
                <div>
                    <strong class="text-slate-700 font-medium">Reading Time:</strong> {{ $blog->reading_time ?? '-' }} menit
                </div>
            </div>

            {{-- Excerpt --}}
            @if($blog->excerpt)
            <p class="text-slate-600 text-[13px] italic border-l-4 border-slate-900 pl-4 py-1">
                {{ $blog->excerpt }}
            </p>
            @endif

            {{-- Konten --}}
            <div class="prose prose-sm max-w-none text-[14px] text-slate-700 leading-relaxed">
                {!! $blog->content !!}
            </div>

            {{-- Tags --}}
            @if($blog->tags && count($blog->tags) > 0)
            <div class="mt-4 flex flex-wrap gap-2 pt-4 border-t border-slate-100">
                <strong class="text-[13px] text-slate-700 font-medium self-center mr-2">Tags:</strong>
                @foreach($blog->tags as $tag)
                <span class="px-3 py-1 bg-slate-50 text-slate-600 border border-slate-200 rounded-full text-[11px] font-medium transition-colors hover:bg-slate-100">
                    #{{ $tag }}
                </span>
                @endforeach
            </div>
            @endif

            {{-- SEO --}}
            <div class="mt-6 bg-slate-50 rounded-xl border border-slate-200 p-4">
                <h3 class="text-[13px] font-semibold tracking-wide text-slate-800 mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    SEO Information
                </h3>
                <div class="space-y-1.5 text-[13px] text-slate-600 ml-6">
                    <p><strong class="text-slate-700 font-medium">Meta Title:</strong> {{ $blog->meta_title ?? '-' }}</p>
                    <p><strong class="text-slate-700 font-medium">Meta Description:</strong> {{ $blog->meta_description ?? '-' }}</p>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
