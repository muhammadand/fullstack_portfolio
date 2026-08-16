@props(['affiliate'])

<div class="flex justify-between items-center mb-6">
    <a href="{{ route('affiliate.profile') }}" wire:navigate class="flex items-center gap-3 hover:opacity-80 transition-opacity">
        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white shadow-[0_0_15px_rgba(59,130,246,0.3)] font-bold overflow-hidden border border-white/10">
            @if($affiliate->avatar)
            <img src="{{ asset('storage/' . $affiliate->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
            @else
            {{ substr($affiliate->name, 0, 1) }}
            @endif
        </div>
        <div>
            <p class="text-[11px] text-blue-200/70 font-medium uppercase tracking-wider">Scalify Partner</p>
            <h1 class="text-base font-bold text-white tracking-wide truncate max-w-[150px]">{{ $affiliate->name }}</h1>
        </div>
    </a>
    <div class="flex gap-2">
        <button onclick="openNotificationModal()" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-blue-300 hover:text-white transition-colors relative z-50 cursor-pointer">
            <i class="fa-solid fa-bell"></i>
            @if($affiliate->unreadNotifications->count() > 0)
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
            @endif
        </button>
    </div>
</div>
