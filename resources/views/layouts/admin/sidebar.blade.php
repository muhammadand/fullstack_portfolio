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
'label' => 'Users',
'route' => 'users.index',
'icon' => 'fa-solid fa-users',
],
];

$activeRoute = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp

<aside class="w-64 flex-shrink-0 h-screen flex flex-col overflow-hidden" style="background: linear-gradient(180deg, #0F172A 0%, #1E293B 100%); border-right: 1px solid rgba(255,255,255,0.06);">

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

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-0.5" style="scrollbar-width: none;">

        {{-- Section label --}}
        <p class="text-[10px] font-semibold uppercase tracking-widest px-3 mb-3" style="color: rgba(255,255,255,0.25);">
            Main Menu
        </p>

        @foreach ($menus as $menu)
        @if ($menu['route'] && Route::has($menu['route']))
        @php $isActive = $activeRoute === $menu['route']; @endphp

        <a href="{{ route($menu['route']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative
                        {{ $isActive ? 'text-white' : '' }}" style="{{ $isActive
                        ? 'background: linear-gradient(90deg, rgba(59,130,246,0.2) 0%, rgba(59,130,246,0.08) 100%); border: 1px solid rgba(59,130,246,0.25);'
                        : 'border: 1px solid transparent;' }}">

            {{-- Active left accent bar --}}
            @if ($isActive)
            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-5 rounded-full" style="background: #3B82F6; box-shadow: 0 0 8px rgba(59,130,246,0.8);"></span>
            @endif

            <i class="{{ $menu['icon'] }} text-sm w-4 text-center transition-colors duration-200
                        {{ $isActive ? 'text-blue-400' : 'text-white/40 group-hover:text-white/70' }}"></i>
            <span class="text-sm font-medium transition-colors duration-200
                        {{ $isActive ? 'text-white' : 'text-white/55 group-hover:text-white/90' }}">
                {{ $menu['label'] }}
            </span>
        </a>
        @endif
        @endforeach
    </nav>

    {{-- Bottom utility --}}
    <div class="px-3 pb-5 space-y-0.5 border-t pt-4" style="border-color: rgba(255,255,255,0.07);">

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group" style="border: 1px solid transparent;">
            <i class="fa-solid fa-arrow-right-from-bracket text-sm text-white/40 group-hover:text-red-400 transition-colors w-4 text-center"></i>
            <span class="text-sm font-medium text-white/55 group-hover:text-red-400 transition-colors">Log Out</span>
        </a>
    </div>

</aside>
