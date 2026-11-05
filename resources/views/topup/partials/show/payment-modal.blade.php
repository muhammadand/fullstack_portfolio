{{-- Modal pembayaran: konfirmasi -> QRIS -> sukses / kedaluwarsa. State dikelola oleh topupForm (script.blade.php). --}}
<div x-show="modal !== 'none'" x-cloak style="display:none" class="fixed inset-0 z-[70] flex items-end sm:items-center justify-center sm:p-4"
     role="dialog" aria-modal="true" @keydown.escape.window="closeModal()">

    <div x-show="modal !== 'none'" x-transition.opacity.duration.250ms @click="closeModal()" class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    <div x-show="modal !== 'none'"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-y-6 sm:scale-95"
         class="relative w-full sm:max-w-md max-h-[92dvh] overflow-y-auto rounded-t-3xl sm:rounded-3xl bg-[#0E1538] border border-white/10 shadow-2xl shadow-black/60 pb-[max(1.25rem,env(safe-area-inset-bottom))]">

        <div class="sm:hidden mx-auto mt-2.5 h-1 w-10 rounded-full bg-white/20"></div>

        {{-- ========== 1. Konfirmasi & pilih pembayaran ========== --}}
        <div x-show="modal === 'confirm'" class="p-5 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-sans font-extrabold text-lg text-white">Pembayaran</h3>
                <button type="button" @click="closeModal()" aria-label="Tutup" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/10 text-white/70 flex items-center justify-center"><i class="fa-solid fa-xmark"></i></button>
            </div>

            {{-- Ringkasan --}}
            <div class="rounded-2xl bg-white/[0.04] border border-white/10 p-4 text-sm">
                <p class="font-bold text-white" x-text="selected ? products[selected].name : ''"></p>
                <p class="text-[11px] text-white/45 mt-0.5">Top Up {{ $gameName }}</p>
                <dl class="mt-3 space-y-1.5 text-xs">
                    <template x-for="f in fields" :key="f.key">
                        <div class="flex justify-between gap-4"><dt class="text-white/50" x-text="f.label"></dt><dd class="font-semibold text-white" x-text="values[f.key]"></dd></div>
                    </template>
                    <div class="flex justify-between gap-4" x-show="email"><dt class="text-white/50">Email struk</dt><dd class="font-semibold text-white truncate" x-text="email"></dd></div>
                </dl>
            </div>

            {{-- Metode pembayaran --}}
            <p class="text-xs font-semibold text-white/60 mt-5 mb-2">Metode Pembayaran</p>
            <div class="space-y-2">
                <button type="button" class="w-full flex items-center gap-3 p-3 rounded-2xl border border-brand-accent bg-brand-blue/15 text-left shadow-glow-sm">
                    <span class="w-11 h-11 rounded-xl bg-white flex items-center justify-center shrink-0"><i class="fa-solid fa-qrcode text-slate-800 text-xl"></i></span>
                    <span class="flex-1 min-w-0">
                        <span class="block text-sm font-bold text-white">QRIS</span>
                        <span class="block text-[11px] text-white/55">GoPay, OVO, DANA, ShopeePay &amp; semua m-banking</span>
                    </span>
                    <i class="fa-solid fa-circle-check text-brand-accent"></i>
                </button>
                <div class="w-full flex items-center gap-3 p-3 rounded-2xl border border-white/10 bg-white/[0.02] opacity-50">
                    <span class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center shrink-0"><i class="fa-solid fa-building-columns text-white/70 text-lg"></i></span>
                    <span class="flex-1 min-w-0"><span class="block text-sm font-bold text-white">Virtual Account &amp; e-wallet lain</span><span class="block text-[11px] text-white/55">Segera hadir</span></span>
                </div>
            </div>

            @guest('customer')
            <a href="{{ route('customer.login') }}" class="mt-4 flex items-start gap-2.5 rounded-xl bg-amber-400/10 border border-amber-400/25 p-3 text-[11px] leading-snug text-amber-100/90">
                <i class="fa-solid fa-gift text-amber-300 mt-0.5"></i>
                <span><b>Masuk dulu</b> agar pesanan tercatat di riwayat dan kamu dapat poin reward. Tanpa masuk pun tetap bisa membayar.</span>
            </a>
            @else
            <p class="mt-4 flex items-center gap-2 text-[11px] text-emerald-300/90"><i class="fa-solid fa-clock-rotate-left"></i> Pesanan akan tersimpan di riwayat akunmu.</p>
            @endguest

            <p x-show="error" x-text="error" style="display:none" class="mt-3 text-xs text-red-300 bg-red-500/10 border border-red-400/25 rounded-xl p-3"></p>

            <div class="mt-5 flex items-center justify-between gap-4">
                <div><p class="text-[11px] text-white/50">Total bayar</p><p class="text-xl font-extrabold text-white" x-text="selected ? rupiah(products[selected].price) : ''"></p></div>
                <button type="button" @click="pay()" :disabled="paying"
                    class="h-12 px-7 rounded-xl bg-btn-gradient text-white font-bold text-sm shadow-glow-sm active:scale-95 transition-transform disabled:opacity-60 flex items-center gap-2">
                    <i x-show="paying" style="display:none" class="fa-solid fa-circle-notch fa-spin"></i>
                    <span x-text="paying ? 'Membuat QRIS...' : 'Bayar Sekarang'"></span>
                </button>
            </div>
        </div>

        {{-- ========== 2. Scan QRIS ========== --}}
        <div x-show="modal === 'qris'" style="display:none" class="p-5 sm:p-6 text-center">
            <div class="flex items-center justify-between mb-1">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-cyan-300 bg-cyan-400/10 border border-cyan-400/20 rounded-full px-2.5 py-1">
                    <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-400"></span></span>
                    Menunggu pembayaran
                </span>
                <button type="button" @click="closeModal()" aria-label="Tutup" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/10 text-white/70 flex items-center justify-center"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <h3 class="font-sans font-extrabold text-lg text-white mt-3">Scan untuk membayar</h3>
            <p class="text-xs text-white/50 mt-1">Buka aplikasi e-wallet atau m-banking, lalu scan QRIS ini.</p>

            <div class="relative mx-auto mt-4 w-64 max-w-full rounded-3xl bg-white p-3 shadow-xl shadow-blue-500/10">
                <img x-show="order.qr" :src="order.qr" alt="QRIS pembayaran" class="w-full aspect-square object-contain rounded-xl">
            </div>

            <p class="text-2xl font-black text-white mt-4" x-text="rupiah(order.total)"></p>
            <p class="text-[11px] text-white/45 mt-0.5" x-text="order.no"></p>

            <div class="mt-3 inline-flex items-center gap-2 rounded-full bg-white/5 border border-white/10 px-3.5 py-1.5 text-xs text-white/70">
                <i class="fa-regular fa-clock text-amber-300"></i> Bayar sebelum <span class="font-bold text-white tabular-nums" x-text="countdown"></span>
            </div>

            <p class="text-[11px] text-white/40 mt-4 leading-relaxed">Halaman ini otomatis berubah setelah pembayaran diterima. Jangan tutup sebelum selesai.</p>
        </div>

        {{-- ========== 3. Sukses ========== --}}
        <div x-show="modal === 'success'" style="display:none" class="relative overflow-hidden p-6 sm:p-8 text-center">
            <div class="pointer-events-none absolute -top-24 left-1/2 -translate-x-1/2 w-72 h-72 rounded-full bg-emerald-400/20 blur-3xl"></div>

            <div class="relative mx-auto w-24 h-24 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-[0_0_50px_rgba(52,211,153,.45)] tp-pop">
                <span class="absolute inset-0 rounded-full border-2 border-emerald-300/60 tp-ring"></span>
                <svg viewBox="0 0 52 52" class="w-12 h-12" fill="none" stroke="#fff" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"><path class="tp-check" d="M14 27 l8 8 l16 -18"/></svg>
            </div>

            <h3 class="relative font-sans font-extrabold text-2xl text-white mt-5">Pembayaran Berhasil</h3>
            <p class="relative text-sm text-white/60 mt-1.5">Terima kasih! Pesananmu sedang kami proses.</p>

            <div class="relative mt-6 rounded-2xl bg-white/[0.05] border border-white/10 text-left overflow-hidden">
                <div class="p-4 space-y-2 text-xs">
                    <div class="flex justify-between gap-4"><span class="text-white/50">Produk</span><span class="font-semibold text-white text-right" x-text="selected ? products[selected].name : ''"></span></div>
                    <div class="flex justify-between gap-4"><span class="text-white/50">Game</span><span class="font-semibold text-white">{{ $gameName }}</span></div>
                    <template x-for="f in fields" :key="f.key">
                        <div class="flex justify-between gap-4"><span class="text-white/50" x-text="f.label"></span><span class="font-semibold text-white" x-text="values[f.key]"></span></div>
                    </template>
                    <div class="flex justify-between gap-4"><span class="text-white/50">No. Order</span><span class="font-mono font-semibold text-white" x-text="order.no"></span></div>
                </div>
                <div class="relative border-t border-dashed border-white/15">
                    <span class="absolute -left-2 -top-2 w-4 h-4 rounded-full bg-[#0E1538]"></span><span class="absolute -right-2 -top-2 w-4 h-4 rounded-full bg-[#0E1538]"></span>
                    <div class="p-4 flex justify-between items-center"><span class="text-xs text-white/50">Total dibayar</span><span class="text-lg font-black text-emerald-300" x-text="rupiah(order.total)"></span></div>
                </div>
            </div>

            <p x-show="order.emailMasked" style="display:none" class="relative mt-4 text-[11px] text-white/55"><i class="fa-solid fa-envelope-circle-check text-emerald-300 mr-1"></i>Struk akan dikirim ke <b class="text-white/80" x-text="order.emailMasked"></b> setelah item masuk ke akun game.</p>

            <div class="relative mt-6 grid gap-2.5">
                @auth('customer')
                <a href="{{ route('customer.account') }}" class="h-12 rounded-xl bg-btn-gradient text-white font-bold text-sm shadow-glow-sm flex items-center justify-center gap-2 active:scale-95 transition-transform"><i class="fa-solid fa-clock-rotate-left"></i> Lihat Riwayat Pesanan</a>
                @endauth
                <button type="button" @click="finish()" class="h-12 rounded-xl border border-white/15 hover:bg-white/5 text-white/80 font-semibold text-sm transition-colors">Top Up Lagi</button>
            </div>
        </div>

        {{-- ========== 4. Kedaluwarsa ========== --}}
        <div x-show="modal === 'expired'" style="display:none" class="p-6 sm:p-8 text-center">
            <div class="mx-auto w-20 h-20 rounded-full bg-amber-400/15 border border-amber-400/30 flex items-center justify-center"><i class="fa-regular fa-clock text-3xl text-amber-300"></i></div>
            <h3 class="font-sans font-extrabold text-xl text-white mt-4">Waktu Pembayaran Habis</h3>
            <p class="text-sm text-white/55 mt-1.5">QRIS sudah kedaluwarsa. Belum ada dana yang terpotong, silakan buat pesanan baru.</p>
            <button type="button" @click="modal = 'confirm'; error = ''" class="mt-6 w-full h-12 rounded-xl bg-btn-gradient text-white font-bold text-sm shadow-glow-sm active:scale-95 transition-transform">Buat QRIS Baru</button>
        </div>
    </div>
</div>
