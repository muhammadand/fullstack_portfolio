@php
    // Daftar menu dinamis
    $menus = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard.admin',
            'icon'  => 'fas fa-th-large',
        ],
        [
            'label' => 'Category Portfolio',
            'route' => 'portfolio-categories.index',
            'icon'  => 'far fa-credit-card',
        ],
        [
            'label' => 'Management Portfolio',
            'route' => 'portfolio.index',
            'icon'  => 'fas fa-wallet',
        ],
        [
            'label' => 'Category Blogs',
            'route' => 'blog-categories.index',
            'icon'  => 'far fa-dot-circle',
        ],
        [
            'label' => 'Blogs',
            'route' => 'blogs.index',
            'icon'  => 'far fa-circle',
        ],
        [
            'label' => 'Analytics',
            'route' => null, // tidak ada route → otomatis tidak tampil
            'icon'  => 'fas fa-chart-bar',
        ],
        [
            'label' => 'Settings',
            'route' => null, // tidak ada route → otomatis tidak tampil
            'icon'  => 'fas fa-cog',
        ],
    ];

    // Route yang aktif sekarang
    $activeRoute = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp

<aside class="w-64 bg-white h-screen p-4 shadow-sm overflow-y-auto flex flex-col">

    <!-- Logo -->
    <div class="flex items-center gap-4 mb-8 px-2">
        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center">
            <span class="text-white text-lg font-bold">BD</span>
        </div>
        <span class="text-lg font-bold">BarDigi</span>
    </div>

    <nav class="space-y-1">
        @foreach ($menus as $menu)
            @if ($menu['route'] && Route::has($menu['route']))      {{-- tampilkan hanya jika route ada --}}
                
                @php
                    $isActive = $activeRoute === $menu['route'];
                @endphp

                <a href="{{ route($menu['route']) }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 
                        {{ $isActive 
                            ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg scale-[1.03]' 
                            : 'text-gray-700 hover:bg-purple-50 hover:text-purple-600 hover:translate-x-1' 
                        }}">
                    <i class="{{ $menu['icon'] }} text-sm"></i>
                    <span class="text-sm font-medium">{{ $menu['label'] }}</span>
                </a>

            @endif
        @endforeach
    </nav>

    <!-- Bottom menu -->
    <div class="mt-auto pt-8 space-y-1">
        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-xl transition-all duration-300 hover:bg-purple-50 hover:text-purple-600 hover:translate-x-1">
            <i class="far fa-question-circle text-sm"></i>
            <span class="text-sm font-medium">Help</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-xl transition-all duration-300 hover:bg-red-50 hover:text-red-600 hover:translate-x-1">
            <i class="fas fa-sign-out-alt text-sm"></i>
            <span class="text-sm font-medium">Log out</span>
        </a>
    </div>

</aside>
