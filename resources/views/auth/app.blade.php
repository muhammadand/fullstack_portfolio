<!DOCTYPE html>
<html lang="id" class="w-full overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Masuk') — Scalify Intelligence</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('scalify.png') }}">
    <x-affiliate.pwa-meta />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Tema SweetAlert2 mengikuti tema Scalify (dark glass) */
        .swal2-container { padding: .75rem !important; }
        .swal2-popup.scalify-toast {
            width: min(92vw, 380px) !important;
            padding: .75rem 1rem !important;
            align-items: center;
            border-radius: 1rem !important;
            background: rgba(17, 24, 80, .92) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, .12);
            box-shadow: 0 12px 40px rgba(0, 0, 0, .45) !important;
            color: #fff !important;
        }
        .swal2-popup.scalify-toast .swal2-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: .8125rem !important; font-weight: 600; line-height: 1.4; margin: 0 0 0 .5rem !important; text-align: left; color: #fff; }
        .swal2-popup.scalify-toast .swal2-icon { width: 1.75rem !important; height: 1.75rem !important; min-width: 1.75rem !important; margin: 0 !important; }
        .swal2-popup.scalify-toast .swal2-icon .swal2-icon-content { font-size: 1rem !important; }
        .swal2-popup.scalify-toast .swal2-timer-progress-bar { background: rgba(96, 165, 250, .8); }
        .swal2-popup.scalify-modal {
            border-radius: 1.5rem !important;
            background: #111850 !important;
            border: 1px solid rgba(255, 255, 255, .12);
            color: #fff !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .swal2-popup.scalify-modal .swal2-title { color: #fff; font-size: 1.125rem; font-weight: 700; }
        .swal2-popup.scalify-modal .swal2-html-container { color: rgba(255, 255, 255, .65); font-size: .875rem; }
        .swal2-popup.scalify-modal .swal2-confirm { border-radius: .75rem !important; background: linear-gradient(90deg, #2563EB, #4F46E5) !important; font-weight: 700; box-shadow: none !important; }
        /* Cegah autofill browser merusak tema input */
        input:-webkit-autofill { -webkit-text-fill-color: #fff; transition: background-color 9999s ease-in-out 0s; box-shadow: inset 0 0 0 1000px #151c5c; }
    </style>
</head>
<body class="bg-brand-dark text-white font-sans antialiased min-h-dvh overflow-x-hidden">

    {{-- Latar belakang --}}
    <div class="fixed inset-0 bg-hero-gradient pointer-events-none" aria-hidden="true"></div>
    <div class="fixed -top-24 -right-24 w-72 h-72 sm:w-[28rem] sm:h-[28rem] rounded-full bg-brand-blue/20 blur-[110px] pointer-events-none" aria-hidden="true"></div>
    <div class="fixed -bottom-24 -left-24 w-72 h-72 rounded-full bg-brand-indigo/20 blur-[110px] pointer-events-none" aria-hidden="true"></div>
    <div class="fixed inset-0 opacity-[0.035] pointer-events-none" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 28px 28px;" aria-hidden="true"></div>

    <main class="relative z-10 min-h-dvh flex items-center justify-center px-4 py-8 sm:py-12 pb-[max(2rem,env(safe-area-inset-bottom))]">
        <div class="w-full max-w-md lg:max-w-4xl lg:grid lg:grid-cols-2 sm:rounded-3xl sm:border sm:border-white/10 sm:bg-white/[0.04] sm:backdrop-blur-xl sm:shadow-card overflow-hidden">

            {{-- Panel brand (desktop saja) --}}
            <aside class="hidden lg:flex flex-col justify-between p-10 border-r border-white/10 bg-gradient-to-br from-brand-blue/15 via-transparent to-brand-indigo/15">
                <div class="flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-xl bg-btn-gradient flex items-center justify-center shadow-glow-sm">
                        <i class="fa-solid fa-bolt text-white text-sm"></i>
                    </span>
                    <span class="font-display font-bold text-white tracking-wide">@yield('brand', 'Scalify Intelligence')</span>
                </div>
                <div>
                    @yield('aside')
                </div>
                <p class="text-[11px] text-white/35">&copy; {{ date('Y') }} Scalify Intelligence</p>
            </aside>

            <section class="p-1 sm:p-8 lg:p-10">
                {{-- Logo (mobile) --}}
                <div class="flex items-center justify-center gap-2.5 mb-8 lg:hidden">
                    <span class="w-9 h-9 rounded-xl bg-btn-gradient flex items-center justify-center shadow-glow-sm">
                        <i class="fa-solid fa-bolt text-white text-sm"></i>
                    </span>
                    <span class="font-display font-bold text-white tracking-wide">@yield('brand', 'Scalify Intelligence')</span>
                </div>

                @yield('content')
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toast & modal bertema; dipakai juga oleh halaman yang meng-extend layout ini.
        window.scalifyToast = (icon, title) => Swal.fire({
            toast: true,
            position: window.innerWidth < 640 ? 'top' : 'top-end',
            icon, title,
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            customClass: { popup: 'scalify-toast' },
            didOpen: (t) => { t.addEventListener('mouseenter', Swal.stopTimer); t.addEventListener('mouseleave', Swal.resumeTimer); },
        });
        window.scalifyAlert = (icon, title, text) => Swal.fire({
            icon, title, text,
            confirmButtonText: 'Mengerti',
            customClass: { popup: 'scalify-modal' },
        });

        document.addEventListener('DOMContentLoaded', () => {
            const flash = @json(['success' => session('success'), 'error' => session('error'), 'status' => session('status')]);
            if (flash.success) scalifyToast('success', flash.success);
            if (flash.status) scalifyToast('success', flash.status);
            if (flash.error) scalifyToast('error', flash.error);
            @if($errors->any())
            scalifyToast('error', 'Periksa kembali isian Anda.');
            @endif
        });
    </script>
</body>
</html>
