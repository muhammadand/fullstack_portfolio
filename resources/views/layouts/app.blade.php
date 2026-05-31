<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Scalify Intelligence — Automasi Cerdas, Bisnis Naik Kelas</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-blue': '#2563EB'
                        , 'brand-indigo': '#4F46E5'
                        , 'brand-dark': '#0A0E2A'
                        , 'brand-navy': '#0D1240'
                        , 'brand-mid': '#111850'
                        , 'brand-card': 'rgba(255,255,255,0.07)'
                        , 'brand-accent': '#60A5FA'
                    , }
                    , fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                        , display: ['Montserrat', 'sans-serif']
                    , }
                    , backgroundImage: {
                        'hero-gradient': 'radial-gradient(ellipse 80% 60% at 50% 0%, #1e3a8a 0%, #0A0E2A 70%)'
                        , 'card-glass': 'linear-gradient(135deg, rgba(255,255,255,0.10) 0%, rgba(255,255,255,0.03) 100%)'
                        , 'blue-glow': 'radial-gradient(circle, rgba(59,130,246,0.35) 0%, transparent 70%)'
                        , 'btn-gradient': 'linear-gradient(90deg, #2563EB, #4F46E5)'
                    , }
                    , boxShadow: {
                        'card': '0 8px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.1)'
                        , 'glow-blue': '0 0 30px rgba(59,130,246,0.4)'
                        , 'glow-sm': '0 0 12px rgba(59,130,246,0.3)'
                    , }
                    , animation: {
                        'float': 'float 4s ease-in-out infinite'
                        , 'float-slow': 'float 6s ease-in-out infinite'
                        , 'pulse-slow': 'pulse 3s ease-in-out infinite'
                        , 'scan': 'scan 2s linear infinite'
                    , }
                }
            }
        }

    </script>
    <link rel="icon" type="image/x-icon" href="{{ asset('scalify.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-brand-dark text-white font-sans overflow-x-hidden scroll-smooth">

    @include('layouts.navbar')
    @yield('content')
    <footer class="bg-brand-navy border-t border-white/5 py-8 px-4 text-center text-white/30 text-xs">
        <div class="flex items-center justify-center gap-2 mb-3">
            <div class="w-6 h-6 rounded-lg bg-btn-gradient flex items-center justify-center shadow-glow-sm">
                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span class="font-display font-bold text-sm text-white/60">Scalify<span class="text-brand-accent">
                    Intelligence</span></span>
        </div>
        <p>© 2026 Scalify Intelligence · All rights reserved</p>
    </footer>

</body>

</html>
