@php
$menus = [
[
'label' => 'Dashboard',
'route' => 'dashboard.admin',
'icon' => 'fa-solid fa-gauge-high',
],
[
'label' => 'Category Portfolio',
'route' => 'portfolio-categories.index',
'icon' => 'fa-solid fa-layer-group',
],
[
'label' => 'Management Portfolio',
'route' => 'portfolio.index',
'icon' => 'fa-solid fa-briefcase',
],
[
'label' => 'Category Blogs',
'route' => 'blog-categories.index',
'icon' => 'fa-solid fa-tags',
],
[
'label' => 'Blogs',
'route' => 'blogs.index',
'icon' => 'fa-solid fa-pen-nib',
],
[
'label' => 'Documentation',
'route' => 'documentation.index',
'icon' => 'fa-solid fa-book',
],
[
'label' => 'Careers',
'route' => 'careers.index',
'icon' => 'fa-solid fa-briefcase',
],
[
'label' => 'Career Applications',
'route' => 'career-applications.index',
'icon' => 'fa-solid fa-file-lines',
],
[
'label' => 'Affiliate Partners',
'route' => 'admin.affiliates.index',
'icon' => 'fa-solid fa-handshake',
],
[
'label' => 'Withdrawals',
'route' => 'admin.withdrawals.index',
'icon' => 'fa-solid fa-money-bill-transfer',
],
[
'label' => 'Marketing',
'icon' => 'fa-solid fa-bullhorn',
'submenu' => [
[
'label' => 'Client Proposals',
'route' => 'admin.client_proposals.index',
'icon' => 'fa-solid fa-file-invoice-dollar',
],
[
'label' => 'Template Chat',
'route' => 'admin.chat_templates.index',
'icon' => 'fa-solid fa-comment-dots',
],
[
'label' => 'Business Categories',
'route' => 'admin.business_categories.index',
'icon' => 'fa-solid fa-layer-group',
],
]
],
[
'label' => 'Users',
'route' => 'users.index',
'icon' => 'fa-solid fa-users',
],
];

$activeRoute = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp

