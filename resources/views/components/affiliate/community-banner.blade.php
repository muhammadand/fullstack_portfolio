@props(['affiliate'])

@php
$groupUrl = env('SCALIFY_PARTNER_GROUP_URL', 'https://chat.whatsapp.com/H3W4qaoRvBJ0s2jpVi7OB9?s=cl&p=i&mlu=4&ilr=4&iam=2');
@endphp

<!-- Sleek Compact VIP Community Bar (Mobile Friendly) -->
<a href="{{ $groupUrl }}" target="_blank" rel="noopener noreferrer" class="mb-5 block relative overflow-hidden rounded-2xl p-3.5 bg-gradient-to-r from-emerald-950/40 via-slate-900/80 to-slate-900 border border-emerald-500/30 hover:border-emerald-400/50 transition-all duration-200 group active:scale-[0.99] shadow-lg shadow-black/30 backdrop-blur-md">
    <!-- Subtle Ambient Glow -->
    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-emerald-500/15 rounded-full blur-xl pointer-events-none"></div>

    <div class="flex items-center justify-between gap-3 relative z-10">
        <!-- Left: Icon + Content -->
        <div class="flex items-center gap-3 min-w-0 flex-1">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-green-600 flex items-center justify-center text-white text-lg shrink-0 shadow-[0_0_15px_rgba(16,185,129,0.35)] group-hover:scale-105 transition-transform">
                <i class="fa-brands fa-whatsapp"></i>
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-1.5 flex-wrap">
                    <span class="text-xs font-bold text-white group-hover:text-emerald-300 transition-colors truncate">Grup Komunitas Resmi</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[8px] font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 uppercase tracking-wider">
                        <span class="w-1 h-1 rounded-full bg-emerald-400 animate-ping mr-1"></span> Wajib
                    </span>
                </div>
                <p class="text-[10px] text-slate-300/80 truncate mt-0.5">Leads project, mentoring closing & info bonus</p>
            </div>
        </div>

        <!-- Right: Action Pill -->
        <div class="shrink-0 flex items-center gap-1 px-3 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-[11px] font-bold group-hover:bg-emerald-500 group-hover:text-white transition-all shadow-sm">
            <span>Gabung</span>
            <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
        </div>
    </div>
</a>
