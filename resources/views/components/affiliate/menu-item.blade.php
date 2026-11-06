{{-- Satu tile menu affiliate. Data item berasal dari App\Support\AffiliateMenu. --}}
@props(['item', 'totalProjects' => null, 'withCoachMark' => false])

@if($item['soon'])
    {{-- Belum aktif: bisa di-tap (muncul toast), tapi tidak navigasi ke mana pun. --}}
    <button type="button" class="flex flex-col items-center gap-2 cursor-default select-none active:scale-95 transition-transform" aria-disabled="true" title="{{ trim($item['label'] . ' ' . $item['sublabel']) }} segera hadir" data-menu-key="{{ $item['key'] }}" onclick="window.showToast && window.showToast(this.dataset.soonMessage, 'info')" data-soon-message="{{ trim($item['label'] . ' ' . $item['sublabel']) }} segera hadir ya!">
        <x-affiliate.menu-icon :item="$item" :totalProjects="$totalProjects" />
    </button>
@elseif($item['action'] === 'share')
    <button type="button" class="flex flex-col items-center gap-2 cursor-pointer group" onclick="openShareModal()" data-menu-key="{{ $item['key'] }}">
        <x-affiliate.menu-icon :item="$item" :totalProjects="$totalProjects" />
    </button>
@else
    <a href="{{ route($item['route']) }}" wire:navigate @if($item['coachMark']) onclick="window.closeDashboardCoachMark && window.closeDashboardCoachMark()" @endif class="flex flex-col items-center gap-2 relative group" data-menu-key="{{ $item['key'] }}">
        <x-affiliate.menu-icon :item="$item" :totalProjects="$totalProjects" />

        @if($item['coachMark'] && $withCoachMark)
            <!-- Coach Mark (Disesuaikan agar tidak terpotong di tepi layar mobile) -->
            <div id="dashboardCoachMark" class="absolute bottom-full left-0 sm:left-1/2 sm:-translate-x-1/2 mb-3 hidden z-[60] w-48 max-w-[calc(100vw-2.5rem)] pointer-events-none">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-[11px] font-medium p-2.5 rounded-2xl shadow-xl shadow-blue-500/30 relative animate-bounce text-center border border-blue-400/30">
                    Yuk baca panduan Cara Kerja dulu!
                    <div class="absolute -bottom-1.5 left-6 sm:left-1/2 sm:-translate-x-1/2 w-3 h-3 bg-indigo-600 rotate-45 border-r border-b border-blue-400/30"></div>
                </div>
                <div class="absolute top-[3.25rem] left-6 -translate-x-1/2 sm:left-1/2 w-14 h-14 rounded-2xl border-2 border-blue-400/80 animate-ping pointer-events-none"></div>
            </div>
        @endif
    </a>
@endif
