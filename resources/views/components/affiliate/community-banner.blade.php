@props(['affiliate'])

@php
    $groupUrl = env('SCALIFY_PARTNER_GROUP_URL', 'https://chat.whatsapp.com/H3W4qaoRvBJ0s2jpVi7OB9?s=cl&p=i&mlu=4&ilr=4&iam=2');
@endphp

<!-- Scalify Partner Official Community Banner -->
<div class="mb-6 relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900/90 via-blue-950/60 to-emerald-950/40 border border-emerald-500/30 p-4 shadow-xl shadow-black/40 backdrop-blur-md">
    <!-- Ambient Glow Effects -->
    <div class="absolute -right-6 -top-6 w-28 h-28 bg-emerald-500/20 rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute -left-6 -bottom-6 w-28 h-28 bg-blue-500/15 rounded-full blur-2xl pointer-events-none"></div>

    <div class="relative z-10">
        <!-- Top Status Bar -->
        <div class="flex items-center justify-between mb-3">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-[10px] font-extrabold text-emerald-300 tracking-wider uppercase">
                <i class="fa-solid fa-circle-exclamation animate-pulse text-[9px]"></i> Wajib Gabung Grup
            </span>

            <span class="flex items-center gap-1.5 text-[10px] text-slate-300 font-semibold bg-white/5 px-2 py-0.5 rounded-full border border-white/5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                Grup Resmi Scalify
            </span>
        </div>

        <!-- Main Content -->
        <div class="flex items-start gap-3.5 mb-3.5">
            <!-- Icon Avatar -->
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 to-green-600 flex items-center justify-center text-white text-2xl flex-shrink-0 shadow-[0_0_20px_rgba(16,185,129,0.35)]">
                <i class="fa-brands fa-whatsapp"></i>
            </div>

            <!-- Texts -->
            <div class="flex-1">
                <h3 class="text-sm font-bold text-white leading-tight">
                    Komunitas Eksklusif Partner Scalify
                </h3>
                <p class="text-[11px] text-slate-300 leading-relaxed mt-1">
                    Setiap partner diwajibkan bergabung ke grup resmi untuk mendapatkan info leads project, tips closing kilat, dan update bonus komisi.
                </p>
            </div>
        </div>

        <!-- Micro Feature Badges -->
        <div class="grid grid-cols-3 gap-1.5 mb-3.5">
            <div class="bg-white/5 border border-white/10 rounded-lg px-2 py-1.5 text-center">
                <div class="text-[10px] text-emerald-400 font-bold flex items-center justify-center gap-1">
                    <i class="fa-solid fa-bolt text-[8px]"></i> Info Hot
                </div>
                <div class="text-[9px] text-slate-400 leading-none mt-0.5">Leads Website</div>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-lg px-2 py-1.5 text-center">
                <div class="text-[10px] text-blue-400 font-bold flex items-center justify-center gap-1">
                    <i class="fa-solid fa-graduation-cap text-[8px]"></i> Mentoring
                </div>
                <div class="text-[9px] text-slate-400 leading-none mt-0.5">Teknik Closing</div>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-lg px-2 py-1.5 text-center">
                <div class="text-[10px] text-amber-400 font-bold flex items-center justify-center gap-1">
                    <i class="fa-solid fa-coins text-[8px]"></i> Reward
                </div>
                <div class="text-[9px] text-slate-400 leading-none mt-0.5">Bonus Poin</div>
            </div>
        </div>

        <!-- Join Button -->
        <a href="{{ $groupUrl }}" target="_blank" rel="noopener noreferrer" class="w-full py-2.5 px-4 bg-gradient-to-r from-emerald-500 via-green-500 to-emerald-600 hover:from-emerald-400 hover:to-green-500 text-white font-bold text-xs rounded-xl shadow-[0_4px_20px_rgba(16,185,129,0.35)] flex items-center justify-center gap-2 transition-all active:scale-[0.98]">
            <i class="fa-brands fa-whatsapp text-sm"></i>
            <span>Gabung Grup Komunitas Sekarang</span>
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-1 opacity-80"></i>
        </a>
    </div>
</div>

