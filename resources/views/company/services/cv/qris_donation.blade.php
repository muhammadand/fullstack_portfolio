<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Pembayaran Donasi QRIS - {{ $orderId }}</title>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #070B14;
            color: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        .ticket-divider {
            position: relative;
            background-image: radial-gradient(circle at 0 50%, transparent 10px, #ffffff 11px), radial-gradient(circle at 100% 50%, transparent 10px, #ffffff 11px);
            background-size: 100% 100%;
        }
        .dashed-line {
            border-bottom: 2px dashed #E2E8F0;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="pb-16 overflow-x-hidden min-h-screen flex flex-col relative">

    <!-- Ambient Glow Background -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-amber-500/15 rounded-full blur-[120px] pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-5">

        <!-- Top Navigation Bar -->
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('layanan.cv') }}" class="w-9 h-9 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95" title="Kembali ke CV Builder">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>

            <div class="text-center">
                <span class="text-xs font-semibold text-slate-200">Donasi Si Oyen Pejuang Loker</span>
                <p class="text-[10px] text-slate-400 font-mono leading-none mt-0.5">#{{ $orderId }}</p>
            </div>

            <!-- Countdown Timer Chip -->
            <div id="timerBadge" class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-300 text-[11px] font-mono font-medium">
                <i class="fa-regular fa-clock text-[10px]"></i>
                <span id="countdownText">30:00</span>
            </div>
        </div>

        <!-- Official QRIS Ticket Card (White Canvas) -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden text-slate-900 border border-slate-100 mb-5">

            <!-- Card Header: Official QRIS & GPN Branding -->
            <div class="p-4 pb-3 bg-gradient-to-b from-slate-50 to-white border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <!-- Official QRIS Logo -->
                    <div class="flex items-center gap-2">
                        <div class="flex items-center tracking-tighter font-extrabold text-slate-900 leading-none">
                            <span class="text-red-600 text-lg font-black">Q</span>
                            <span class="text-slate-900 text-lg font-black tracking-tight">RIS</span>
                        </div>
                        <span class="text-[9px] font-semibold text-slate-400 border-l border-slate-200 pl-2 uppercase tracking-wider leading-tight">
                            Quick Response Code<br>Indonesian Standard
                        </span>
                    </div>

                    <!-- GPN Logo Badge -->
                    <div class="flex items-center gap-1 bg-red-600 text-white text-[9px] font-black px-2 py-0.5 rounded tracking-wider shadow-xs">
                        <span>GPN</span>
                    </div>
                </div>

                <!-- Merchant Name & NMID -->
                <div class="mt-3 pt-2.5 border-t border-slate-100/80 flex items-center justify-between text-left">
                    <div>
                        <h2 class="text-xs font-bold text-slate-800 tracking-tight uppercase">
                            {{ $qrisData['merchant_name'] ?? 'SCALIFY / SI OYEN PEJUANG LOKER' }}
                        </h2>
                        <p class="text-[10px] text-slate-500 font-mono">NMID: ID1021058777975</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] font-semibold text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded">
                            DANA &bull; QRIS
                        </span>
                    </div>
                </div>
            </div>

            <!-- QR Code Centerpiece Canvas -->
            <div class="p-5 flex flex-col items-center justify-center bg-white">
                <div class="relative p-2 bg-white rounded-2xl border-2 border-slate-900/10 shadow-sm flex items-center justify-center">
                    <img src="{{ $qrisData['qris_image_url'] ?? '' }}" alt="QRIS Donasi Si Oyen" class="w-56 h-56 sm:w-64 sm:h-64 object-contain select-none">
                </div>
                <p class="text-[11px] text-slate-500 mt-2 font-medium flex items-center gap-1">
                    <i class="fa-solid fa-qrcode text-[11px]"></i>
                    <span>Scan menggunakan m-Banking atau e-Wallet apapun</span>
                </p>
            </div>

            <!-- Ticket Divider -->
            <div class="ticket-divider h-5 flex items-center justify-center px-4">
                <div class="dashed-line w-full"></div>
            </div>

            <!-- Payment Details & Unique Amount -->
            <div class="p-4 pt-2 bg-slate-50/60">
                <div class="p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/25 text-center">
                    <span class="text-[10px] font-bold uppercase text-amber-800 tracking-wider">Total Pembayaran Donasi</span>
                    <div class="flex items-center justify-center gap-2 mt-1">
                        <span class="text-2xl font-black text-amber-600 font-mono">
                            Rp {{ number_format($qrisData['total_amount'] ?? 0, 0, ',', '.') }}
                        </span>
                        <button type="button" onclick="copyAmount('{{ $qrisData['total_amount'] ?? 0 }}')" id="btnCopyAmount" class="px-2.5 py-1 rounded-lg bg-amber-200 hover:bg-amber-300 text-amber-900 text-xs font-bold transition flex items-center gap-1 active:scale-95">
                            <i class="fa-regular fa-copy"></i>
                            <span id="copyLabel">Salin</span>
                        </button>
                    </div>
                    <p class="text-[10px] text-amber-900/80 font-medium mt-1.5 leading-tight flex items-center justify-center gap-1">
                        <i class="fa-solid fa-triangle-exclamation text-amber-600 text-[10px]"></i>
                        <span>Transfer <strong>persis sampai 3 digit terakhir</strong> agar terverifikasi otomatis.</span>
                    </p>
                </div>

                <div class="mt-3 space-y-1.5 text-xs text-slate-600">
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span class="text-slate-400">Donatur:</span>
                        <span class="font-semibold text-slate-800">{{ $donorName ?? 'Sahabat Si Oyen' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span class="text-slate-400">ID Transaksi:</span>
                        <span class="font-mono text-slate-800">{{ $orderId }}</span>
                    </div>
                </div>
            </div>

            <!-- Supported Channels Footer -->
            <div class="p-3 bg-slate-100/80 border-t border-slate-200 text-center">
                <p class="text-[10px] text-slate-500 font-medium leading-relaxed">
                    BCA Mobile &bull; Livin' Mandiri &bull; BRImo &bull; BNI &bull; GoPay &bull; OVO &bull; DANA &bull; ShopeePay
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-2.5">
            <!-- WhatsApp Confirmation -->
            <a href="https://wa.me/6285254009888?text={{ urlencode('Halo Tim Scalify! Saya sudah transfer donasi via QRIS Dinamis sebesar Rp ' . number_format($qrisData['total_amount'] ?? 0, 0, ',', '.') . ' (ID: ' . $orderId . '). Semangat terus untuk pengembangan platform CV gratis!') }}" target="_blank" rel="noopener noreferrer" class="w-full py-3.5 px-4 rounded-xl font-bold text-xs sm:text-sm text-slate-950 flex items-center justify-center gap-2 transition hover:scale-[1.01] shadow-lg shadow-emerald-500/20 bg-emerald-400 hover:bg-emerald-300">
                <i class="fa-brands fa-whatsapp text-base"></i>
                <span>Konfirmasi Pembayaran via WhatsApp</span>
            </a>

            <!-- Download QR Code Image -->
            @if(!empty($qrisData['qris_image_url']))
            <a href="{{ $qrisData['qris_image_url'] }}" target="_blank" download="qris-donasi-{{ $orderId }}.png" class="w-full py-2.5 px-4 rounded-xl font-semibold text-xs text-white/80 glass-panel hover:bg-white/10 flex items-center justify-center gap-2 transition">
                <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i>
                <span>Unduh / Tampilkan QRIS Layar Penuh</span>
            </a>
            @endif

            <!-- Back to CV Builder -->
            <a href="{{ route('layanan.cv') }}" class="w-full py-2.5 px-4 rounded-xl font-semibold text-xs text-white/50 hover:text-white flex items-center justify-center gap-1.5 transition">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Halaman Template CV</span>
            </a>
        </div>

    </div>

    <script>
        // Countdown timer 30 minutes
        let remaining = 1800;
        const countdownEl = document.getElementById('countdownText');
        const timer = setInterval(() => {
            if (remaining <= 0) {
                clearInterval(timer);
                countdownEl.textContent = 'Kadaluarsa';
                return;
            }
            remaining--;
            const m = Math.floor(remaining / 60);
            const s = remaining % 60;
            countdownEl.textContent = `${m < 10 ? '0' : ''}${m}:${s < 10 ? '0' : ''}${s}`;
        }, 1000);

        function copyAmount(amount) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(amount);
            } else {
                const ta = document.createElement('textarea');
                ta.value = amount;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
            }
            const label = document.getElementById('copyLabel');
            label.textContent = 'Tersalin!';
            setTimeout(() => { label.textContent = 'Salin'; }, 2000);
        }
    </script>
</body>
</html>
