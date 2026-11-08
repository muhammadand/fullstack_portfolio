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

<header class="flex items-center justify-between gap-3 mb-5 lg:mb-8">
    <div class="flex items-center min-w-0">
        <div class="min-w-0">
            <h1 class="text-lg lg:text-2xl font-bold text-slate-900 mb-0.5 truncate">
                {{ $pageTitle }}
            </h1>
            <p class="hidden sm:block text-slate-400 text-sm">
                Welcome back, <span class="font-medium text-slate-600">{{ $user->name }}</span>
            </p>
        </div>

    </div>

    <div class="flex items-center justify-end shrink-0 gap-2 lg:gap-3">

        {{-- Notification --}}
        <div x-data="{ notifOpen: false }" class="relative">
            <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center relative transition-all duration-200 hover:border-blue-300 hover:shadow-sm hover:shadow-blue-100">
                <i class="fa-regular fa-bell text-slate-400 text-sm"></i>
                @if($user->unreadNotifications->count() > 0)
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-blue-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                    {{ $user->unreadNotifications->count() }}
                </span>
                @endif
            </button>

            {{-- Dropdown Body --}}
            <div x-show="notifOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="fixed inset-x-3 top-16 lg:absolute lg:inset-x-auto lg:top-auto lg:right-0 lg:mt-3 lg:w-80 max-h-[75vh] overflow-y-auto bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50" style="display: none;">
                <div class="px-4 py-2 border-b border-slate-50 mb-1 flex justify-between items-center">
                    <p class="text-sm font-semibold text-slate-800">Notifications</p>
                </div>

                {{-- Push ke HP admin --}}
                <div x-data="adminPush()" class="mx-3 mb-2 rounded-lg border border-slate-200 bg-slate-50 p-3 text-xs">
                    <p class="font-semibold text-slate-800 flex items-center gap-1.5"><i class="fa-solid fa-mobile-screen-button text-blue-600"></i> Notifikasi di perangkat ini</p>
                    <p class="mt-1 text-slate-500" x-show="state === 'on'">Aktif: top up, pesanan, pendaftaran, dan penarikan langsung masuk.</p>
                    <p class="mt-1 text-slate-500" x-show="state === 'off'">Dapatkan kabar langsung saat ada top up, pesanan, atau pendaftaran baru.</p>
                    <p class="mt-1 text-amber-700" x-show="state === 'needs-install'">Di iPhone: ketuk Share lalu "Add to Home Screen", buka dari ikon itu, lalu aktifkan di sini.</p>
                    <p class="mt-1 text-amber-700" x-show="state === 'denied'">Notifikasi diblokir. Izinkan lewat pengaturan situs di browser.</p>
                    <p class="mt-1 text-slate-500" x-show="state === 'unsupported'">Browser ini tidak mendukung push notification.</p>
                    <div class="mt-2 flex gap-2">
                        <button type="button" x-show="state === 'off'" @click="enable()" :disabled="busy" class="px-3 py-1.5 rounded-md bg-blue-600 text-white font-semibold disabled:opacity-50">Aktifkan</button>
                        <button type="button" x-show="state === 'on'" @click="test()" class="px-3 py-1.5 rounded-md bg-white border border-slate-300 text-slate-700 font-semibold">Kirim tes</button>
                        <button type="button" x-show="state === 'on'" @click="disable()" :disabled="busy" class="px-3 py-1.5 rounded-md text-red-600 font-semibold disabled:opacity-50">Matikan</button>
                    </div>
                </div>
                <div class="max-h-64 overflow-y-auto">
                    @forelse($user->notifications()->latest()->get() as $notification)
                    <div class="px-4 py-3 border-b border-slate-50 last:border-0 hover:bg-slate-50 transition flex items-start gap-3 {{ $notification->read_at ? 'opacity-70' : 'bg-blue-50/30' }}">
                        <div class="flex-1">
                            <p class="text-sm text-slate-700">
                                {{ $notification->data['message'] ?? 'You have a new notification.' }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex flex-col gap-2 items-end justify-center pt-1">
                            @if(!$notification->read_at)
                            <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-blue-600 hover:text-blue-800" title="Mark as Read">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-400 hover:text-red-600" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="px-4 py-4 text-center text-sm text-slate-500">
                        No notifications yet.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="hidden lg:block w-px h-8 bg-slate-200"></div>

        {{-- User menu --}}
        {{-- User menu (Alpine.js Dropdown) --}}
        <div x-data="{ open: false }" class="relative">
            <div @click="open = !open" @click.away="open = false" class="flex items-center gap-2.5 cursor-pointer group">
                <img src="{{ $avatar }}" alt="{{ $user->name }}" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=1E3A8A&color=fff&bold=true'" class="w-9 h-9 shrink-0 rounded-xl object-cover bg-slate-200 ring-2 ring-transparent transition-all duration-200 group-hover:ring-blue-200">
                <div class="hidden md:block">
                    <p class="text-sm font-semibold text-slate-800 leading-tight">{{ $user->name }}</p>
                    <p class="text-xs text-slate-400 leading-tight">{{ $user->email }}</p>
                </div>
                <i class="fa-solid fa-chevron-down text-slate-400 text-[10px] ml-0.5 transition-transform duration-200 hidden md:block" :class="{'rotate-180': open}"></i>
            </div>

            {{-- Dropdown Body --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-3 w-48 max-w-[calc(100vw-1.5rem)] bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50" style="display: none;">

                <div class="px-4 py-2 border-b border-slate-50 mb-1">
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Account</p>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition">
                    <i class="fa-solid fa-user-pen w-4 text-center"></i>
                    Edit Profile
                </a>

                <form action="{{ route('logout') }}" method="POST" class="block mt-1 border-t border-slate-50 pt-1">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                        <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
