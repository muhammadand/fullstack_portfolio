<!-- Main Clean Navbar (Optimized for Mobile Single-Line & Clean Desktop) -->
<header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-18">
            
            <!-- Brand Logo & Title (Single Line Truncate on Mobile) -->
            <a href="#hero" class="flex items-center gap-2.5 min-w-0 max-w-[240px] sm:max-w-none group">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-slate-900 text-white flex items-center justify-center font-heading font-extrabold text-xs sm:text-sm shrink-0 shadow-xs group-hover:bg-blue-600 transition-colors">
                    LPK
                </div>
                <div class="min-w-0">
                    <span class="font-heading font-bold text-xs sm:text-sm text-slate-900 tracking-tight block leading-tight truncate">
                        {{ $brandName }}
                    </span>
                    <span class="text-[10px] font-medium text-slate-500 hidden sm:block truncate">
                        Lembaga Pelatihan Kerja
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center gap-7 text-[13px] font-medium text-slate-600">
                <a href="#program-pelatihan" class="hover:text-slate-900 transition">Program</a>
                <a href="#simulasi-ujian" class="hover:text-slate-900 transition">Ujian CBT</a>
                <a href="#sistem-absensi" class="hover:text-slate-900 transition">Presensi</a>
                <a href="#verifikasi-sertifikat" class="hover:text-slate-900 transition">Sertifikat</a>
                <a href="#instruktur-mentor" class="hover:text-slate-900 transition">Instruktur</a>
                <a href="#mitra-penyaluran" class="hover:text-slate-900 transition">Penyaluran</a>
            </nav>

            <!-- Desktop Action Buttons -->
            <div class="hidden sm:flex items-center gap-3 text-xs font-semibold">
                <button onclick="openModal('modal-login-demo')" class="px-3.5 py-2 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-slate-100 transition">
                    Portal Siswa
                </button>
                <a href="#pendaftaran-peserta" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white transition shadow-xs">
                    Daftar Sekarang
                </a>
            </div>

            <!-- Mobile Action Button (Single Clean Icon Button) -->
            <div class="flex lg:hidden items-center gap-1.5 shrink-0">
                <button id="mobileMenuBtn" class="w-9 h-9 rounded-xl border border-slate-200/80 bg-slate-50 flex items-center justify-center text-slate-700 hover:bg-slate-100 active:scale-95 transition" aria-label="Buka Menu">
                    <i class="fas fa-bars text-sm" id="menuIcon"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div id="mobileMenu" class="hidden lg:hidden bg-white border-b border-slate-200 px-5 py-4 space-y-2.5 text-xs font-medium shadow-sm">
        <a href="#program-pelatihan" class="block py-1.5 text-slate-700 hover:text-blue-600">Program & Modul</a>
        <a href="#simulasi-ujian" class="block py-1.5 text-slate-700 hover:text-blue-600">Simulasi CBT</a>
        <a href="#sistem-absensi" class="block py-1.5 text-slate-700 hover:text-blue-600">Presensi Siswa</a>
        <a href="#verifikasi-sertifikat" class="block py-1.5 text-slate-700 hover:text-blue-600">Cek Sertifikat</a>
        <a href="#instruktur-mentor" class="block py-1.5 text-slate-700 hover:text-blue-600">Instruktur</a>
        <a href="#mitra-penyaluran" class="block py-1.5 text-slate-700 hover:text-blue-600">Mitra Penyaluran</a>
        <a href="#paket-sistem-lpk" class="block py-1.5 text-slate-700 hover:text-blue-600">Paket Sistem</a>
        <div class="pt-2 flex flex-col gap-2">
            <button onclick="openModal('modal-login-demo')" class="w-full py-2 rounded-lg border border-slate-200 text-slate-700 font-semibold">
                Portal Siswa (Demo)
            </button>
            <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="w-full py-2 rounded-lg bg-emerald-600 text-white font-semibold text-center">
                Hubungi WhatsApp
            </a>
        </div>
    </div>
</header>
