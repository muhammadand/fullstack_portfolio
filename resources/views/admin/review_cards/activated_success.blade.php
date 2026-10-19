<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Berhasil Diaktifkan! - Scalify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }

    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-850 to-slate-900 text-slate-100 min-h-screen flex flex-col justify-between p-4 sm:p-6" style="background-color: #0F172A;">

    <div class="max-w-md w-full mx-auto my-auto">

        <!-- Success Box -->
        <div class="bg-slate-850/90 rounded-3xl p-6 sm:p-8 border border-slate-700/60 shadow-2xl backdrop-blur-xl relative overflow-hidden text-center" style="background-color: rgba(30, 41, 59, 0.7);">

            <!-- Rainbow Top Line -->
            <div class="absolute top-0 left-0 right-0 h-1.5 flex">
                <div class="flex-1" style="background-color: #4285F4;"></div>
                <div class="flex-1" style="background-color: #34A853;"></div>
                <div class="flex-1" style="background-color: #FBBC05;"></div>
                <div class="flex-1" style="background-color: #EA4335;"></div>
            </div>

            <!-- Animated Check Circle -->
            <div class="w-20 h-20 mx-auto my-4 rounded-full bg-emerald-500/15 border-2 border-emerald-500/30 flex items-center justify-center text-emerald-400 text-3xl shadow-lg shadow-emerald-500/20">
                <i class="fa-solid fa-check"></i>
            </div>

            <h1 class="text-2xl font-bold text-white font-outfit mb-2">
                Kartu Berhasil Diaktifkan!
            </h1>
            <p class="text-xs text-slate-400 leading-relaxed mb-6">
                Selamat! QR Google Review bisnis Anda sudah aktif. Stiker atau standee ini sekarang siap dipasang di meja kasir atau meja makan.
            </p>

            <!-- Card Summary -->
            <div class="bg-slate-900/80 rounded-2xl p-4 border border-slate-700/60 text-left mb-6 space-y-2.5">
                <div>
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider block">Tempat Usaha</span>
                    <span class="font-bold text-white text-sm font-outfit">{{ $card->business_name }}</span>
                </div>

                <div class="pt-2 border-t border-slate-800">
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider block">No. Serial Kartu</span>
                    <span class="font-mono text-xs text-blue-400 font-semibold">{{ $card->serial_number }}</span>
                </div>

                @if($card->google_review_url)
                <div class="pt-2 border-t border-slate-800">
                    <span class="text-[11px] text-slate-400 uppercase tracking-wider block">Tujuan Google Review</span>
                    <a href="{{ $card->google_review_url }}" target="_blank" class="text-xs text-blue-400 hover:underline truncate block font-mono">
                        {{ $card->google_review_url }}
                    </a>
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                @if($card->google_review_url)
                <a href="{{ $card->google_review_url }}" target="_blank" class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white font-semibold rounded-xl text-sm transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    <span>Coba Buka Link Review Saya</span>
                </a>
                @endif

                <p class="text-[11px] text-slate-500 pt-2 leading-relaxed">
                    💡 Mulai detik ini, setiap ada orang yang scan stiker QR di meja, server akan otomatis melempar mereka langsung ke Google Review toko Anda.
                </p>
            </div>

        </div>

        <p class="text-center text-xs text-slate-500 mt-6">
            Diberdayakan oleh <span class="text-blue-400 font-semibold">Scalify Smart Review</span>
        </p>

    </div>

</body>
</html>
