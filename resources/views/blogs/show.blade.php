@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Detail Blog" subtitle="Preview artikel dan informasinya." :back="route('blogs.index')">
    <x-admin.button icon="fa-solid fa-pen" :href="route('blogs.edit', $blog)">Edit</x-admin.button>
    <form action="{{ route('blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Hapus blog ini?')">
        @csrf
        @method('DELETE')
        <x-admin.button type="submit" variant="danger" icon="fa-solid fa-trash-can">Hapus</x-admin.button>
    </form>
</x-admin.page-header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    {{-- Preview artikel --}}
    <x-admin.card class="lg:col-span-2 overflow-hidden" :padding="false">
        @if ($blog->featured_image)
        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-72 object-cover">
        @endif

        <article class="p-6">
            <h1 class="text-2xl font-semibold text-slate-900 leading-snug">{{ $blog->title }}</h1>

            @if ($blog->excerpt)
            <p class="mt-3 text-sm text-slate-600 border-l-4 border-blue-600 pl-4">{{ $blog->excerpt }}</p>
            @endif

            <div class="blog-content mt-6 text-[15px] text-slate-700 leading-relaxed">
                {!! $blog->content !!}
            </div>

            @if (!empty($blog->tags))
            <div class="mt-8 pt-5 border-t border-slate-200 flex flex-wrap gap-2">
                @foreach ($blog->tags as $tag)
                <x-admin.badge color="blue">#{{ $tag }}</x-admin.badge>
                @endforeach
            </div>
            @endif
        </article>
    </x-admin.card>

    {{-- Informasi --}}
    <div class="space-y-6">
        <x-admin.card title="Informasi" icon="fa-solid fa-circle-info">
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Status</dt><dd>@include('blogs.partials.status-badge')</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Kategori</dt><dd class="text-slate-900 text-right">{{ $blog->category->name ?? '-' }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Penulis</dt><dd class="text-slate-900 text-right">{{ $blog->affiliate->name ?? $blog->author->name ?? '-' }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Diterbitkan</dt><dd class="text-slate-900">{{ $blog->published_at?->format('d M Y') ?? '-' }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Waktu baca</dt><dd class="text-slate-900">{{ $blog->reading_time ? $blog->reading_time . ' menit' : '-' }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Views</dt><dd class="text-slate-900">{{ number_format($blog->view_count ?? 0, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-500">Unggulan</dt><dd class="text-slate-900">{{ $blog->is_featured ? 'Ya' : 'Tidak' }}</dd></div>
            </dl>
        </x-admin.card>

        <x-admin.card title="SEO" icon="fa-solid fa-magnifying-glass">
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-slate-500 mb-0.5">Meta Title</dt>
                    <dd class="text-slate-900">{{ $blog->meta_title ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 mb-0.5">Meta Description</dt>
                    <dd class="text-slate-900">{{ $blog->meta_description ?: '-' }}</dd>
                </div>
            </dl>
        </x-admin.card>
    </div>
</div>

<style>
    .blog-content h1 { font-size: 1.5rem; font-weight: 600; margin: 1.5rem 0 .75rem; color: #0f172a; }
    .blog-content h2 { font-size: 1.25rem; font-weight: 600; margin: 1.25rem 0 .5rem; color: #0f172a; }
    .blog-content h3, .blog-content h4 { font-size: 1.0625rem; font-weight: 600; margin: 1rem 0 .5rem; color: #0f172a; }
    .blog-content p { margin-bottom: .875rem; }
    .blog-content ul { list-style: disc; padding-left: 1.5rem; margin-bottom: .875rem; }
    .blog-content ol { list-style: decimal; padding-left: 1.5rem; margin-bottom: .875rem; }
    .blog-content a { color: #2563eb; text-decoration: underline; }
    .blog-content blockquote { border-left: 4px solid #cbd5e1; padding-left: 1rem; color: #475569; margin-bottom: .875rem; }
    .blog-content img { max-width: 100%; border-radius: .5rem; }
    .blog-content pre { background: #0f172a; color: #e2e8f0; padding: 1rem; border-radius: .5rem; overflow-x: auto; margin-bottom: .875rem; }
</style>
@endsection
