<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Google Review Card - Scalify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }

        @keyframes pulseCheck {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-check {
            animation: pulseCheck 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col justify-between p-4 sm:p-6" style="background-color: #0F172A;">

    <div class="max-w-md w-full mx-auto my-auto">

        <!-- Form Card Container (Visible by default) -->
        <div id="activationCard" class="bg-slate-800/90 rounded-3xl p-6 sm:p-8 border border-slate-700/60 shadow-2xl backdrop-blur-xl relative overflow-hidden transition-all duration-300" style="background-color: rgba(30, 41, 59, 0.75);">

            <!-- Rainbow Accent Line at Top -->
            <div class="absolute top-0 left-0 right-0 h-1.5 flex">
                <div class="flex-1" style="background-color: #4285F4;"></div>
                <div class="flex-1" style="background-color: #34A853;"></div>
                <div class="flex-1" style="background-color: #FBBC05;"></div>
                <div class="flex-1" style="background-color: #EA4335;"></div>
            </div>

            <!-- Top Header -->
            <div class="text-center pt-2 mb-6">
                <!-- Google G Logo -->
                <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center p-2 rounded-2xl bg-white/5 border border-white/10 shadow-inner">
                    <svg class="w-full h-full" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                    </svg>
                </div>

                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-mono font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    SN: {{ $card->serial_number }}
                </span>

                <h1 class="text-xl sm:text-2xl font-bold text-white font-outfit">
                    Aktivasi Kartu Review Anda
                </h1>
                <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">
                    Tempelkan link Google Review usaha Anda agar setiap scan langsung mengarah ke halaman ulasan.
                </p>
            </div>

            <!-- Dynamic Error Notification Box -->
            <div id="errorAlertBox" class="{{ session('error') ? '' : 'hidden' }} p-3.5 rounded-xl bg-red-500/15 border border-red-500/30 text-red-300 text-xs flex items-center gap-2.5 mb-5" role="alert">
                <i class="fa-solid fa-triangle-exclamation text-red-400 text-sm flex-shrink-0"></i>
                <span id="errorMessageText">{{ session('error') }}</span>
            </div>

            <!-- Form Aktivasi -->
            <form id="activationForm" action="{{ route('review_cards.activate', $card->slug) }}" method="POST" class="space-y-4">
                @csrf

                <!-- PIN Aktivasi -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Kode PIN Aktivasi</span>
                        <span class="text-[11px] text-amber-400 font-normal">Lihat di stiker / kemasan</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-key text-xs"></i>
                        </span>
                        <input type="text" id="inputPin" name="pin" value="{{ old('pin') }}" required placeholder="Contoh: 847291" maxlength="16" autocomplete="off" class="w-full pl-10 pr-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-white font-mono text-sm tracking-wider focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder:text-slate-600">
                    </div>
                </div>

                <!-- Nama Tempat Bisnis -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">
                        Nama Tempat Usaha / Kafe
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-store text-xs"></i>
                        </span>
                        <input type="text" id="inputBusinessName" name="business_name" value="{{ old('business_name') }}" required placeholder="Contoh: Kopi Kenangan Cabang Tebet" class="w-full pl-10 pr-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder:text-slate-600">
                    </div>
                </div>

                <!-- Link Google Review -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Link Google Review</span>
                        <button type="button" onclick="document.getElementById('tutorialModal').classList.remove('hidden')" class="text-[11px] text-blue-400 hover:underline">
                            Cara dapatkan link?
                        </button>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-link text-xs"></i>
                        </span>
                        <input type="url" id="inputGoogleReviewUrl" name="google_review_url" value="{{ old('google_review_url') }}" required placeholder="https://g.page/r/... atau https://maps.app.goo.gl/..." class="w-full pl-10 pr-4 py-2.5 bg-slate-900/80 border border-slate-700 rounded-xl text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder:text-slate-600 font-mono text-xs">
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Link yang akan langsung dibuka pengunjung saat scan stiker QR di meja.
                    </p>
                </div>

                <!-- Nama & No. WhatsApp (Opsional) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Nama Pemilik (Opsional)</label>
                        <input type="text" name="owner_name" value="{{ old('owner_name') }}" placeholder="Nama Anda" class="w-full px-3 py-2 bg-slate-900/80 border border-slate-700 rounded-xl text-white text-xs focus:ring-2 focus:ring-blue-500 outline-none placeholder:text-slate-600">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">No. WhatsApp (Opsional)</label>
                        <input type="text" name="owner_phone" value="{{ old('owner_phone') }}" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2 bg-slate-900/80 border border-slate-700 rounded-xl text-white text-xs focus:ring-2 focus:ring-blue-500 outline-none placeholder:text-slate-600">
                    </div>
                </div>

                <!-- Submit Button dengan Loading Spinner Interaktif -->
                <div class="pt-3">
                    <button type="submit" id="btnSubmitActivation" class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white font-semibold rounded-xl text-sm transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 group cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed">
                        <span id="btnText">Aktifkan Kartu Sekarang</span>
                        <i id="btnIcon" class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>

        </div>

        <!-- Success Box Container (Hidden by default, shown via fast AJAX without page reload) -->
        <div id="successCard" class="hidden bg-slate-850/90 rounded-3xl p-6 sm:p-8 border border-slate-700/60 shadow-2xl backdrop-blur-xl relative overflow-hidden text-center transition-all duration-300" style="background-color: rgba(30, 41, 59, 0.75);">

            <!-- Rainbow Top Line -->
            <div class="absolute top-0 left-0 right-0 h-1.5 flex">
                <div class="flex-1" style="background-color: #4285F4;"></div>
                <div class="flex-1" style="background-color: #34A853;"></div>
                <div class="flex-1" style="background-color: #FBBC05;"></div>
                <div class="flex-1" style="background-color: #EA4335;"></div>
            </div>

            <!-- Animated Check Circle -->
            <div class="w-20 h-20 mx-auto my-4 rounded-full bg-emerald-500/15 border-2 border-emerald-500/30 flex items-center justify-center text-emerald-400 text-3xl shadow-lg shadow-emerald-500/20 animate-check">
                <i class="fa-solid fa-check"></i>
            </div>

            <h2 class="text-2xl font-bold text-white font-outfit mb-2">
                Kartu Berhasil Diaktifkan!
            </h2>
            <p class="text-xs text-slate-400 leading-relaxed mb-6">
                Selamat! QR Google Review bisnis Anda sudah aktif. Stiker atau standee ini sekarang siap dipasang di meja kasir atau meja resto Anda.
            </p>

            <!-- Card Summary -->
            <div class="bg-slate-900/80 rounded-2xl p-4 border border-slate-700/60 text-left mb-6 space-y-2.5">
                <div>
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider block">Tempat Usaha</span>
                    <span id="successBusinessName" class="font-bold text-white text-sm font-outfit"></span>
                </div>

                <div class="pt-2 border-t border-slate-800">
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider block">No. Serial Kartu</span>
                    <span class="font-mono text-xs text-blue-400 font-semibold">{{ $card->serial_number }}</span>
                </div>

                <div class="pt-2 border-t border-slate-800">
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider block">Tujuan Google Review</span>
                    <a id="successReviewLink" href="#" target="_blank" class="text-xs text-blue-400 hover:underline truncate block font-mono">
                    </a>
                </div>
            </div>

            <!-- Action Button -->
            <div class="space-y-3">
                <a id="btnTestReview" href="#" target="_blank" class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white font-semibold rounded-xl text-sm transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    <span>Coba Buka Link Review Saya</span>
                </a>

                <p class="text-[11px] text-slate-500 pt-2 leading-relaxed">
                    💡 Mulai detik ini, setiap ada orang yang scan stiker QR di meja, server akan otomatis melempar mereka langsung ke Google Review toko Anda.
                </p>
            </div>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-500 mt-6">
            Diberdayakan oleh <span class="text-blue-400 font-semibold">Scalify Smart Review</span>
        </p>

    </div>

    <!-- Modal Panduan Cara Mengambil Link Google Review -->
    <div id="tutorialModal" class="hidden fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(15, 23, 42, 0.75);">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-slate-800 rounded-3xl max-w-sm w-full p-6 border border-slate-700 text-slate-100 shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-slate-700">
                    <h3 class="font-bold text-sm text-white flex items-center gap-2">
                        <i class="fa-brands fa-google text-blue-400"></i>
                        Cara Ambil Link Google Review
                    </h3>
                    <button onclick="document.getElementById('tutorialModal').classList.add('hidden')" class="text-slate-400 hover:text-white">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="mt-4 space-y-3 text-xs text-slate-300">
                    <div class="flex gap-2.5 items-start">
                        <span class="w-5 h-5 rounded-full bg-blue-500/20 text-blue-400 font-bold flex items-center justify-center text-[11px] flex-shrink-0">1</span>
                        <span>Buka aplikasi <b>Google Maps</b> di HP atau laptop Anda.</span>
                    </div>
                    <div class="flex gap-2.5 items-start">
                        <span class="w-5 h-5 rounded-full bg-blue-500/20 text-blue-400 font-bold flex items-center justify-center text-[11px] flex-shrink-0">2</span>
                        <span>Cari nama profil toko atau restoran Anda di pencarian.</span>
                    </div>
                    <div class="flex gap-2.5 items-start">
                        <span class="w-5 h-5 rounded-full bg-blue-500/20 text-blue-400 font-bold flex items-center justify-center text-[11px] flex-shrink-0">3</span>
                        <span>Klik tombol <b>"Minta Ulasan"</b> atau tombol <b>"Bagikan Profil"</b>.</span>
                    </div>
                    <div class="flex gap-2.5 items-start">
                        <span class="w-5 h-5 rounded-full bg-blue-500/20 text-blue-400 font-bold flex items-center justify-center text-[11px] flex-shrink-0">4</span>
                        <span>Klik <b>Salin Tautan</b> lalu tempelkan ke kolom form tadi.</span>
                    </div>
                </div>

                <div class="mt-5">
                    <button type="button" onclick="document.getElementById('tutorialModal').classList.add('hidden')" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-xs transition-colors">
                        Saya Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Fast AJAX Submit + Spinner Loading -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('activationForm');
            const btn = document.getElementById('btnSubmitActivation');
            const btnText = document.getElementById('btnText');
            const btnIcon = document.getElementById('btnIcon');
            const errorAlert = document.getElementById('errorAlertBox');
            const errorMsg = document.getElementById('errorMessageText');

            const activationCard = document.getElementById('activationCard');
            const successCard = document.getElementById('successCard');
            const successBusinessName = document.getElementById('successBusinessName');
            const successReviewLink = document.getElementById('successReviewLink');
            const btnTestReview = document.getElementById('btnTestReview');

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Sembunyikan error alert sebelumnya
                errorAlert.classList.add('hidden');

                // Set state: Tombol Disabled + Muncul Animasi Muter (Spinner)
                btn.disabled = true;
                btnText.textContent = 'Memverifikasi PIN & Mengaktifkan...';
                btnIcon.className = 'fa-solid fa-circle-notch fa-spin text-sm';

                const formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: 'POST'
                        , headers: {
                            'Accept': 'application/json'
                            , 'X-Requested-With': 'XMLHttpRequest'
                        }
                        , body: formData
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        // Ada error validasi atau PIN salah
                        const msg = data.message || (data.errors ? Object.values(data.errors).flat().join('<br>') : 'Terjadi kesalahan. Silakan coba lagi.');
                        errorMsg.innerHTML = msg;
                        errorAlert.classList.remove('hidden');

                        // Kembalikan tombol ke keadaan semula
                        btn.disabled = false;
                        btnText.textContent = 'Aktifkan Kartu Sekarang';
                        btnIcon.className = 'fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform';
                        return;
                    }

                    // SUKSES KILAT (Tanpa reload halaman, langsung ganti tampilan kartu!)
                    successBusinessName.textContent = data.business_name;
                    successReviewLink.textContent = data.google_review_url;
                    successReviewLink.href = data.google_review_url;
                    btnTestReview.href = data.google_review_url;

                    // Transisi mulus: sembunyikan form, tampilkan kartu sukses
                    activationCard.classList.add('hidden');
                    successCard.classList.remove('hidden');

                } catch (err) {
                    console.error('Activation network error:', err);
                    // Fallback submit biasa jika ada error koneksi fetch
                    form.submit();
                }
            });
        });

    </script>

</body>
</html>
