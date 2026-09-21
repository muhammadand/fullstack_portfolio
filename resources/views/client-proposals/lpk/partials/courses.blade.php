<!-- Course & Curriculum Explorer Section (Clean & Minimal) -->
<section id="program-pelatihan" class="py-20 bg-slate-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Program Pelatihan
            </h2>
            <p class="mt-2 text-slate-600 text-xs sm:text-sm">
                Kurikulum terstruktur berbasis kompetensi dengan modul e-learning, ujian CBT, dan sertifikasi BNSP.
            </p>

            <!-- Minimal Category Tabs -->
            <div class="mt-6 flex flex-wrap items-center justify-center gap-1.5">
                <button onclick="filterCategory('all', this)" class="category-btn active px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-slate-900 text-white">
                    Semua
                </button>
                <button onclick="filterCategory('Luar Negeri', this)" class="category-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-white text-slate-600 hover:bg-slate-100 border border-slate-200">
                    Luar Negeri (Jepang / Korea / Jerman)
                </button>
                <button onclick="filterCategory('Perhotelan & Maritim', this)" class="category-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-white text-slate-600 hover:bg-slate-100 border border-slate-200">
                    Perhotelan & Kapal Pesiar
                </button>
                <button onclick="filterCategory('Teknik & Manufaktur', this)" class="category-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-white text-slate-600 hover:bg-slate-100 border border-slate-200">
                    Pengelasan (Welder BNSP)
                </button>
                <button onclick="filterCategory('Teknologi Digital', this)" class="category-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-colors bg-white text-slate-600 hover:bg-slate-100 border border-slate-200">
                    Digital Marketing
                </button>
            </div>
        </div>

        <!-- Programs Grid -->
        <div id="programsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lpkDatabase['programs'] ?? [] as $program)
            <div class="program-card bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:border-slate-300 transition-all flex flex-col group" data-category="{{ $program['category'] }}" data-keywords="{{ strtolower($program['title'] . ' ' . $program['country'] . ' ' . $program['description']) }}">

                <!-- Card Image Thumbnail -->
                <div class="relative h-44 overflow-hidden bg-slate-200">
                    <img src="{{ $program['image'] }}" alt="{{ $program['title'] }}" loading="lazy" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1528164344705-475426879c0d?w=800&auto=format&fit=crop&q=80';" class="w-full h-full object-cover">

                    <!-- Country Tag -->
                    <div class="absolute top-3 left-3 px-2.5 py-1 rounded-md bg-slate-900/80 backdrop-blur-xs text-white text-[11px] font-medium">
                        {{ $program['flag'] }} {{ $program['country'] }}
                    </div>

                    <!-- Duration Tag -->
                    <div class="absolute bottom-3 right-3 px-2 py-0.5 rounded bg-white/90 text-slate-800 text-[10px] font-semibold">
                        {{ $program['duration'] }}
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider block font-mono">
                            {{ $program['code'] }}
                        </span>

                        <h3 class="font-heading font-bold text-slate-900 text-base mt-1 line-clamp-1 group-hover:text-blue-600 transition-colors">
                            {{ $program['title'] }}
                        </h3>

                        <p class="text-xs text-slate-500 line-clamp-2 mt-1.5 leading-relaxed">
                            {{ $program['subtitle'] }}
                        </p>

                        <!-- Salary Estimate -->
                        <div class="mt-4 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-[10px] text-slate-400 uppercase font-semibold block">Estimasi Penghasilan:</span>
                            <span class="font-heading font-bold text-slate-900 text-xs mt-0.5 block">
                                {{ $program['salary_estimate'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-5 mt-4 border-t border-slate-100 flex items-center gap-2">
                        <button onclick="openProgramModal('{{ $program['id'] }}')" class="flex-1 py-2 px-3 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold transition">
                            Silabus Modul
                        </button>
                        <button onclick="registerForProgram('{{ $program['title'] }}')" class="py-2 px-4 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition">
                            Daftar
                        </button>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        <div id="noProgramsFound" class="hidden text-center py-12 text-slate-400 text-xs">
            Tidak ada program yang sesuai dengan pencarian.
        </div>

    </div>
</section>

<!-- Modal Detail Program (Clean) -->
<div id="modalProgramDetail" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[85vh] overflow-hidden flex flex-col shadow-xl border border-slate-200 transform transition-all my-8">

        <!-- Header -->
        <div class="p-6 border-b border-slate-100 relative">
            <button onclick="closeProgramModal()" class="absolute top-5 right-5 w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                <i class="fas fa-times text-xs"></i>
            </button>
            <div class="flex items-center gap-2 mb-1.5 text-xs text-slate-500">
                <span id="modalProgramFlag"></span>
                <span id="modalProgramCode" class="font-mono font-semibold"></span>
                <span>•</span>
                <span id="modalProgramCategory"></span>
            </div>
            <h3 id="modalProgramTitle" class="font-heading text-lg font-bold text-slate-900"></h3>
            <p id="modalProgramSubtitle" class="text-xs text-slate-500 mt-0.5"></p>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto space-y-5 text-slate-700 text-xs custom-scrollbar flex-1">

            <!-- Quick Meta Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                <div class="bg-slate-50 rounded-xl p-2.5 border border-slate-100">
                    <span class="text-slate-400 text-[10px] block">Durasi</span>
                    <span id="modalProgramDuration" class="font-semibold text-slate-900 text-xs"></span>
                </div>
                <div class="bg-slate-50 rounded-xl p-2.5 border border-slate-100">
                    <span class="text-slate-400 text-[10px] block">Jadwal</span>
                    <span id="modalProgramSchedule" class="font-semibold text-slate-900 text-xs"></span>
                </div>
                <div class="bg-slate-50 rounded-xl p-2.5 border border-slate-100">
                    <span class="text-slate-400 text-[10px] block">Biaya</span>
                    <span id="modalProgramPrice" class="font-semibold text-blue-600 text-xs"></span>
                </div>
                <div class="bg-slate-50 rounded-xl p-2.5 border border-slate-100">
                    <span class="text-slate-400 text-[10px] block">Estimasi Gaji</span>
                    <span id="modalProgramSalary" class="font-semibold text-emerald-600 text-xs"></span>
                </div>
            </div>

            <!-- Description -->
            <div>
                <h4 class="font-bold text-slate-900 text-xs mb-1.5">Deskripsi Program</h4>
                <p id="modalProgramDesc" class="text-slate-600 leading-relaxed"></p>
            </div>

            <!-- Modules -->
            <div>
                <h4 class="font-bold text-slate-900 text-xs mb-2">Silabus Modul</h4>
                <div id="modalModulesList" class="space-y-1.5">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>

            <!-- Requirements -->
            <div>
                <h4 class="font-bold text-slate-900 text-xs mb-2">Persyaratan</h4>
                <ul id="modalRequirementsList" class="space-y-1 text-slate-600">
                    <!-- Populated dynamically via JS -->
                </ul>
            </div>

        </div>

        <!-- Footer -->
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-3 text-xs">
            <span class="text-slate-500">Skema DP: <strong id="modalProgramDp" class="text-slate-800"></strong></span>
            <div class="flex items-center gap-2">
                <button onclick="closeProgramModal()" class="px-3 py-2 rounded-lg border border-slate-200 text-slate-700 font-semibold hover:bg-slate-100 transition">
                    Tutup
                </button>
                <button id="modalBtnRegister" class="px-4 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-semibold transition">
                    Daftar Program Ini
                </button>
            </div>
        </div>

    </div>
</div>
