<div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-5 pb-20">

    <!-- Top Navigation Bar -->
    <header class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('affiliate.history') }}" class="w-9 h-9 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95" title="Kembali ke Riwayat">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
            <div>
                <h1 class="text-base font-extrabold text-white tracking-tight flex items-center gap-1.5">
                    <i class="fa-solid fa-receipt text-emerald-400 text-sm"></i> Detail Transaksi
                </h1>
                <p class="text-[10px] text-slate-400 mt-0.5">Bukti Resmi Transaksi Finansial</p>
            </div>
        </div>

        <a href="{{ route('affiliate.dashboard') }}" class="px-2.5 py-1.5 rounded-xl glass-panel text-[11px] font-bold text-slate-300 hover:text-white flex items-center gap-1 transition-colors active:scale-95">
            <i class="fa-solid fa-house text-[10px] text-blue-400"></i>
            <span>Beranda</span>
        </a>
    </header>

    @if(!$trx)
    <div class="p-8 text-center text-slate-400 text-xs flex flex-col items-center glass-panel rounded-3xl my-auto">
        <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center text-2xl mb-3 text-slate-500">
            <i class="fa-solid fa-triangle-exclamation text-amber-400"></i>
        </div>
        <h4 class="text-xs font-bold text-slate-200 mb-1">Data Transaksi Tidak Ditemukan</h4>
        <p class="text-[11px] text-slate-500 max-w-[240px] mb-4">Transaksi tidak tersedia atau Anda tidak memiliki akses ke data ini.</p>
        <a href="{{ route('affiliate.history') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white font-bold text-xs rounded-xl transition-all">
            Kembali ke Riwayat
        </a>
    </div>
    @else

    <!-- THE DANA-STYLE DIGITAL RECEIPT CARD -->
    <div id="receiptCardToCapture" class="relative bg-gradient-to-b from-slate-900/95 via-[#0E172A] to-slate-900/95 border border-white/10 rounded-3xl p-5 shadow-2xl overflow-hidden text-center mb-5">

        <!-- Ambient Glow behind Amount -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-56 h-24 {{ $trx['type'] === 'CREDIT' ? 'bg-emerald-500/20' : 'bg-rose-500/15' }} rounded-full blur-2xl pointer-events-none"></div>

        <!-- Brand Header Inside Receipt -->
        <div class="flex items-center justify-between pb-3.5 border-b border-white/10 relative z-10 text-[10px]">
            <div class="flex items-center gap-2 font-black tracking-wider text-white">
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-slate-950 font-black text-xs shadow-md shadow-emerald-500/30">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <span class="text-xs tracking-wide">SCALIFY PAY</span>
            </div>
            <span class="text-[9px] font-mono font-bold text-slate-300 bg-white/10 px-2.5 py-0.5 rounded-full border border-white/10 flex items-center gap-1">
                <i class="fa-solid fa-shield-halved text-emerald-400 text-[9px]"></i> BUKTI RESMI
            </span>
        </div>

        <!-- Status Badge Pill -->
        <div class="mt-4 mb-2 flex justify-center relative z-10">
            @if($trx['status_color'] === 'emerald')
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs font-bold">
                <i class="fa-solid {{ $trx['status_icon'] }} text-xs"></i>
                <span>{{ $trx['status'] }}</span>
            </div>
            @elseif($trx['status_color'] === 'amber')
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/15 border border-amber-500/30 text-amber-300 text-xs font-bold">
                <i class="fa-solid {{ $trx['status_icon'] }} text-xs"></i>
                <span>{{ $trx['status'] }}</span>
            </div>
            @else
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-rose-500/15 border border-rose-500/30 text-rose-300 text-xs font-bold">
                <i class="fa-solid {{ $trx['status_icon'] }} text-xs"></i>
                <span>{{ $trx['status'] }}</span>
            </div>
            @endif
        </div>

        <!-- Hero Amount -->
        <div class="my-3 relative z-10">
            <div class="text-3xl sm:text-4xl font-black tracking-tight {{ $trx['type'] === 'CREDIT' ? 'text-emerald-400' : 'text-rose-400' }}">
                {{ $trx['type'] === 'CREDIT' ? '+' : '-' }}{{ $trx['amount_formatted'] }}
            </div>
            <h4 class="text-xs sm:text-sm font-bold text-slate-200 mt-1 max-w-[290px] mx-auto truncate" title="{{ $trx['title'] }}">
                {{ $trx['title'] }}
            </h4>
            <p class="text-[10px] text-slate-400 mt-1 font-medium flex items-center justify-center gap-1">
                <i class="fa-regular fa-clock text-[9px]"></i> {{ $trx['date'] }}
            </p>
        </div>

        <!-- Ticket Serrated Cutout Divider (DANA Style) -->
        <div class="relative my-4 border-b border-dashed border-white/15">
            <div class="absolute -left-7 -top-2.5 w-5 h-5 bg-[#0B1120] rounded-full border-r border-white/15"></div>
            <div class="absolute -right-7 -top-2.5 w-5 h-5 bg-[#0B1120] rounded-full border-l border-white/15"></div>
        </div>

        <!-- Detailed Breakdown Rows -->
        <div class="space-y-3 text-left text-xs relative z-10">

            <!-- ID Transaksi / Ref -->
            <div class="flex items-center justify-between gap-2">
                <span class="text-slate-400 text-[11px]">No. Referensi:</span>
                <div class="flex items-center gap-1.5">
                    <span class="font-mono font-bold text-white text-[11px] select-all bg-white/5 px-2 py-0.5 rounded border border-white/10">
                        #{{ $trx['ref_no'] }}
                    </span>
                    <button type="button" onclick="copyText('{{ $trx['ref_no'] }}', 'No. Referensi berhasil disalin!')" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-slate-400 hover:text-emerald-400 transition-colors" title="Salin ID">
                        <i class="fa-regular fa-copy text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Kategori -->
            <div class="flex items-center justify-between gap-2">
                <span class="text-slate-400 text-[11px]">Kategori Transaksi:</span>
                <span class="text-slate-200 font-semibold text-[11px] text-right truncate">
                    {{ $trx['category'] }}
                </span>
            </div>

            <!-- Metode Pembayaran -->
            <div class="flex items-center justify-between gap-2">
                <span class="text-slate-400 text-[11px]">Metode / Sumber Dana:</span>
                <span class="text-slate-200 font-semibold text-[11px] text-right truncate">
                    {{ $trx['method'] }}
                </span>
            </div>

            <!-- Nominal Transaksi -->
            <div class="flex items-center justify-between gap-2 pt-1 border-t border-white/5">
                <span class="text-slate-400 text-[11px]">Nominal Pokok:</span>
                <span class="text-white font-bold text-[11px] text-right">
                    {{ $trx['amount_formatted'] }}
                </span>
            </div>

            <!-- Total -->
            <div class="flex items-center justify-between gap-2">
                <span class="text-slate-300 font-bold text-xs">Total Pembayaran:</span>
                <span class="text-emerald-400 font-extrabold text-sm text-right">
                    {{ $trx['total_formatted'] }}
                </span>
            </div>

            <!-- Sisa Saldo (Jika ada) -->
            @if($trx['balance_after'])
            <div class="flex items-center justify-between gap-2 pt-1 border-t border-white/5">
                <span class="text-slate-400 text-[11px]">Sisa Saldo Setelahnya:</span>
                <span class="text-slate-200 font-semibold text-[11px] text-right">
                    {{ $trx['balance_after'] }}
                </span>
            </div>
            @endif

            <!-- Bukti Transfer Bank (Khusus Penarikan jika ada) -->
            @if($trx['proof_url'])
            <div class="flex items-center justify-between gap-2 pt-1 border-t border-white/5">
                <span class="text-slate-400 text-[11px]">Bukti Transfer Bank:</span>
                <a href="{{ $trx['proof_url'] }}" target="_blank" class="text-blue-400 hover:text-blue-300 font-semibold text-[11px] flex items-center gap-1">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Lihat Bukti Transfer
                </a>
            </div>
            @endif

            <!-- Catatan / Deskripsi -->
            @if($trx['notes'])
            <div class="pt-2 border-t border-white/5">
                <span class="text-slate-400 text-[10px] block mb-1 font-medium">Keterangan:</span>
                <p class="text-[11px] text-slate-300 italic bg-white/[0.04] p-2.5 rounded-xl border border-white/5 leading-relaxed">
                    {{ $trx['notes'] }}
                </p>
            </div>
            @endif

        </div>

        <!-- Footer Watermark Security -->
        <div class="mt-5 pt-3 border-t border-white/5 flex items-center justify-center gap-1.5 text-[9px] text-slate-400 font-medium">
            <i class="fa-solid fa-shield-halved text-emerald-400 text-[10px]"></i>
            <span>Bukti Transaksi Resmi • Dilindungi Enkripsi Scalify Partner</span>
        </div>

    </div>

    <!-- ACTION BUTTONS: Bagikan, Salin, Unduh -->
    <div class="space-y-2.5">
        <!-- 1. Tombol Utama: Bagikan Struk (Android & iOS Native Web Share) -->
        <button type="button" onclick="shareReceipt()" class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-400 hover:to-teal-400 text-white font-bold text-xs shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2 transition-all active:scale-[0.98] cursor-pointer">
            <i class="fa-solid fa-share-nodes text-xs"></i>
            <span>Bagikan Bukti Transaksi</span>
        </button>

        <!-- 2. Tombol Sekunder: Salin Teks Struk & Simpan Gambar PNG -->
        <div class="grid grid-cols-2 gap-2">
            <button type="button" onclick="copyReceiptAsText()" class="py-2.5 px-3 rounded-xl glass-panel hover:bg-white/10 text-slate-200 hover:text-white font-semibold text-[11px] flex items-center justify-center gap-1.5 transition-colors border border-white/10 active:scale-95 cursor-pointer">
                <i class="fa-solid fa-copy text-xs text-blue-400"></i>
                <span>Salin Teks Struk</span>
            </button>

            <button type="button" onclick="downloadReceiptImage()" class="py-2.5 px-3 rounded-xl glass-panel hover:bg-white/10 text-slate-200 hover:text-white font-semibold text-[11px] flex items-center justify-center gap-1.5 transition-colors border border-white/10 active:scale-95 cursor-pointer">
                <i class="fa-solid fa-download text-xs text-emerald-400"></i>
                <span>Simpan Gambar</span>
            </button>
        </div>

        <!-- 3. Kembali ke Riwayat -->
        <a href="{{ route('affiliate.history') }}" class="w-full py-2.5 rounded-xl border border-white/5 bg-white/[0.02] hover:bg-white/5 text-slate-400 hover:text-slate-200 text-center font-bold text-xs flex items-center justify-center gap-1.5 transition-all active:scale-95">
            <i class="fa-solid fa-clock-rotate-left text-[11px]"></i>
            <span>Kembali ke Riwayat Transaksi</span>
        </a>
    </div>

    @endif

    <!-- Toast Notification Element -->
    <div id="receiptToast" class="fixed top-5 left-1/2 -translate-x-1/2 z-[999] px-4 py-2.5 rounded-2xl bg-slate-900/90 border border-emerald-500/40 text-emerald-300 text-xs font-bold shadow-2xl backdrop-blur-md transition-all duration-300 pointer-events-none opacity-0 -translate-y-4 flex items-center gap-2">
        <i class="fa-solid fa-circle-check text-emerald-400 text-xs"></i>
        <span id="receiptToastMsg">Berhasil!</span>
    </div>

    <!-- Client-Side Sharing & Canvas Download Script -->
    <script>
        function showReceiptToast(msg) {
            const toast = document.getElementById('receiptToast');
            const msgEl = document.getElementById('receiptToastMsg');
            if (!toast || !msgEl) return;

            msgEl.textContent = msg;
            toast.classList.remove('opacity-0', '-translate-y-4');
            clearTimeout(window.__receiptToastTimeout);
            window.__receiptToastTimeout = setTimeout(() => {
                toast.classList.add('opacity-0', '-translate-y-4');
            }, 2500);
        }

        function copyText(str, successMsg = 'Teks berhasil disalin!') {
            navigator.clipboard.writeText(str).then(() => {
                showReceiptToast(successMsg);
            }).catch(() => {
                prompt('Salin teks:', str);
            });
        }

        function buildShareText() {
            @if($trx)
            return `==================================
🧾 BUKTI TRANSAKSI SCALIFY PAY
==================================
Status: {{ $trx['status'] }} ✅
Nominal: {{ $trx['type'] === 'CREDIT' ? '+' : '-' }}{{ $trx['amount_formatted'] }}
Total: {{ $trx['total_formatted'] }}
Kategori: {{ $trx['category'] }}
Deskripsi: {{ $trx['title'] }}
No. Ref: #{{ $trx['ref_no'] }}
Metode: {{ $trx['method'] }}
Waktu: {{ $trx['date'] }}
@if($trx['balance_after'])Sisa Saldo: {{ $trx['balance_after'] }}
@endif----------------------------------
Terverifikasi resmi oleh Scalify Partner Hub
https://scalify.id
==================================`;
            @else
            return '';
            @endif
        }

        function copyReceiptAsText() {
            const text = buildShareText();
            copyText(text, 'Seluruh teks bukti transaksi berhasil disalin!');
        }

        async function shareReceipt() {
            const shareText = buildShareText();
            const shareTitle = 'Bukti Transaksi Scalify Pay #' + @js($trx['ref_no'] ?? '');

            if (navigator.share) {
                try {
                    await navigator.share({
                        title: shareTitle
                        , text: shareText
                    , });
                    return;
                } catch (err) {
                    if (err.name === 'AbortError') return;
                }
            }

            // Fallback WhatsApp
            const waUrl = 'https://wa.me/?text=' + encodeURIComponent(shareText);
            window.open(waUrl, '_blank');
        }

        function downloadReceiptImage() {
            @if($trx)
            const canvas = document.createElement('canvas');
            canvas.width = 640;
            canvas.height = 760;
            const ctx = canvas.getContext('2d');
            const trx = @js($trx);

            // 1. Background
            ctx.fillStyle = '#0B1120';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // 2. Card Background
            ctx.fillStyle = '#111827';
            roundRect(ctx, 30, 30, 580, 700, 24);
            ctx.fill();

            ctx.strokeStyle = 'rgba(255, 255, 255, 0.12)';
            ctx.lineWidth = 2;
            roundRect(ctx, 30, 30, 580, 700, 24);
            ctx.stroke();

            // 3. Header Scalify Pay
            ctx.fillStyle = '#10B981';
            ctx.font = 'bold 22px Inter, sans-serif';
            ctx.fillText('SCALIFY PAY', 60, 80);

            ctx.fillStyle = '#94A3B8';
            ctx.font = '14px Inter, sans-serif';
            ctx.fillText('BUKTI TRANSAKSI RESMI', 410, 80);

            // Header separator
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
            ctx.beginPath();
            ctx.moveTo(60, 105);
            ctx.lineTo(580, 105);
            ctx.stroke();

            // 4. Status Checkmark Pill
            ctx.fillStyle = 'rgba(16, 185, 129, 0.15)';
            roundRect(ctx, 210, 130, 220, 34, 17);
            ctx.fill();
            ctx.strokeStyle = 'rgba(16, 185, 129, 0.4)';
            ctx.stroke();

            ctx.fillStyle = '#34D399';
            ctx.font = 'bold 14px Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText('✔ ' + trx.status, 320, 153);

            // 5. Hero Amount
            ctx.fillStyle = trx.type === 'CREDIT' ? '#34D399' : '#F87171';
            ctx.font = '900 36px Inter, sans-serif';
            ctx.fillText((trx.type === 'CREDIT' ? '+ ' : '- ') + trx.amount_formatted, 320, 215);

            ctx.fillStyle = '#E2E8F0';
            ctx.font = 'bold 16px Inter, sans-serif';
            ctx.fillText(trx.title, 320, 245);

            ctx.fillStyle = '#94A3B8';
            ctx.font = '13px Inter, sans-serif';
            ctx.fillText(trx.date, 320, 270);

            // 6. Dashed line divider
            ctx.setLineDash([8, 6]);
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.2)';
            ctx.beginPath();
            ctx.moveTo(60, 305);
            ctx.lineTo(580, 305);
            ctx.stroke();
            ctx.setLineDash([]); // Reset dash

            // 7. Details Table
            ctx.textAlign = 'left';
            let y = 350;
            const drawRow = (label, val, isBold = false, color = '#FFFFFF') => {
                ctx.fillStyle = '#94A3B8';
                ctx.font = '14px Inter, sans-serif';
                ctx.fillText(label, 60, y);

                ctx.fillStyle = color;
                ctx.font = (isBold ? 'bold ' : '') + '14px Inter, sans-serif';
                ctx.textAlign = 'right';
                ctx.fillText(val, 580, y);
                ctx.textAlign = 'left';
                y += 38;
            };

            drawRow('No. Referensi:', '#' + trx.ref_no, true);
            drawRow('Kategori:', trx.category, false);
            drawRow('Metode Pembayaran:', trx.method, false);
            drawRow('Nominal Transaksi:', trx.amount_formatted, true);
            drawRow('Total Pembayaran:', trx.total_formatted, true, '#34D399');
            if (trx.balance_after) {
                drawRow('Sisa Saldo Setelahnya:', trx.balance_after, false, '#E2E8F0');
            }

            // 8. Footer Shield
            ctx.textAlign = 'center';
            ctx.fillStyle = '#64748B';
            ctx.font = '12px Inter, sans-serif';
            ctx.fillText('🔒 Terverifikasi Resmi • Scalify Partner Financial Hub (scalify.id)', 320, 680);

            // Download trigger
            const link = document.createElement('a');
            link.download = 'Struk-Transaksi-' + trx.ref_no + '.png';
            link.href = canvas.toDataURL('image/png');
            link.click();

            showReceiptToast('Gambar bukti transaksi berhasil diunduh!');
            @endif
        }

        function roundRect(ctx, x, y, width, height, radius) {
            ctx.beginPath();
            ctx.moveTo(x + radius, y);
            ctx.lineTo(x + width - radius, y);
            ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
            ctx.lineTo(x + width, y + height - radius);
            ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
            ctx.lineTo(x + radius, y + height);
            ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
            ctx.lineTo(x, y + radius);
            ctx.quadraticCurveTo(x, y, x + radius, y);
            ctx.closePath();
        }

    </script>
</div>
