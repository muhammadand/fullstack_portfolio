<!-- Placement Partners & Alumni (Clean & Minimal) -->
<section id="mitra-penyaluran" class="py-20 bg-slate-900 text-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="font-heading text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                Mitra Industri & Penyaluran
            </h2>
            <p class="mt-2 text-slate-400 text-xs sm:text-sm">
                Jaringan kerjasama resmi dengan accepting organizations di Jepang, Korea, Jerman, dan agensi kapal pesiar.
            </p>
        </div>

        <!-- 5-Step Pipeline Roadmap Minimal -->
        <div class="mb-14 bg-slate-800/80 rounded-2xl p-6 border border-slate-700">
            <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-slate-300 text-center mb-6">
                Alur Tahapan Penempatan Kerja
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-5 gap-3 text-center text-xs">
                <div class="bg-slate-900/80 rounded-xl p-3 border border-slate-700">
                    <span class="font-mono text-blue-400 font-bold block mb-1">01</span>
                    <strong class="text-white block">Pendaftaran</strong>
                    <span class="text-slate-400 text-[11px]">Placement test & berkas</span>
                </div>
                <div class="bg-slate-900/80 rounded-xl p-3 border border-slate-700">
                    <span class="font-mono text-blue-400 font-bold block mb-1">02</span>
                    <strong class="text-white block">Pelatihan</strong>
                    <span class="text-slate-400 text-[11px]">Bahasa & kejuruan</span>
                </div>
                <div class="bg-slate-900/80 rounded-xl p-3 border border-slate-700">
                    <span class="font-mono text-blue-400 font-bold block mb-1">03</span>
                    <strong class="text-white block">Ujian CBT</strong>
                    <span class="text-slate-400 text-[11px]">Sertifikasi BNSP / JLPT</span>
                </div>
                <div class="bg-slate-900/80 rounded-xl p-3 border border-slate-700">
                    <span class="font-mono text-blue-400 font-bold block mb-1">04</span>
                    <strong class="text-white block">Wawancara</strong>
                    <span class="text-slate-400 text-[11px]">Interview user & visa</span>
                </div>
                <div class="bg-slate-900/80 rounded-xl p-3 border border-slate-700">
                    <span class="font-mono text-emerald-400 font-bold block mb-1">05</span>
                    <strong class="text-white block">Penempatan</strong>
                    <span class="text-slate-400 text-[11px]">Keberangkatan kerja</span>
                </div>
            </div>
        </div>

        <!-- Partners Minimal Grid -->
        <div class="mb-14">
            <h4 class="font-heading font-semibold text-slate-400 text-xs uppercase tracking-wider text-center mb-5">
                Perusahaan Rekanan
            </h4>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 text-center">
                @foreach($lpkDatabase['partners'] ?? [] as $part)
                <div class="bg-slate-800/50 rounded-xl p-3 border border-slate-700/60">
                    <p class="font-semibold text-white text-xs">{{ $part['name'] }}</p>
                    <span class="text-[10px] text-slate-400 block mt-0.5">{{ $part['country'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Alumni Stories Minimal -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($lpkDatabase['alumni_stories'] ?? [] as $alumni)
            <div class="bg-slate-800/60 rounded-2xl p-5 border border-slate-700 flex gap-4 items-start">
                <img src="{{ $alumni['image'] }}" alt="{{ $alumni['name'] }}" loading="lazy" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&auto=format&fit=crop&q=80';" class="w-12 h-12 rounded-xl object-cover shrink-0">
                <div class="space-y-1 text-xs">
                    <p class="text-slate-300 italic">"{{ $alumni['quote'] }}"</p>
                    <div class="pt-2">
                        <strong class="text-white block font-semibold">{{ $alumni['name'] }}</strong>
                        <span class="text-blue-400 text-[11px] block">{{ $alumni['company'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
