@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$user = Auth::user();

$route = Route::currentRouteName();
$pageTitle = ucwords(str_replace(['.', '-'], ' ', explode('.', $route)[0]));

$avatar = $user->profile_photo
? asset('storage/' . $user->profile_photo)
: "https://ui-avatars.com/api/?name=" . urlencode($user->name) . "&background=1E3A8A&color=fff&bold=true";
@endphp

<header class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 mb-0.5">
            {{ $pageTitle }}
        </h1>
        <p class="text-slate-400 text-sm">
            Welcome back, <span class="font-medium text-slate-600">{{ $user->name }}</span>
        </p>
    </div>

    <div class="flex items-center gap-3">
        {{-- Search --}}
        <button class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center transition-all duration-200 hover:border-blue-300 hover:shadow-sm hover:shadow-blue-100">
            <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm"></i>
        </button>

        {{-- Notification --}}
        <button class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center relative transition-all duration-200 hover:border-blue-300 hover:shadow-sm hover:shadow-blue-100">
            <i class="fa-regular fa-bell text-slate-400 text-sm"></i>
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-blue-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                3
            </span>
        </button>

        {{-- Divider --}}
        <div class="w-px h-8 bg-slate-200"></div>

        {{-- User menu --}}
        <div class="flex items-center gap-2.5 cursor-pointer group">
            <img src="{{ $avatar }}" alt="User" class="w-9 h-9 rounded-xl object-cover ring-2 ring-transparent transition-all duration-200 group-hover:ring-blue-200">
            <div>
                <p class="text-sm font-semibold text-slate-800 leading-tight">{{ $user->name }}</p>
                <p class="text-xs text-slate-400 leading-tight">{{ $user->email }}</p>
            </div>
            <i class="fa-solid fa-chevron-down text-slate-400 text-[10px] ml-0.5"></i>
        </div>
    </div>
</header>
