<div class="mt-6 mb-4">
    <div class="flex items-center justify-between mb-3 px-1">
        <h2 class="text-sm font-bold text-white"><i class="fa-solid fa-graduation-cap text-blue-400 mr-2"></i>Peluang Jasa Mahasiswa</h2>
    </div>

    <p class="text-xs text-slate-400 mb-4 px-1 leading-relaxed">
        Tawarkan jasa pembuatan program untuk skripsi atau tugas teman kampusmu. Biar tim kami yang kerjakan, kamu dapat komisi!
    </p>

    @php
    $studentIdeas = \App\Http\Controllers\Affiliate\TargetIdeaController::getStudentIdeas();
    @endphp

    <!-- Horizontal Marquee Container for Students (Reverse direction for variety) -->
    <style>
        @keyframes marquee-reverse {
            0% {
                transform: translateX(calc(-50% - 0.5rem));
            }
            100% {
                transform: translateX(0);
            }
        }

        .animate-marquee-reverse {
            animation: marquee-reverse 35s linear infinite;
        }

        .animate-marquee-reverse:hover,
        .animate-marquee-reverse:active {
            animation-play-state: paused;
        }
    </style>

    <div class="overflow-hidden pb-4 -mx-4 px-4 relative">
        <div class="flex gap-4 w-max animate-marquee-reverse">
            <!-- First Set -->
            @foreach($studentIdeas as $slug => $idea)
            <a href="{{ route('affiliate.ideas.show', $slug) }}" class="flex-none w-56 glass-panel rounded-2xl overflow-hidden group hover:bg-white/10 transition-colors border border-white/5 relative block">
                <div class="h-32 w-full relative overflow-hidden">
                    <img src="{{ $idea['image'] }}" alt="{{ $idea['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0B1120] to-transparent opacity-80"></div>
                    <div class="absolute bottom-2 left-3">
                        <h3 class="text-sm font-bold text-white shadow-sm">{{ $idea['title'] }}</h3>
                    </div>
                </div>
                <div class="p-3">
                    <p class="text-xs text-slate-400 line-clamp-2">{{ $idea['short_desc'] }}</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-[10px] text-blue-400 font-medium">Baca Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right text-xs text-slate-500 group-hover:text-blue-400 transition-colors transform group-hover:translate-x-1"></i>
                    </div>
                </div>
            </a>
            @endforeach

            <!-- Duplicate Set for Seamless Loop -->
            @foreach($studentIdeas as $slug => $idea)
            <a href="{{ route('affiliate.ideas.show', $slug) }}" class="flex-none w-56 glass-panel rounded-2xl overflow-hidden group hover:bg-white/10 transition-colors border border-white/5 relative block">
                <div class="h-32 w-full relative overflow-hidden">
                    <img src="{{ $idea['image'] }}" alt="{{ $idea['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0B1120] to-transparent opacity-80"></div>
                    <div class="absolute bottom-2 left-3">
                        <h3 class="text-sm font-bold text-white shadow-sm">{{ $idea['title'] }}</h3>
                    </div>
                </div>
                <div class="p-3">
                    <p class="text-xs text-slate-400 line-clamp-2">{{ $idea['short_desc'] }}</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-[10px] text-blue-400 font-medium">Baca Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right text-xs text-slate-500 group-hover:text-blue-400 transition-colors transform group-hover:translate-x-1"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Subtle fade edges for aesthetics -->
        <div class="absolute top-0 left-0 h-full w-8 bg-gradient-to-r from-[#0B1120] to-transparent pointer-events-none"></div>
        <div class="absolute top-0 right-0 h-full w-8 bg-gradient-to-l from-[#0B1120] to-transparent pointer-events-none"></div>
    </div>
</div>
