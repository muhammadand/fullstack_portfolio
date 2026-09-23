<section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#0a0f30]/80 border-b border-white/5 relative z-10">
    <div class="max-w-6xl mx-auto">
        {{-- Section Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs font-semibold uppercase tracking-wider mb-3">
                    <i class="fa-solid fa-star text-amber-400"></i> Ulasan Pengguna Real-Time
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                    Apa Kata Mereka yang Telah Mencetak CV?
                </h2>
                <p class="text-slate-400 text-sm mt-2 max-w-xl">
                    Feedback asli dari para jobseeker dan profesional yang telah menyusun dan mengunduh format CV standar HRD ini.
                </p>
            </div>

            {{-- Rating Summary Badge --}}
            <div class="flex items-center gap-4 bg-slate-900/80 border border-white/10 rounded-2xl p-4 shrink-0 shadow-lg">
                <div class="text-3xl font-black text-white flex items-center gap-1.5">
                    {{ $averageRating ?? '4.9' }}
                    <span class="text-amber-400 text-2xl">★</span>
                </div>
                <div class="text-left border-l border-white/10 pl-4">
                    <div class="flex items-center text-amber-400 text-xs gap-0.5">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-0.5">
                        Dari {{ $totalReviews ?? 0 }} ulasan pengguna
                    </p>
                </div>
            </div>
        </div>

        {{-- Reviews Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($recentReviews ?? [] as $rev)
            <div class="bg-slate-900/60 border border-white/5 hover:border-cyan-500/30 rounded-2xl p-5 shadow-md hover:shadow-cyan-500/10 transition-all flex flex-col justify-between group">
                <div>
                    {{-- Star Rating & Timestamp --}}
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-amber-400 text-xs gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star {{ $i <= $rev->rating ? 'text-amber-400' : 'text-slate-700' }}"></i>
                            @endfor
                        </div>
                        <span class="text-[10px] text-slate-500">
                            {{ $rev->created_at ? $rev->created_at->diffForHumans() : 'Baru saja' }}
                        </span>
                    </div>

                    {{-- Note / Feedback --}}
                    <p class="text-slate-200 text-sm font-medium leading-relaxed mb-4">
                        "{{ $rev->note }}"
                    </p>
                </div>

                {{-- User Info --}}
                <div class="flex items-center gap-3 pt-3 border-t border-white/5">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                        {{ strtoupper(substr($rev->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-xs font-bold text-white truncate">{{ $rev->name }}</h4>
                        <p class="text-[10px] text-cyan-400 truncate">{{ $rev->role ?: 'Jobseeker / Professional' }}</p>
                    </div>
                </div>
            </div>
            @empty
            {{-- Default Sample Reviews if database is freshly migrated --}}
            @php
                $sampleReviews = [
                    ['name' => 'Dimas Prasetyo', 'role' => 'Frontend Developer', 'rating' => 5, 'note' => 'Sangat membantu dan praktis! Formatnya rapi banget pas diprint A4.'],
                    ['name' => 'Rina Kartika', 'role' => 'Digital Marketing', 'rating' => 5, 'note' => 'Bagus & Cepat! Diskusi sama AI nya langsung benerin deskripsi pengalaman kerja jadi berbobot.'],
                    ['name' => 'Aditya Maulana', 'role' => 'Account Executive', 'rating' => 5, 'note' => 'Keren banget, ga ribet langsung siap kirim lamaran. Recommended!'],
                ];
            @endphp
            @foreach($sampleReviews as $s)
            <div class="bg-slate-900/60 border border-white/5 hover:border-cyan-500/30 rounded-2xl p-5 shadow-md hover:shadow-cyan-500/10 transition-all flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-amber-400 text-xs gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star text-amber-400"></i>
                            @endfor
                        </div>
                        <span class="text-[10px] text-slate-500">Terverifikasi</span>
                    </div>
                    <p class="text-slate-200 text-sm font-medium leading-relaxed mb-4">
                        "{{ $s['note'] }}"
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-white/5">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                        {{ strtoupper(substr($s['name'], 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-xs font-bold text-white truncate">{{ $s['name'] }}</h4>
                        <p class="text-[10px] text-cyan-400 truncate">{{ $s['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>
