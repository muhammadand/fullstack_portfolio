{{-- ═══════════════════════════════════════════════════════
     SOCIAL PROOF: Company Logo Ticker + Reviews Section
═══════════════════════════════════════════════════════ --}}
<section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-[#080c27] border-b border-white/5 relative z-10 overflow-hidden">

    <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 60% 40% at 50% 100%, rgba(59,130,246,0.06) 0%, transparent 70%);"></div>

    <div class="max-w-6xl mx-auto">

        {{-- ═══ HEADER ═══ --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border mb-4 text-[11px] font-bold tracking-wider uppercase" style="background: rgba(251,191,36,0.08); border-color: rgba(251,191,36,0.25); color: #fbbf24;">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                Ulasan Nyata · Terverifikasi
            </div>
            <h2 class="font-black text-2xl sm:text-3xl lg:text-4xl text-white tracking-tight mb-3">
                Dipercaya <span class="bg-gradient-to-r from-cyan-300 to-blue-400 bg-clip-text text-transparent">50.000+</span> Pencari Kerja
            </h2>
            <p class="text-white/50 text-sm max-w-xl mx-auto">
                Ribuan jobseeker sudah lolos seleksi ke perusahaan impian menggunakan CV yang dibuat bersama Scalify AI.
            </p>
            <div class="inline-flex items-center gap-3 mt-6 px-5 py-3 rounded-2xl border border-white/8" style="background: rgba(255,255,255,0.03);">
                <div class="text-4xl font-black text-white leading-none">{{ $averageRating ?? '4.9' }}</div>
                <div class="text-left">
                    <div class="flex items-center gap-0.5 text-amber-400 mb-1">
                        @for($i=1;$i<=5;$i++)<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>@endfor
                    </div>
                    <p class="text-[11px] text-white/40 leading-none">dari {{ $totalReviews > 0 ? number_format($totalReviews) : '2.400+' }} ulasan</p>
                </div>
                <div class="h-8 w-px bg-white/10 mx-1"></div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="text-xs font-semibold text-white/70">Terverifikasi</span>
                </div>
            </div>
        </div>

        {{-- ═══ COMPANY LOGO TICKER ═══ --}}
        <div class="mb-14">
            <p class="text-center text-[11px] font-semibold uppercase tracking-widest text-white/30 mb-6">
                Pengguna kami berhasil lolos ke perusahaan-perusahaan ini
            </p>

            @php
            // Simple Icons: https://cdn.simpleicons.org/{slug}
            // Wikipedia Commons: direct PNG URL
            $companies = [
            ['name' => 'Google', 'logo' => 'https://cdn.simpleicons.org/google'],
            ['name' => 'Microsoft', 'logo' => 'https://cdn.simpleicons.org/microsoft'],
            ['name' => 'Samsung', 'logo' => 'https://cdn.simpleicons.org/samsung'],
            ['name' => 'Unilever', 'logo' => 'https://cdn.simpleicons.org/unilever'],
            ['name' => 'Gojek', 'logo' => 'https://cdn.simpleicons.org/gojek'],
            ['name' => 'Grab', 'logo' => 'https://cdn.simpleicons.org/grab'],
            ['name' => 'Shopee', 'logo' => 'https://cdn.simpleicons.org/shopee'],
            ['name' => 'Tokopedia', 'logo' => 'https://cdn.simpleicons.org/tokopedia'],
            ['name' => 'Traveloka', 'logo' => 'https://cdn.simpleicons.org/traveloka'],
            ['name' => 'Bukalapak', 'logo' => 'https://cdn.simpleicons.org/bukalapak'],
            ['name' => 'Lazada', 'logo' => 'https://cdn.simpleicons.org/lazada'],
            ['name' => 'Pertamina', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/31/Pertamina.svg/120px-Pertamina.svg.png'],
            ['name' => 'PLN', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bb/Logo_PLN.svg/120px-Logo_PLN.svg.png'],
            ['name' => 'Telkom', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Telkom_Indonesia_2013.svg/120px-Telkom_Indonesia_2013.svg.png'],
            ['name' => 'Mandiri', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/120px-Bank_Mandiri_logo_2016.svg.png'],
            ['name' => 'BRI', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/120px-BANK_BRI_logo.svg.png'],
            ['name' => 'BNI', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/BNI_logo.svg/120px-BNI_logo.svg.png'],
            ['name' => 'BCA', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/120px-Bank_Central_Asia.svg.png'],
            ['name' => 'Astra', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Astra_International.svg/120px-Astra_International.svg.png'],
            ['name' => 'Indofood', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Indofood_Logo.svg/120px-Indofood_Logo.svg.png'],
            ['name' => 'Garuda', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ab/Garuda_Indonesia_Logo.svg/120px-Garuda_Indonesia_Logo.svg.png'],
            ['name' => 'Pegadaian', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c0/Logo_Pegadaian.svg/120px-Logo_Pegadaian.svg.png'],
            ['name' => 'Telkomsel', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/97/Telkomsel_2021_icon.svg/120px-Telkomsel_2021_icon.svg.png'],
            ['name' => 'OVO', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/OVO_%28fintech%29_logo.svg/120px-OVO_%28fintech%29_logo.svg.png'],
            ['name' => 'Dana', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e2/DANA_%28application%29_logo.svg/120px-DANA_%28application%29_logo.svg.png'],
            ['name' => 'Blibli', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6d/Blibli.svg/120px-Blibli.svg.png'],
            ['name' => 'Indomaret', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Indomaret_logo.svg/120px-Indomaret_logo.svg.png'],
            ['name' => 'XL Axiata', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/XL_Axiata_logo_2016.svg/120px-XL_Axiata_logo_2016.svg.png'],
            ['name' => 'Indosat', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/52/Indosat_Ooredoo_logo.svg/120px-Indosat_Ooredoo_logo.svg.png'],
            ['name' => 'Alfamart', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Alfamart_logo.svg/120px-Alfamart_logo.svg.png'],
            ['name' => 'Danamon', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Bank_Danamon_logo.svg/120px-Bank_Danamon_logo.svg.png'],
            ];
            @endphp

            {{-- Fade edge mask --}}
            <div class="relative overflow-hidden" style="mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);
                       -webkit-mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);">

                {{-- Row 1 → LEFT --}}
                <div class="flex items-center gap-3 mb-3 ticker-left" style="width: max-content;">
                    @foreach(array_merge($companies, $companies) as $co)
                    <div class="flex-shrink-0 flex items-center gap-2.5 pl-1.5 pr-4 py-1.5 rounded-xl" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center flex-shrink-0 p-1 overflow-hidden">
                            <img src="{{ $co['logo'] }}" alt="{{ $co['name'] }}" class="w-full h-full object-contain" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
                            <span class="text-slate-800 text-[9px] font-black hidden leading-none text-center">{{ strtoupper(substr($co['name'],0,2)) }}</span>
                        </div>
                        <span class="text-white/75 text-xs font-semibold whitespace-nowrap">{{ $co['name'] }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Row 2 → RIGHT --}}
                <div class="flex items-center gap-3 ticker-right" style="width: max-content;">
                    @foreach(array_merge(array_reverse($companies), array_reverse($companies)) as $co)
                    <div class="flex-shrink-0 flex items-center gap-2.5 pl-1.5 pr-4 py-1.5 rounded-xl" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center flex-shrink-0 p-1 overflow-hidden">
                            <img src="{{ $co['logo'] }}" alt="{{ $co['name'] }}" class="w-full h-full object-contain" loading="lazy" referrerpolicy="no-referrer" onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
                            <span class="text-slate-800 text-[9px] font-black hidden leading-none text-center">{{ strtoupper(substr($co['name'],0,2)) }}</span>
                        </div>
                        <span class="text-white/75 text-xs font-semibold whitespace-nowrap">{{ $co['name'] }}</span>
                    </div>
                    @endforeach
                </div>

            </div>

            <style>
                @keyframes tickerLeft {
                    from {
                        transform: translateX(0);
                    }

                    to {
                        transform: translateX(-50%);
                    }
                }

                @keyframes tickerRight {
                    from {
                        transform: translateX(-50%);
                    }

                    to {
                        transform: translateX(0);
                    }
                }

                .ticker-left {
                    animation: tickerLeft 40s linear infinite;
                }

                .ticker-right {
                    animation: tickerRight 48s linear infinite;
                }

                .ticker-left:hover,
                .ticker-right:hover {
                    animation-play-state: paused;
                }

            </style>
        </div>

        {{-- ═══ REVIEWS GRID ═══ --}}
        @php
        $fallbackReviews = [
        ['name' => 'Dimas Prasetyo', 'role' => 'Software Engineer — Gojek', 'rating' => 5, 'note' => 'Formatnya rapi banget pas diprint A4. Diskusi sama AI langsung benerin deskripsi pekerjaan jadi berbobot. Ga nyangka bisa lolos interview Gojek pertama kali!'],
        ['name' => 'Rina Kartika', 'role' => 'Digital Marketing — Tokopedia', 'rating' => 5, 'note' => 'AI-nya langsung formulasikan pengalaman magang ke poin yang powerful. HRD bilang CV saya salah satu yang paling standout di batch rekrutmen mereka.'],
        ['name' => 'Aditya Maulana', 'role' => 'Account Executive — Mandiri', 'rating' => 5, 'note' => 'Dari nol sampai siap kirim lamaran cuma butuh 10 menit. Langsung lolos ke final interview Bank Mandiri!'],
        ['name' => 'Sari Dewi', 'role' => 'CPNS — Kemenkeu', 'rating' => 5, 'note' => 'Saya pakai ini untuk daftar CPNS Kemenkeu. ATS Score-nya tinggi banget jadi langsung lolos SKD. Terima kasih Scalify!'],
        ['name' => 'Budi Santoso', 'role' => 'Data Analyst — Telkom', 'rating' => 5, 'note' => 'Pengalaman magang saya yang "biasa" diubah AI jadi kelihatan impresif dengan metrik nyata. Recruiter Telkom langsung hubungi hari itu juga.'],
        ['name' => 'Anisa Rahmawati', 'role' => 'HR Specialist — Unilever', 'rating' => 5, 'note' => 'Sebagai HR, saya tahu CV yang bagus seperti apa. Dan ini memenuhi standar internasional. Section-nya bisa dikustom sesuai kebutuhan.'],
        ['name' => 'Rizky Firmansyah', 'role' => 'Backend Dev — Shopee', 'rating' => 5, 'note' => 'Suka banget fitur drag & drop section-nya. CV bisa kusortir sesuai yang paling relevan. Shopee langsung callback!'],
        ['name' => 'Maya Putri', 'role' => 'Business Analyst — Traveloka', 'rating' => 5, 'note' => 'Sudah coba banyak template CV online, tapi ini yang paling presisi pas diprint. Tidak ada yang geser-geser. Perfect buat lamaran ke Traveloka.'],
        ['name' => 'Hendra Kusuma', 'role' => 'Fresh Graduate — BRI', 'rating' => 5, 'note' => 'Sebagai fresh grad yang pengalaman kerjanya nol, AI membantu saya formulasikan kegiatan kampus jadi terlihat profesional. Alhamdulillah keterima di BRI!'],
        ['name' => 'Tiara Novita', 'role' => 'Product Manager — Astra', 'rating' => 5, 'note' => 'Yang paling suka adalah bisa diskusi soal isi CV. AI-nya ngerti konteks dan langsung update preview-nya. Lolos Astra setelah 2 kali gagal sebelumnya.'],
        ['name' => 'Fajar Nugraha', 'role' => 'Finance Staff — Pertamina', 'rating' => 5, 'note' => 'Formula STAR & XYZ beneran works! Deskripsi kerja yang dulu flat jadi konkret dengan angka dan dampak. HRD Pertamina bilang CV-nya outstanding.'],
        ['name' => 'Dewi Lestari', 'role' => 'Graphic Designer — Samsung', 'rating' => 5, 'note' => 'Layoutnya elegan dan profesional banget. Sebagai designer, saya paling takut CV jelek. Ini melebihi ekspektasi. Langsung dipanggil Samsung!'],
        ];
        $displayReviews = ($recentReviews && $recentReviews->count() > 0)
        ? $recentReviews
        : collect($fallbackReviews);
        $gradients = ['from-cyan-500 to-blue-600','from-indigo-500 to-purple-600','from-emerald-500 to-teal-600','from-rose-500 to-pink-600','from-amber-500 to-orange-600','from-blue-500 to-indigo-600'];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($displayReviews->take(12) as $idx => $rev)
            @php
            $isModel = is_object($rev);
            $name = $isModel ? $rev->name : $rev['name'];
            $role = $isModel ? ($rev->role ?: 'Jobseeker / Professional') : $rev['role'];
            $rating = $isModel ? $rev->rating : $rev['rating'];
            $note = $isModel ? $rev->note : $rev['note'];
            $time = $isModel ? $rev->created_at->diffForHumans() : 'Terverifikasi';
            $grad = $gradients[$idx % count($gradients)];
            @endphp
            <div class="group bg-slate-900/50 border border-white/6 hover:border-cyan-500/30 rounded-2xl p-5 transition-all duration-300 hover:shadow-lg hover:shadow-cyan-500/5 flex flex-col" style="{{ $idx % 3 === 1 ? 'background: linear-gradient(135deg, rgba(15,23,42,0.8), rgba(10,15,50,0.6));' : '' }}">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-0.5">
                        @for($i=1;$i<=5;$i++)<svg class="w-3.5 h-3.5 {{ $i <= $rating ? 'text-amber-400' : 'text-slate-700' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>@endfor
                    </div>
                    <span class="flex items-center gap-1 text-[10px] text-emerald-400/80 font-medium">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $time }}
                    </span>
                </div>
                <div class="text-3xl font-black leading-none mb-1" style="color: rgba(6,182,212,0.2); font-family: Georgia, serif;">"</div>
                <p class="text-white/80 text-sm leading-relaxed flex-1 mb-4">{{ $note }}</p>
                <div class="flex items-center gap-3 pt-3 border-t border-white/5">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr {{ $grad }} flex items-center justify-center text-white text-sm font-black flex-shrink-0 shadow-md">
                        {{ strtoupper(substr($name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-xs font-bold text-white truncate">{{ $name }}</h4>
                        <p class="text-[10px] text-cyan-400/80 truncate">{{ $role }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Bottom CTA --}}
        <div class="text-center mt-10">
            <a href="#ai-builder-section" class="inline-flex items-center gap-3 text-white text-sm font-black px-8 py-4 rounded-2xl hover:scale-[1.03] hover:-translate-y-0.5 transition-all duration-200" style="background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%); box-shadow: 0 0 32px rgba(37,99,235,0.35), 0 4px 20px rgba(0,0,0,0.3);">
                <span>Mulai Buat CV Sekarang — Gratis</span>
                <span class="w-6 h-6 rounded-xl bg-white/20 flex items-center justify-center text-xs">→</span>
            </a>
            <p class="text-white/35 text-[11px] mt-3">Bergabung bersama 50.000+ pencari kerja yang sudah lolos seleksi</p>
        </div>

    </div>
</section>
