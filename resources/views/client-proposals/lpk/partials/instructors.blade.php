<!-- Instructors Section (Clean & Minimal) -->
<section id="instruktur-mentor" class="py-20 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Instruktur & Sensei
            </h2>
            <p class="mt-2 text-slate-600 text-xs sm:text-sm">
                Tenaga pendidik bersertifikasi BNSP dengan pengalaman kerja nyata di luar negeri.
            </p>
        </div>

        <!-- Instructors Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($lpkDatabase['instructors'] ?? [] as $inst)
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-slate-300 transition-all flex flex-col">
                
                <!-- Photo -->
                <div class="w-20 h-20 mx-auto rounded-xl overflow-hidden mb-4 bg-slate-100">
                    <img src="{{ $inst['image'] }}" alt="{{ $inst['name'] }}" loading="lazy" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&auto=format&fit=crop&q=80';" class="w-full h-full object-cover">
                </div>

                <div class="text-center flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-heading font-bold text-slate-900 text-sm">
                            {{ $inst['name'] }}
                        </h4>
                        <p class="text-xs text-blue-600 font-medium mt-0.5">
                            {{ $inst['role'] }}
                        </p>
                        <p class="text-[11px] text-slate-500 mt-2">
                            {{ $inst['experience'] }}
                        </p>
                    </div>

                    <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-400 font-mono">
                        {{ $inst['certification'] }}
                    </div>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>
