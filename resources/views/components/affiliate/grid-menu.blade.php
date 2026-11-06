{{-- Shortcut menu dashboard. Data: App\View\Components\Affiliate\GridMenu + App\Support\AffiliateMenu --}}
<div class="mb-8">
    <div class="flex items-center justify-between mb-3.5">
        <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest pl-2 border-l-2 border-indigo-500 flex items-center gap-1.5">
            <i class="fa-solid fa-grip text-indigo-400 text-[10px]"></i> Menu Utama
        </h3>
        <a href="{{ route('affiliate.menu') }}" wire:navigate class="text-[11px] font-semibold text-blue-400 hover:text-blue-300 transition-colors">
            Lihat Semua <i class="fa-solid fa-chevron-right text-[9px] ml-0.5"></i>
        </a>
    </div>

    <div class="glass-panel rounded-3xl px-2 py-4">
        <div class="grid grid-cols-4 gap-y-4 gap-x-2">
            @foreach($shortcuts as $item)
                <x-affiliate.menu-item :item="$item" :totalProjects="$totalProjects" :withCoachMark="true" />
            @endforeach

            <!-- Slot ke-8: Semua Menu -->
            <a href="{{ route('affiliate.menu') }}" wire:navigate class="flex flex-col items-center gap-2 group" data-menu-key="all_menu">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-slate-200 text-lg shadow-inner relative transition-all duration-200 ease-out active:scale-90 active:opacity-60 group-hover:bg-white/10 group-hover:border-white/20">
                    <i class="fa-solid fa-grip"></i>
                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-emerald-400 ring-2 ring-[#0B1120]" title="Ada menu baru"></span>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight group-hover:text-white transition-colors">Semua<br>Menu</span>
            </a>
        </div>
    </div>
</div>
