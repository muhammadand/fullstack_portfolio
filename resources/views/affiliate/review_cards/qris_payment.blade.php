<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Pembayaran QRIS - {{ $orderId }}</title>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <x-affiliate.pwa-meta />
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
            background-image: radial-gradient(circle at 0 50%, transparent 8px, #ffffff 9px), radial-gradient(circle at 100% 50%, transparent 8px, #ffffff 9px);
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
<body class="pb-20 overflow-x-hidden min-h-screen flex flex-col relative">

    <!-- Ambient Glow Background -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-blue-600/15 rounded-full blur-[120px] pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-5">

        <!-- Top Navigation Bar -->
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('affiliate.review_cards.index') }}" class="w-9 h-9 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>

            <div class="text-center">
                <span class="text-xs font-semibold text-slate-200">Checkout Kuota QR</span>
                <p class="text-[10px] text-slate-400 font-mono leading-none mt-0.5">#{{ $orderId }}</p>
            </div>

            <!-- Countdown Timer Chip -->
            <div id="timerBadge" class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-300 text-[11px] font-mono font-medium">
                <i class="fa-regular fa-clock text-[10px]"></i>
                <span id="countdownText">15:00</span>
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
                            {{ $orderData['merchant_name'] ?? 'SCALIFY INDONESIA' }}
                        </h2>
                        <p class="text-[10px] text-slate-500 font-mono">NMID: ID1021058777975</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] font-semibold text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded">
                            A01 &bull; DANA
                        </span>
                    </div>
                </div>
            </div>

            <!-- QR Code Center Display -->
            <div class="p-5 text-center bg-white flex flex-col items-center">
                <!-- QR Frame with Corner Highlights -->
                <div class="relative p-2.5 bg-white rounded-2xl border-2 border-slate-200 shadow-sm inline-block">
                    <!-- Corner Marks -->
                    <div class="absolute -top-1 -left-1 w-4 h-4 border-t-2 border-l-2 border-slate-800 rounded-tl"></div>
                    <div class="absolute -top-1 -right-1 w-4 h-4 border-t-2 border-r-2 border-slate-800 rounded-tr"></div>
                    <div class="absolute -bottom-1 -left-1 w-4 h-4 border-b-2 border-l-2 border-slate-800 rounded-bl"></div>
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 border-b-2 border-r-2 border-slate-800 rounded-br"></div>

                    <!-- The Dynamic QR Image -->
                    <img id="qrisImage" src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&margin=4&data={{ urlencode($orderData['qris_payload'] ?? '') }}" alt="QRIS Code" class="w-56 h-56 object-contain rounded-lg">
                </div>

                <!-- Supported Apps Carousel / Chips -->
                <p class="text-[11px] text-slate-500 font-medium mt-3 mb-2">
                    Mendukung seluruh pembayaran digital Indonesia:
                </p>
                <div class="flex flex-wrap items-center justify-center gap-1 text-[10px] text-slate-600 font-semibold">
                    <span class="px-2 py-0.5 rounded-md bg-slate-100">BCA</span>
                    <span class="px-2 py-0.5 rounded-md bg-slate-100">Mandiri</span>
                    <span class="px-2 py-0.5 rounded-md bg-slate-100">BRI</span>
                    <span class="px-2 py-0.5 rounded-md bg-slate-100">BNI</span>
                    <span class="px-2 py-0.5 rounded-md bg-slate-100">DANA</span>
                    <span class="px-2 py-0.5 rounded-md bg-slate-100">GoPay</span>
                    <span class="px-2 py-0.5 rounded-md bg-slate-100">OVO</span>
                    <span class="px-2 py-0.5 rounded-md bg-slate-100">ShopeePay</span>
                </div>
            </div>

            <!-- Perforated Ticket Divider -->
            <div class="relative py-1 bg-white">
                <div class="dashed-line mx-4"></div>
            </div>

            <!-- Nominal Transfer Section -->
            <div class="p-5 bg-slate-50/70 text-center">
                <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">Total Pembayaran</span>

                <!-- Prominent Amount with Quick Copy -->
                <div class="my-1 flex items-center justify-center gap-2">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight font-sans">
                        Rp {{ number_format($orderData['total_amount'] ?? 0, 0, ',', '.') }}
                    </span>
                    <button type="button" onclick="copyAmount('{{ $orderData['total_amount'] ?? 0 }}')" class="w-8 h-8 rounded-lg bg-slate-200/80 hover:bg-slate-300 text-slate-700 flex items-center justify-center transition-colors active:scale-95" title="Salin Nominal">
                        <i class="fa-regular fa-copy text-xs"></i>
                    </button>
                </div>

                <p class="text-[11px] text-slate-500 mt-1">
                    Pastikan transfer tepat hingga digit terakhir agar verifikasi otomatis.
                </p>
            </div>
        </div>

        <!-- Rincian Pembayaran (Fintech Style Breakdown) -->
        <div class="glass-panel rounded-2xl p-4 mb-4 text-xs space-y-2.5">
            <div class="flex items-center justify-between text-slate-400">
                <span>Paket Pesanan</span>
                <span class="text-slate-200 font-medium">{{ $orderData['quantity'] ?? 1 }} Unit Review Card</span>
            </div>

            <div class="flex items-center justify-between text-slate-400">
                <span>Harga Produk</span>
                <span class="text-slate-200">Rp {{ number_format($orderData['base_amount'] ?? 0, 0, ',', '.') }}</span>
            </div>

            <div class="flex items-center justify-between text-slate-400">
                <span>Biaya Admin</span>
                <span class="text-slate-200">Rp {{ number_format($orderData['unique_code'] ?? 0, 0, ',', '.') }}</span>
            </div>

            <div class="flex items-center justify-between border-t border-white/10 pt-2.5 text-sm font-semibold">
                <span class="text-white">Total Tagihan</span>
                <span class="text-emerald-400 font-bold">Rp {{ number_format($orderData['total_amount'] ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Petunjuk Singkat -->
        <div class="glass-panel rounded-2xl p-3.5 mb-5 text-xs text-slate-300">
            <h3 class="font-semibold text-white mb-2 flex items-center gap-1.5 text-xs">
                <i class="fa-solid fa-circle-info text-blue-400 text-xs"></i>
                Cara Pembayaran:
            </h3>
            <ol class="list-decimal list-inside space-y-1 text-[11px] text-slate-400 leading-relaxed">
                <li>Buka aplikasi m-Banking atau E-Wallet pilihan Anda.</li>
                <li>Pilih menu <b>Scan / Bayar QRIS</b> dan arahkan ke kode QR.</li>
                <li>Pastikan nominal transfer sesuai dengan total tagihan.</li>
                <li>Selesaikan pembayaran, lalu klik tombol di bawah.</li>
            </ol>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-2.5">
            <a href="{{ route('affiliate.review_cards.index') }}" class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold text-xs rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-blue-600/25 transition-all active:scale-98">
                <i class="fa-solid fa-check"></i>
                <span>Saya Sudah Bayar</span>
            </a>

            <div class="grid grid-cols-2 gap-2">
                <!-- Download QR Button -->
                <a href="https://api.qrserver.com/v1/create-qr-code/?size=600x600&margin=10&data={{ urlencode($orderData['qris_payload'] ?? '') }}" download="QRIS-Scalify-{{ $orderId }}.png" target="_blank" class="py-2.5 px-3 rounded-xl glass-panel text-slate-300 hover:text-white font-medium text-xs flex items-center justify-center gap-1.5 transition-colors">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>Simpan QR</span>
                </a>

                <!-- Bantuan Admin WhatsApp -->
                <a href="https://wa.me/6285221694067?text={{ urlencode('Halo Admin Scalify, saya sudah melakukan pembayaran QRIS untuk pesanan ' . $orderId . ' sebesar Rp ' . number_format($orderData['total_amount'] ?? 0, 0, ',', '.') . '. Mohon bantu verifikasi ya.') }}" target="_blank" class="py-2.5 px-3 rounded-xl glass-panel text-emerald-400 hover:text-emerald-300 font-medium text-xs flex items-center justify-center gap-1.5 transition-colors">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Konfirmasi WA</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Script Copy & Countdown Timer -->
    <script>
        function copyAmount(val) {
            navigator.clipboard.writeText(val).then(() => {
                alert('Nominal Rp ' + Number(val).toLocaleString('id-ID') + ' berhasil disalin!');
            }).catch(() => {
                prompt('Salin nominal berikut:', val);
            });
        }

        // 15 Minutes Expiration Countdown
        (function() {
            let duration = 15 * 60;
            const timerEl = document.getElementById('countdownText');

            const interval = setInterval(() => {
                const minutes = Math.floor(duration / 60);
                const seconds = duration % 60;

                timerEl.textContent =
                    String(minutes).padStart(2, '0') + ':' +
                    String(seconds).padStart(2, '0');

                if (--duration < 0) {
                    clearInterval(interval);
                    timerEl.textContent = 'Kedaluwarsa';
                    document.getElementById('timerBadge').className = 'flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-[11px] font-mono font-medium';
                }
            }, 1000);
        })();

    </script>

</body>
</html>
