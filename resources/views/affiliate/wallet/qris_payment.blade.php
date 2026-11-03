<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Pembayaran QRIS - {{ $deposit->deposit_no }}</title>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <x-affiliate.pwa-meta />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(15, 23, 42, 0.6));
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

    </style>
</head>
<body class="min-h-screen bg-[#0B1120] text-white flex flex-col justify-between overflow-x-hidden relative px-4 pt-4 pb-24 sm:pt-6">

    <x-affiliate.page-loader />

    <!-- Ambient Glow Backgrounds -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-96 h-80 bg-emerald-600/15 rounded-full blur-[120px] pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-0 w-80 h-80 bg-blue-600/10 rounded-full blur-[100px] pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-sm mx-auto flex flex-col justify-between flex-1">

        <!-- 1. TOP BAR (COMPACT) -->
        <header class="flex items-center justify-between mb-3">
            <a href="{{ route('affiliate.dashboard') }}" class="w-8 h-8 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95" title="Kembali ke Dashboard">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>

            <div class="text-center">
                <h1 class="text-xs font-bold text-white tracking-wide flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-qrcode text-emerald-400"></i> Pembayaran QRIS
                </h1>
                <p class="text-[9px] text-slate-400 font-mono mt-0.5">#{{ $deposit->deposit_no }}</p>
            </div>

            <!-- Countdown Timer Chip -->
            <div id="timerBadge" class="flex items-center gap-1 px-2 py-1 rounded-lg bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-[10px] font-mono font-bold">
                <i class="fa-regular fa-clock text-[9px]"></i>
                <span id="countdownText">15:00</span>
            </div>
        </header>

        <!-- 2. TOTAL TAGIHAN HERO CARD (COMPACT GLASS) -->
        <div class="glass-card rounded-2xl p-3 mb-3 border border-emerald-500/30 bg-gradient-to-r from-emerald-950/30 via-slate-900/80 to-slate-900/90 flex items-center justify-between gap-3 shadow-lg shadow-emerald-950/20">
            <div>
                <p class="text-[10px] font-semibold text-emerald-300 uppercase tracking-wider flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Total Tagihan
                </p>
                <div class="text-2xl font-black text-white tracking-tight mt-0.5 flex items-baseline">
                    <span class="text-xs text-emerald-400 font-bold mr-1">Rp</span>{{ number_format($deposit->total_amount, 0, ',', '.') }}
                </div>
                <p class="text-[9px] text-slate-400 mt-0.5">Saldo Rp {{ number_format($deposit->amount, 0, ',', '.') }} • Admin 2% Rp {{ number_format($deposit->fee, 0, ',', '.') }}</p>
            </div>

            <!-- Tombol Salin Nominal -->
            <button type="button" onclick="copyAmount('{{ (int)$deposit->total_amount }}')" class="px-3 py-2 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/40 text-emerald-300 text-xs font-bold flex items-center gap-1.5 transition-all active:scale-95 shrink-0" title="Salin Nominal Persis">
                <i class="fa-solid fa-copy text-xs"></i>
                <span class="text-[11px]">Salin</span>
            </button>
        </div>

        <!-- 3. QR CODE CENTERPIECE (PREMIUM GLASS CARD) -->
        <div class="glass-card rounded-3xl p-4 mb-3 text-center border border-white/10 flex flex-col items-center justify-center relative overflow-hidden">
            <!-- Brand & NMID Header Inside Card -->
            <div class="flex items-center justify-between w-full mb-2.5 px-1 text-[10px]">
                <div class="flex items-center gap-1.5">
                    <span class="text-emerald-400 font-bold">QRIS STANDAR NASIONAL</span>
                </div>
                <span class="text-[9px] font-mono text-slate-400 bg-white/5 px-2 py-0.5 rounded-full border border-white/5">
                    NMID: ID1021058777975
                </span>
            </div>

            <!-- The QR Code Image Frame (Crisp White Square for Scanning) -->
            <div class="relative p-2.5 bg-white rounded-2xl shadow-xl inline-block my-1 border border-white/20">
                <!-- Outer Corner Marks -->
                <div class="absolute -top-1 -left-1 w-3.5 h-3.5 border-t-2 border-l-2 border-emerald-400 rounded-tl"></div>
                <div class="absolute -top-1 -right-1 w-3.5 h-3.5 border-t-2 border-r-2 border-emerald-400 rounded-tr"></div>
                <div class="absolute -bottom-1 -left-1 w-3.5 h-3.5 border-b-2 border-l-2 border-emerald-400 rounded-bl"></div>
                <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 border-b-2 border-r-2 border-emerald-400 rounded-br"></div>

                <!-- QR Image -->
                <img id="qrisImage" src="{{ $qrImageUrl }}" alt="QRIS Code" class="w-44 h-44 sm:w-48 sm:h-48 object-contain rounded-lg">
            </div>

            <!-- Supported Banking & E-Wallets Badges -->
            <div class="mt-2 text-center">
                <p class="text-[9px] text-slate-400 mb-1 font-medium">Scan pakai aplikasi perbankan atau e-wallet apa saja:</p>
                <div class="flex flex-wrap items-center justify-center gap-1 text-[8px] font-bold text-slate-300">
                    <span class="px-1.5 py-0.5 rounded bg-white/5 border border-white/10">BCA</span>
                    <span class="px-1.5 py-0.5 rounded bg-white/5 border border-white/10">Mandiri</span>
                    <span class="px-1.5 py-0.5 rounded bg-white/5 border border-white/10">BRI</span>
                    <span class="px-1.5 py-0.5 rounded bg-white/5 border border-white/10">BNI</span>
                    <span class="px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">DANA</span>
                    <span class="px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">GoPay</span>
                    <span class="px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">OVO</span>
                    <span class="px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">ShopeePay</span>
                </div>
            </div>

            <!-- Live Status Indicator -->
            <div class="mt-3 pt-2.5 border-t border-white/10 w-full flex items-center justify-center gap-2 text-[10px] text-slate-400">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping"></span>
                <span id="pollingStatusText">Menunggu pembayaran terdeteksi...</span>
            </div>
        </div>

        <!-- 4. BOTTOM ACTION BUTTONS (NO SCROLL REQUIRED) -->
        <div class="space-y-2 mt-auto pt-1">
            <!-- Primary Action: Cek Status -->
            <button type="button" id="btnCheckStatus" onclick="checkStatusManual()" class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-400 hover:to-teal-500 text-white font-bold text-xs shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2 transition-all active:scale-98 cursor-pointer">
                <i class="fa-solid fa-arrows-rotate text-xs" id="checkIcon"></i>
                <span id="checkText">Cek Status Pembayaran</span>
            </button>

            <!-- Secondary Actions: Simpan QR & Bantuan WA -->
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ $qrImageUrl }}" download="QRIS-Deposit-{{ $deposit->deposit_no }}.png" target="_blank" class="py-2 px-3 rounded-xl glass-panel hover:bg-white/10 text-slate-300 hover:text-white font-semibold text-[11px] flex items-center justify-center gap-1.5 transition-colors border border-white/10 text-center">
                    <i class="fa-solid fa-download text-[10px] text-emerald-400"></i>
                    <span>Simpan QR</span>
                </a>

                <a href="https://wa.me/6285221694067?text={{ urlencode('Halo Admin Scalify, saya sudah bayar QRIS untuk deposit saldo wallet #' . $deposit->deposit_no . ' sebesar Rp ' . number_format($deposit->total_amount, 0, ',', '.') . '. Mohon bantu cek ya.') }}" target="_blank" class="py-2 px-3 rounded-xl glass-panel hover:bg-white/10 text-emerald-400 hover:text-emerald-300 font-semibold text-[11px] flex items-center justify-center gap-1.5 transition-colors border border-emerald-500/20 text-center">
                    <i class="fa-brands fa-whatsapp text-xs"></i>
                    <span>Bantuan Admin</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Script Copy, Timer & Auto Polling -->
    <script>
        function copyAmount(val) {
            navigator.clipboard.writeText(val).then(() => {
                showToast('Nominal Rp ' + Number(val).toLocaleString('id-ID') + ' berhasil disalin!');
            }).catch(() => {
                prompt('Salin nominal berikut:', val);
            });
        }

        function showToast(msg) {
            const toast = document.createElement('div');
            toast.className = 'fixed top-5 left-1/2 -translate-x-1/2 px-4 py-2 rounded-full bg-slate-800 border border-emerald-500/50 text-white text-xs font-semibold shadow-2xl z-50 flex items-center gap-2';
            toast.innerHTML = '<i class="fa-solid fa-circle-check text-emerald-400"></i> <span>' + msg + '</span>';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2500);
        }

        // 15 Minutes Countdown Timer
        (function() {
            let duration = 15 * 60;
            const timerEl = document.getElementById('countdownText');

            const interval = setInterval(() => {
                const minutes = Math.floor(duration / 60);
                const seconds = duration % 60;

                if (timerEl) {
                    timerEl.textContent =
                        String(minutes).padStart(2, '0') + ':' +
                        String(seconds).padStart(2, '0');
                }

                if (--duration < 0) {
                    clearInterval(interval);
                    if (timerEl) timerEl.textContent = 'Kedaluwarsa';
                    const badge = document.getElementById('timerBadge');
                    if (badge) {
                        badge.className = 'flex items-center gap-1 px-2 py-1 rounded-lg bg-red-500/15 border border-red-500/30 text-red-400 text-[10px] font-mono font-bold';
                    }
                }
            }, 1000);
        })();

        // Check Payment Status (AJAX Auto Polling)
        const checkUrl = "{{ route('affiliate.wallet.deposit_check', $deposit->deposit_no) }}";
        const redirectUrl = "{{ route('affiliate.dashboard') }}";
        let isPolling = true;

        async function pollStatus() {
            if (!isPolling) return;
            try {
                const res = await fetch(checkUrl, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success && data.is_paid) {
                    isPolling = false;
                    document.getElementById('pollingStatusText').innerHTML = '<span class="text-emerald-400 font-bold">Pembayaran Berhasil! Mengalihkan...</span>';
                    alert('🎉 Pembayaran Berhasil! Saldo Rp ' + Number(data.amount).toLocaleString('id-ID') + ' telah masuk ke wallet Anda.');
                    window.location.href = redirectUrl;
                }
            } catch (err) {
                console.warn('Polling check error:', err);
            }
        }

        // Polling setiap 3.5 detik
        const pollInterval = setInterval(() => {
            if (!isPolling) {
                clearInterval(pollInterval);
                return;
            }
            pollStatus();
        }, 3500);

        async function checkStatusManual() {
            const btn = document.getElementById('btnCheckStatus');
            const icon = document.getElementById('checkIcon');
            const text = document.getElementById('checkText');

            icon.classList.add('fa-spin');
            text.textContent = 'Memeriksa...';
            btn.disabled = true;

            try {
                const res = await fetch(checkUrl, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success && data.is_paid) {
                    isPolling = false;
                    text.textContent = 'Lunas!';
                    alert('🎉 Pembayaran Berhasil! Saldo Rp ' + Number(data.amount).toLocaleString('id-ID') + ' telah masuk ke wallet Anda.');
                    window.location.href = redirectUrl;
                } else {
                    alert('Pembayaran belum terdeteksi. Pastikan transfer QRIS Anda sudah selesai lalu coba lagi beberapa detik kemudian.');
                }
            } catch (err) {
                alert('Gagal memeriksa status. Silakan coba kembali.');
            } finally {
                icon.classList.remove('fa-spin');
                text.textContent = 'Cek Status Pembayaran';
                btn.disabled = false;
            }
        }

    </script>

    <!-- Bottom Navigation Bar -->
    <x-affiliate.bottom-nav />

</body>
</html>
