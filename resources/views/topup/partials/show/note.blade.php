{{-- 4. Catatan --}}
<section class="p-4 sm:p-5 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md">
    <h2 class="flex items-center gap-2.5 font-sans font-bold text-sm sm:text-base text-white mb-3">
        <span class="w-6 h-6 rounded-lg bg-btn-gradient flex items-center justify-center text-[11px] font-black">{{ $n + 2 }}</span>
        Catatan <span class="text-white/40 font-medium text-xs">(opsional)</span>
    </h2>
    <textarea x-model="note" rows="2" maxlength="200" placeholder="Tulis catatan untuk pesananmu"
        class="w-full rounded-xl bg-white/5 border border-white/15 focus:border-brand-accent/60 focus:bg-white/10 focus:outline-none text-white placeholder:text-white/30 text-base px-4 py-3 resize-none transition-colors"></textarea>
    <ul class="mt-3 space-y-1 text-[11px] text-white/45 leading-relaxed list-disc pl-4">
        <li>Pastikan data akun sudah benar sebelum membayar.</li>
        <li>Pesanan diproses otomatis setelah pembayaran berhasil.</li>
        <li>Pesanan yang sudah diproses tidak dapat dibatalkan.</li>
    </ul>
</section>
