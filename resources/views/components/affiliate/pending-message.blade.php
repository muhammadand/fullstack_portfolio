@props(['affiliate' => Auth::guard('affiliate')->user()])

@php
    $partnerName = $affiliate->name ?? 'Partner';
    $partnerEmail = $affiliate->email ?? '-';
    $partnerCode = $affiliate->affiliate_code ?? '-';

    $waMessage = "Halo Admin,\n\nSaya baru saja mendaftar sebagai Partner Affiliate:\n- Nama: {$partnerName}\n- Email: {$partnerEmail}\n- Kode Partner: {$partnerCode}\n\nMohon bantuannya untuk mensegerakan aktivasi akun saya agar bisa mulai beroperasi. Terima kasih!";

    $waUrl = "https://wa.me/6285221694067?text=" . urlencode($waMessage);
@endphp

<div class="glass-panel rounded-3xl p-6 sm:p-8 text-center mt-6 relative overflow-hidden border border-amber-500/20 shadow-2xl">
    <!-- Glow Background -->
    <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

    <!-- Icon Jam Pasir dengan Efek Denyut -->
    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-amber-500/15 border border-amber-500/30 text-amber-400 rounded-2xl flex items-center justify-center text-3xl sm:text-4xl mx-auto mb-4 shadow-lg shadow-amber-500/10 relative">
        <i class="fa-solid fa-hourglass-half"></i>
        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-amber-400 rounded-full animate-ping"></span>
    </div>

    <!-- Status Pill -->
    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/15 border border-amber-500/30 text-amber-300 rounded-full text-xs font-semibold mb-3">
        <i class="fa-solid fa-clock text-[11px]"></i>
        <span>Menunggu Persetujuan Admin</span>
    </div>

    <h2 class="text-xl sm:text-2xl font-bold text-white mb-2">Akun Sedang Ditinjau</h2>
    <p class="text-slate-300 text-xs sm:text-sm mb-5 leading-relaxed max-w-sm mx-auto">
        Pendaftaran Anda berhasil tersimpan. Agar akun Partner Anda bisa segera aktif untuk mulai berjualan dan mengakses seluruh materi promosi, silakan hubungi admin kami via WhatsApp.
    </p>

    <!-- Box Rincian Akun Partner -->
    <div class="bg-slate-900/80 border border-white/5 rounded-2xl p-3.5 mb-5 text-left text-xs space-y-1.5 max-w-sm mx-auto">
        <div class="flex justify-between items-center text-slate-400">
            <span>Nama Partner:</span>
            <span class="font-semibold text-white">{{ $partnerName }}</span>
        </div>
        <div class="flex justify-between items-center text-slate-400 border-t border-white/5 pt-1.5">
            <span>Email:</span>
            <span class="font-mono text-slate-200">{{ $partnerEmail }}</span>
        </div>
        <div class="flex justify-between items-center text-slate-400 border-t border-white/5 pt-1.5">
            <span>Kode Partner:</span>
            <span class="font-mono font-bold text-indigo-400">{{ $partnerCode }}</span>
        </div>
    </div>

    <!-- Tombol Hubungi Admin WhatsApp -->
    <a href="{{ $waUrl }}" target="_blank"
       class="inline-flex items-center justify-center gap-2.5 w-full max-w-sm mx-auto py-3.5 px-5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-xs sm:text-sm rounded-2xl shadow-lg shadow-emerald-500/25 transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95 cursor-pointer">
        <i class="fa-brands fa-whatsapp text-lg"></i>
        <span>Hubungi Admin (Percepat Aktivasi)</span>
    </a>

    <p class="text-[11px] text-slate-400 mt-3 flex items-center justify-center gap-1.5">
        <i class="fa-solid fa-phone text-[10px] text-emerald-400"></i>
        <span>WhatsApp Resmi: <b class="text-slate-200 font-mono">0852-2169-4067</b></span>
    </p>
</div>