<aside class="w-[85vw] sm:w-80 lg:w-64 flex-shrink-0 h-screen flex flex-col overflow-hidden" style="background: linear-gradient(180deg, #0F172A 0%, #1E293B 100%); border-right: 1px solid rgba(255,255,255,0.06);">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 py-6 border-b" style="border-color: rgba(255,255,255,0.07);">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #3B82F6, #2563EB); box-shadow: 0 0 16px rgba(59,130,246,0.4);">
            <i class="fa-solid fa-bolt text-white text-sm"></i>
        </div>
        <div>
            <p class="text-white font-bold text-sm leading-tight tracking-wide">Scalify</p>
            <p class="text-xs font-medium" style="color: rgba(255,255,255,0.35); letter-spacing: 0.05em;">ADMIN PANEL</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-5" style="scrollbar-width: none;">

        {{-- Section label --}}
        <p class="text-[10px] font-semibold uppercase tracking-widest px-3 mb-3" style="color: rgba(255,255,255,0.25);">
            Main Menu
        </p>

        {{-- Grid for mobile, List for desktop --}}
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 lg:flex lg:flex-col lg:space-y-0.5 lg:gap-0">
            @foreach ($menus as $menu)
            @if (isset($menu['submenu']))
            @php
            $isSubActive = collect($menu['submenu'])->contains(function($sub) use ($activeRoute) {
            $baseRoute = str_replace('.index', '', $sub['route']);
            return $activeRoute === $sub['route'] || str_starts_with($activeRoute, $baseRoute . '.');
            });
            @endphp
            <div x-data="{ open: {{ $isSubActive ? 'true' : 'false' }} }" class="col-span-3 sm:col-span-4 lg:col-span-1">
                <button @click="open = !open" class="w-full flex flex-col lg:flex-row items-center lg:justify-between justify-center gap-1.5 lg:gap-3 p-3 lg:px-3 lg:py-2.5 rounded-xl transition-all duration-200 group relative {{ $isSubActive ? 'bg-white/5' : '' }}" style="border: 1px solid transparent;">
                    <div class="flex flex-col lg:flex-row items-center gap-1.5 lg:gap-3">
                        <i class="{{ $menu['icon'] }} text-lg lg:text-sm w-4 text-center transition-colors duration-200 {{ $isSubActive ? 'text-blue-400' : 'text-white/40 group-hover:text-white/70' }}"></i>
                        <span class="text-[10px] lg:text-sm font-medium transition-colors duration-200 text-center lg:text-left leading-tight {{ $isSubActive ? 'text-white' : 'text-white/55 group-hover:text-white/90' }}">
                            {{ $menu['label'] }}
                        </span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-white/40 hidden lg:block transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" class="lg:pl-7 mt-1 grid grid-cols-3 sm:grid-cols-4 gap-2 lg:flex lg:flex-col lg:space-y-0.5 lg:gap-0">
                    @foreach ($menu['submenu'] as $sub)
                    @php $isActive = $activeRoute === $sub['route']; @endphp
                    <a href="{{ route($sub['route']) }}" class="flex flex-col lg:flex-row items-center lg:justify-start justify-center gap-1.5 lg:gap-3 p-3 lg:px-3 lg:py-2 rounded-lg transition-all duration-200 group relative {{ $isActive ? 'text-white' : '' }}" style="{{ $isActive ? 'background: linear-gradient(90deg, rgba(59,130,246,0.2) 0%, rgba(59,130,246,0.08) 100%); border: 1px solid rgba(59,130,246,0.25);' : 'border: 1px solid transparent;' }}">
                        <i class="{{ $sub['icon'] }} text-lg lg:text-[13px] w-4 text-center transition-colors duration-200 {{ $isActive ? 'text-blue-400' : 'text-white/40 group-hover:text-white/70' }}"></i>
                        <span class="text-[10px] lg:text-[13px] font-medium transition-colors duration-200 text-center lg:text-left leading-tight {{ $isActive ? 'text-white' : 'text-white/55 group-hover:text-white/90' }}">
                            {{ $sub['label'] }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
            @elseif (isset($menu['route']) && Route::has($menu['route']))
            @php $isActive = $activeRoute === $menu['route']; @endphp
            <a href="{{ route($menu['route']) }}" class="flex flex-col lg:flex-row items-center lg:justify-start justify-center gap-1.5 lg:gap-3 p-3 lg:px-3 lg:py-2.5 rounded-xl transition-all duration-200 group relative {{ $isActive ? 'text-white' : '' }}" style="{{ $isActive ? 'background: linear-gradient(90deg, rgba(59,130,246,0.2) 0%, rgba(59,130,246,0.08) 100%); border: 1px solid rgba(59,130,246,0.25);' : 'border: 1px solid transparent;' }}">
                @if ($isActive)
                <span class="hidden lg:block absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-5 rounded-full" style="background: #3B82F6; box-shadow: 0 0 8px rgba(59,130,246,0.8);"></span>
                @endif
                <i class="{{ $menu['icon'] }} text-lg lg:text-sm w-4 text-center transition-colors duration-200 {{ $isActive ? 'text-blue-400' : 'text-white/40 group-hover:text-white/70' }}"></i>
                <span class="text-[10px] lg:text-sm font-medium transition-colors duration-200 text-center lg:text-left leading-tight {{ $isActive ? 'text-white' : 'text-white/55 group-hover:text-white/90' }} flex items-center justify-center lg:justify-start">
                    {{ $menu['label'] }}
                    @if($menu['route'] === 'blogs.index' && \App\Models\Blog::where('is_published', false)->whereNotNull('affiliate_id')->count() > 0)
                    <span class="ml-1.5 inline-flex items-center justify-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-red-500/20 text-red-400 border border-red-500/30">
                        {{ \App\Models\Blog::where('is_published', false)->whereNotNull('affiliate_id')->count() }}
                    </span>
                    @endif
                </span>
            </a>
            @endif
            @endforeach
        </div>
    </nav>

    <div class="px-3 pb-5 pt-4 border-t" style="border-color: rgba(255,255,255,0.07);">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex flex-col lg:flex-row items-center lg:justify-start justify-center gap-1.5 lg:gap-3 p-3 lg:px-3 lg:py-2.5 rounded-xl transition-all duration-200 group" style="border: 1px solid transparent;">
            <i class="fa-solid fa-arrow-right-from-bracket text-lg lg:text-sm text-white/40 group-hover:text-red-400 transition-colors w-4 text-center"></i>
            <span class="text-[10px] lg:text-sm font-medium text-white/55 group-hover:text-red-400 transition-colors text-center lg:text-left leading-tight">Log Out</span>
        </a>
    </div>

</aside>
