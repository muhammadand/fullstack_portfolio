<!-- Footer Section (Clean & Minimal) -->
<footer class="bg-slate-950 text-white pt-14 pb-10 border-t border-slate-900 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 pb-10 border-b border-slate-900">
            
            <!-- Col 1: Brand -->
            <div class="lg:col-span-5 space-y-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-white text-slate-950 font-heading font-extrabold flex items-center justify-center text-sm">
                        LPK
                    </div>
                    <span class="font-heading font-bold text-base text-white">
                        {{ $brandName }}
                    </span>
                </div>
                <p class="text-slate-400 text-xs leading-relaxed max-w-sm">
                    Lembaga Pelatihan Kerja resmi terakreditasi untuk persiapan dan penempatan tenaga kerja ke Jepang, Korea, Jerman, kapal pesiar, dan industri nasional.
                </p>
                <p class="text-slate-500 font-mono text-[11px]">
                    {{ $lpkDatabase['lpk_profile']['legal_info'] ?? 'Izin Disnaker: 563/108/LPK-V/2023' }}
                </p>
            </div>

            <!-- Col 2: Navigation -->
            <div class="lg:col-span-3 space-y-2.5">
                <h4 class="font-bold text-white uppercase text-[11px] tracking-wider mb-2">Navigasi</h4>
                <ul class="space-y-1.5 text-slate-400">
                    <li><a href="#hero" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="#program-pelatihan" class="hover:text-white transition">Program & Modul</a></li>
                    <li><a href="#simulasi-ujian" class="hover:text-white transition">Simulasi CBT</a></li>
                    <li><a href="#sistem-absensi" class="hover:text-white transition">Presensi Digital</a></li>
                    <li><a href="#verifikasi-sertifikat" class="hover:text-white transition">Verifikasi Sertifikat</a></li>
                    <li><a href="#pendaftaran-peserta" class="hover:text-white transition">Pendaftaran Online</a></li>
                </ul>
            </div>

            <!-- Col 3: Contact -->
            <div class="lg:col-span-4 space-y-2.5">
                <h4 class="font-bold text-white uppercase text-[11px] tracking-wider mb-2">Kontak & Lokasi</h4>
                <p class="text-slate-400">{{ $lpkDatabase['lpk_profile']['address'] ?? 'Jl. Pelatihan Utama No. 88' }}</p>
                <p class="text-slate-400">WhatsApp: +{{ $cleanWa }}</p>
                <p class="text-slate-500">Jam Operasional: Senin - Sabtu (08:00 - 17:00 WIB)</p>
            </div>

        </div>

        <!-- Copyright -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-slate-500 text-[11px]">
            <div>
                © {{ date('Y') }} {{ $brandName }}. All rights reserved.
            </div>
            <div>
                <a href="{{ route('proposal.dynamic', $client->slug) }}" target="_blank" class="text-slate-400 hover:text-white transition">
                    Lihat Proposal Resmi (PDF) →
                </a>
            </div>
        </div>

    </div>
</footer>

<!-- Minimal Floating Action Buttons -->
<div class="fixed bottom-6 right-6 z-40 flex items-center gap-2 no-print">
    <a href="{{ route('proposal.dynamic', $client->slug) }}" target="_blank" class="px-3.5 py-2 rounded-full bg-slate-900 text-white text-xs font-semibold shadow-lg border border-slate-700 hover:bg-slate-800 transition">
        Proposal PDF
    </a>
    <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin konsultasi mengenai program pelatihan kerja.') }}" target="_blank" class="w-10 h-10 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white flex items-center justify-center text-lg shadow-lg transition">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>
