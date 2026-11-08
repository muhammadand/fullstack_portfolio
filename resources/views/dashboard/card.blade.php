{{-- ===== STATS CARDS (mobile-first: 2 kolom di HP, 5 di desktop) ===== --}}
@php
    $blogPct = $totalViews > 0 ? round(($totalBlogViews / $totalViews) * 100) : 0;
    $portPct = $totalViews > 0 ? round(($totalPortfolioViews / $totalViews) * 100) : 0;
@endphp
<div class="grid grid-cols-2 lg:grid-cols-5 gap-2.5 lg:gap-4 mb-5 lg:mb-6">
    <x-admin.stat label="Total Views" :value="$totalViews" icon="fa-solid fa-eye" tone="blue" class="col-span-2 lg:col-span-1">
        Blog <x-admin.money :value="$totalBlogViews" :rupiah="false" class="font-semibold text-slate-700" /> · Portfolio <x-admin.money :value="$totalPortfolioViews" :rupiah="false" class="font-semibold text-slate-700" />
    </x-admin.stat>
    <x-admin.stat label="Blog Views" :value="$totalBlogViews" icon="fa-solid fa-rss" tone="emerald">{{ $blogPct }}% dari total</x-admin.stat>
    <x-admin.stat label="Portfolio Views" :value="$totalPortfolioViews" icon="fa-solid fa-chart-line" tone="indigo">{{ $portPct }}% dari total</x-admin.stat>
    <x-admin.stat label="Klik Affiliate" :value="$totalAffiliateClicks ?? 0" icon="fa-solid fa-users-viewfinder" tone="red" :href="route('admin.affiliates.index')">Kelola partner →</x-admin.stat>
    <x-admin.stat label="Konten Aktif" :value="$totalBlogs + $totalPortfolios" icon="fa-solid fa-layer-group" tone="sky">{{ $totalBlogs }} blog · {{ $totalPortfolios }} project</x-admin.stat>
</div>
