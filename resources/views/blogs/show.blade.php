@extends('layouts.admin.app')

@section('content')

<div class="max-w-4xl mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold gradient-text">Detail Blog</h2>

        <div class="flex gap-2">
            <a href="{{ route('blogs.edit', $blog->id) }}"
               class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg font-medium transition">
               Edit
            </a>

            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus blog ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition">
                    Hapus
                </button>
            </form>

            <a href="{{ route('blogs.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-400 transition">
               Kembali
            </a>
        </div>
    </div>

    {{-- Card Konten --}}
    <div class="bg-white rounded-xl shadow-md p-6 flex flex-col gap-6">

        {{-- Featured Image --}}
        @if($blog->featured_image)
            <img 
                src="{{ asset('storage/' . $blog->featured_image) }}"
                class="w-full rounded-xl shadow-md"
                alt="{{ $blog->title }}">
        @endif

        {{-- Judul --}}
        <h1 class="text-3xl font-bold text-gray-900">
            {{ $blog->title }}
        </h1>

        {{-- Informasi --}}
        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
            <div><strong>Kategori:</strong> {{ $blog->category->name ?? '-' }}</div>
            <div><strong>Penulis:</strong> {{ $blog->author->name ?? '-' }}</div>
            <div>
                <strong>Diterbitkan:</strong>
                {{ $blog->published_at ? $blog->published_at->format('d M Y') : '-' }}
            </div>
            <div>
                <strong>Status:</strong> 
                @if($blog->is_published)
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Published</span>
                @else
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Draft</span>
                @endif
            </div>
            <div>
                <strong>Reading Time:</strong> {{ $blog->reading_time ?? '-' }} menit
            </div>
        </div>

        {{-- Excerpt --}}
        @if($blog->excerpt)
            <p class="text-gray-700 text-lg italic border-l-4 border-purple-400 pl-4">
                {{ $blog->excerpt }}
            </p>
        @endif

        {{-- Konten --}}
        <div class="prose max-w-none">
            {!! $blog->content !!}
        </div>

        {{-- Tags --}}
        @if($blog->tags && count($blog->tags) > 0)
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($blog->tags as $tag)
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                        #{{ $tag }}
                    </span>
                @endforeach
            </div>
        @endif

        {{-- SEO --}}
        <div class="mt-6 bg-gray-100 rounded-lg p-4">
            <h3 class="font-semibold text-gray-800 mb-2">SEO Information</h3>
            <p><strong>Meta Title:</strong> {{ $blog->meta_title ?? '-' }}</p>
            <p><strong>Meta Description:</strong> {{ $blog->meta_description ?? '-' }}</p>
        </div>

    </div>

</div>

@endsection
