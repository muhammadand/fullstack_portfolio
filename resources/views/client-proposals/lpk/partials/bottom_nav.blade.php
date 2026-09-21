<!-- Mobile Bottom Quick Navigation Bar (Sticky for Smartphone Users) -->
<div class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 shadow-lg px-2 py-1.5 no-print">
    <div class="flex items-center justify-around text-center text-[10px] font-medium text-slate-500">
        
        <a href="#program-pelatihan" class="flex flex-col items-center py-1 px-2 rounded-lg hover:text-slate-900 active:bg-slate-100 transition">
            <i class="fas fa-book-open text-sm mb-0.5 text-slate-700"></i>
            <span>Program</span>
        </a>

        <a href="#simulasi-ujian" class="flex flex-col items-center py-1 px-2 rounded-lg hover:text-slate-900 active:bg-slate-100 transition">
            <i class="fas fa-laptop-code text-sm mb-0.5 text-blue-600"></i>
            <span>Ujian CBT</span>
        </a>

        <a href="#sistem-absensi" class="flex flex-col items-center py-1 px-2 rounded-lg hover:text-slate-900 active:bg-slate-100 transition">
            <i class="fas fa-qrcode text-sm mb-0.5 text-emerald-600"></i>
            <span>Presensi</span>
        </a>

        <a href="#verifikasi-sertifikat" class="flex flex-col items-center py-1 px-2 rounded-lg hover:text-slate-900 active:bg-slate-100 transition">
            <i class="fas fa-award text-sm mb-0.5 text-amber-500"></i>
            <span>Sertifikat</span>
        </a>

        <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin konsultasi mengenai program pelatihan kerja & penempatan.') }}" target="_blank" class="flex flex-col items-center py-1 px-2.5 rounded-lg bg-emerald-600 text-white font-semibold active:bg-emerald-700 transition">
            <i class="fab fa-whatsapp text-sm mb-0.5"></i>
            <span>Chat WA</span>
        </a>

    </div>
</div>
