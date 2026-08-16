<div class="fixed bottom-0 left-0 w-full glass-panel border-t border-white/10 z-50">
    <div class="max-w-md mx-auto flex justify-between items-center px-6 py-3">
        <a href="{{ route('affiliate.dashboard') }}" wire:navigate class="flex flex-col items-center gap-1 {{ request()->routeIs('affiliate.dashboard') ? 'text-blue-400' : 'text-slate-400 hover:text-blue-300' }} transition-colors">
            <i class="fa-solid fa-house text-xl"></i>
            <span class="text-[10px] font-medium">Beranda</span>
        </a>
        <a href="{{ route('affiliate.history') }}" wire:navigate class="flex flex-col items-center gap-1 {{ request()->routeIs('affiliate.history') ? 'text-blue-400' : 'text-slate-400 hover:text-blue-300' }} transition-colors">
            <i class="fa-solid fa-clock-rotate-left text-xl"></i>
            <span class="text-[10px] font-medium">Riwayat</span>
        </a>
        <form action="{{ route('affiliate.logout') }}" method="POST" class="flex flex-col items-center">
            @csrf
            <button type="submit" class="flex flex-col items-center gap-1 text-slate-400 hover:text-red-400 transition-colors">
                <i class="fa-solid fa-arrow-right-from-bracket text-xl"></i>
                <span class="text-[10px] font-medium">Keluar</span>
            </button>
        </form>
    </div>
</div>
