<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Akses Login - Mobile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative">

    <!-- Background Decoration -->
    <div class="fixed top-0 right-0 w-full h-64 bg-purple-600/10 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <p class="text-xs text-purple-400 font-medium tracking-wider uppercase">Keamanan</p>
                <h1 class="text-xl font-bold text-white">Akses Login</h1>
            </div>
        </div>

        <div class="glass-panel rounded-3xl p-6 flex flex-col items-center mb-6">
            <div class="w-16 h-16 bg-purple-500/20 text-purple-400 rounded-full flex items-center justify-center text-2xl mb-4">
                <i class="fa-solid fa-qrcode"></i>
            </div>

            <h2 class="text-lg font-bold text-white mb-2">Magic Login Link</h2>
            <p class="text-xs text-slate-400 text-center mb-6 leading-relaxed">
                Scan QR ini atau salin tautan di bawah untuk masuk ke akun Anda dari perangkat lain tanpa perlu memasukkan kata sandi. <b>Berlaku selamanya.</b>
            </p>

            <div class="bg-white p-4 rounded-2xl mb-6 shadow-xl relative overflow-hidden">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($magicLoginUrl) }}" alt="QR Login" class="w-48 h-48 rounded-lg">
            </div>

            <div class="w-full glass-panel p-4 rounded-xl flex items-center justify-between gap-3">
                <div class="truncate flex-1 text-sm font-medium text-purple-300">
                    {{ $magicLoginUrl }}
                </div>
                <button onclick="copyLoginLink()" class="w-12 h-12 rounded-xl bg-purple-500 hover:bg-purple-600 shadow-lg shadow-purple-500/30 text-white flex items-center justify-center shrink-0 transition-colors">
                    <i class="fa-solid fa-copy"></i>
                </button>
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-4 flex gap-3">
            <div class="text-yellow-400 mt-0.5">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <p class="text-[10px] text-slate-400 leading-relaxed">
                <b>Peringatan Keamanan:</b> Jangan bagikan QR Code atau link ini kepada orang yang tidak Anda kenal. Siapapun yang memiliki link ini dapat mengakses seluruh informasi akun afiliasi Anda, termasuk data komisi.
            </p>
        </div>

    </div>

    <!-- Hidden input for copying text -->
    <input type="text" readonly value="{{ $magicLoginUrl }}" class="absolute -left-[9999px] opacity-0" id="login-link-input">

    <script>
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = 'fixed top-10 left-1/2 -translate-x-1/2 px-5 py-3 rounded-full shadow-2xl z-[80] flex items-center gap-3 text-sm font-medium transition-all duration-500 transform -translate-y-10 opacity-0 min-w-[280px] max-w-[90vw] justify-center bg-slate-800 border border-emerald-500/30 text-white';
            toast.innerHTML = `<div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0"><i class="fa-solid fa-check text-xs"></i></div> <span class="truncate">${message}</span>`;

            document.body.appendChild(toast);
            setTimeout(() => toast.classList.remove('-translate-y-10', 'opacity-0'), 10);
            setTimeout(() => {
                toast.classList.add('-translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        function copyLoginLink() {
            var copyText = document.getElementById("login-link-input");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            showToast('Link Akses Login berhasil disalin!');
        }

    </script>
</body>
</html>
