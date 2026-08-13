@props(['affiliate'])

<div class="flex justify-between items-center mb-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 font-bold">
            {{ substr($affiliate->name, 0, 1) }}
        </div>
        <div>
            <p class="text-[11px] text-blue-200/70 font-medium uppercase tracking-wider">Scalify Partner</p>
            <h1 class="text-base font-bold text-white tracking-wide truncate max-w-[150px]">{{ $affiliate->name }}</h1>
        </div>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('affiliate.profile') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-blue-300 hover:text-white transition-colors">
            <i class="fa-solid fa-user"></i>
        </a>
        <button onclick="openNotificationModal()" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-blue-300 hover:text-white transition-colors relative">
            <i class="fa-solid fa-bell"></i>
            @if($affiliate->unreadNotifications->count() > 0)
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
            @endif
        </button>
    </div>
</div>
