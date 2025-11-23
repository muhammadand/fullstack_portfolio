@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    $user = Auth::user();

    // Nama route: ambil kata pertama sebelum titik (.)
    $route = Route::currentRouteName();

    // Ambil kata pertama:
    // 1) Ganti - dan . jadi spasi → "portfolio categories index"
    // 2) Pecah jadi array → ["portfolio", "categories", "index"]
    // 3) Ambil [0] → "portfolio"
    $pageTitle = ucwords(explode(' ', str_replace(['.', '-'], ' ', $route))[0]);

    // Avatar
    $avatar = $user->profile_photo 
        ? asset('storage/' . $user->profile_photo)
        : "https://ui-avatars.com/api/?name=" . urlencode($user->name) . "&background=7c3aed&color=fff";
@endphp

<header class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-1">
            {{ $pageTitle }}
        </h1>
        <p class="text-gray-500 text-sm">
            Welcome back, {{ $user->name }}!
        </p>
    </div>

    <div class="flex items-center gap-4">
        <!-- Search -->
        <button
            class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-md hover:border-purple-300">
            <i class="fas fa-search text-gray-600 text-sm"></i>
        </button>

        <!-- Notification -->
        <button
            class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center relative transition-all duration-300 hover:scale-110 hover:shadow-md hover:border-purple-300">
            <i class="fas fa-bell text-gray-600 text-sm"></i>
            <span
                class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                3
            </span>
        </button>

        <!-- User menu -->
        <div class="flex items-center gap-3 cursor-pointer group">
            <img src="{{ $avatar }}"
                alt="User"
                class="w-10 h-10 rounded-full transition-all duration-300 group-hover:scale-110 group-hover:ring-2 group-hover:ring-purple-300">
            
            <div>
                <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                <p class="text-xs text-gray-500">{{ $user->email }}</p>
            </div>
        </div>
    </div>
</header>
