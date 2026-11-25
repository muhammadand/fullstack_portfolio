{{-- Kartu artikel blog (dipakai di daftar blog & halaman tag). Butuh: $blog --}}
<a href="{{ route('blogs.read', $blog->slug) }}" class="bg-brand-navy/70 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden shadow-card hover:shadow-glow-sm hover:border-brand-accent/40 hover:-translate-y-0.5 transition-all duration-300 flex flex-row sm:flex-col group h-full p-2.5 sm:p-0 items-center sm:items-stretch">

    {{-- Card Image (Mobile: Square Thumbnail di Kiri, Desktop: 16:10 Banner di Atas) --}}
    <div class="w-24 h-24 sm:w-full sm:h-auto sm:aspect-[16/10] rounded-xl sm:rounded-none overflow-hidden relative bg-white/5 shrink-0 sm:border-b border-white/5">
        @if ($blog->featured_image)
        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy" decoding="async">
        @else
        <img src="{{ asset('scalify-blog-default.webp') }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy" decoding="async">
        @endif
    </div>

    {{-- Card Content (Mobile: Sisi Kanan, Desktop: Bawah Gambar) --}}
    <div class="p-2.5 sm:p-5 lg:p-6 flex flex-col flex-1 min-w-0 justify-center sm:justify-start">
        {{-- Category --}}
        <div class="text-brand-accent font-bold text-[10px] sm:text-[11px] tracking-wider uppercase mb-1 sm:mb-2">
            {{ $blog->category->name ?? 'WEB DEVELOPMENT' }}
        </div>

        {{-- Title --}}
        <h3 class="font-bold text-[13px] sm:text-base leading-snug text-white/95 group-hover:text-brand-accent transition-colors line-clamp-2 mb-1.5 sm:mb-3">
            {{ $blog->title }}
        </h3>

        {{-- Footer: Date & Reading Time --}}
        <div class="mt-auto flex items-center text-[11px] sm:text-xs text-white/40 font-medium gap-2 sm:gap-3 pt-1 sm:pt-3 sm:border-t border-white/5">
            <span>{{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}</span>
            <span>{{ $blog->reading_time ?? '5' }} min read</span>
        </div>
    </div>

</a>
