<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {!! $meta_tags ?? '' !!}
    @hasSection('meta_tags')
        @yield('meta_tags')
    @else
        <title>Scalify Intelligence — Automasi Cerdas, Bisnis Naik Kelas</title>
        <meta name="title" content="Scalify Intelligence — Automasi Cerdas, Bisnis Naik Kelas" />
        <meta name="description" content="Scalify Intelligence menghadirkan solusi kecerdasan buatan, otomasi bisnis, chatbot AI, dan analisis data untuk perusahaan dan UMKM Indonesia." />
        <meta name="keywords" content="automasi bisnis, kecerdasan buatan, AI chatbot, otomasi UMKM, analisis data bisnis" />
        <meta name="author" content="Scalify Intelligence" />
        <meta name="robots" content="index, follow" />
        
        {{-- Open Graph / Facebook --}}
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:title" content="Scalify Intelligence — Automasi Cerdas, Bisnis Naik Kelas" />
        <meta property="og:description" content="Scalify Intelligence menghadirkan solusi kecerdasan buatan, otomasi bisnis, chatbot AI, dan analisis data." />
        <meta property="og:image" content="{{ asset('og-image.png') }}" />
        
        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:url" content="{{ url()->current() }}" />
        <meta name="twitter:title" content="Scalify Intelligence — Automasi Cerdas, Bisnis Naik Kelas" />
        <meta name="twitter:description" content="Scalify Intelligence menghadirkan solusi kecerdasan buatan, otomasi bisnis, chatbot AI, dan analisis data." />
        <meta name="twitter:image" content="{{ asset('og-image.png') }}" />
    @endif
    <link rel="canonical" href="{{ url()->current() }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-blue': '#2563EB',
                        'brand-indigo': '#4F46E5',
                        'brand-dark': '#0A0E2A',
                        'brand-navy': '#0D1240',
                        'brand-mid': '#111850',
                        'brand-card': 'rgba(255,255,255,0.07)',
                        'brand-accent': '#60A5FA',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Montserrat', 'sans-serif'],
                    },
                    backgroundImage: {
                        'hero-gradient': 'radial-gradient(ellipse 80% 60% at 50% 0%, #1e3a8a 0%, #0A0E2A 70%)',
                        'card-glass': 'linear-gradient(135deg, rgba(255,255,255,0.10) 0%, rgba(255,255,255,0.03) 100%)',
                        'blue-glow': 'radial-gradient(circle, rgba(59,130,246,0.35) 0%, transparent 70%)',
                        'btn-gradient': 'linear-gradient(90deg, #2563EB, #4F46E5)',
                    },
                    boxShadow: {
                        'card': '0 8px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.1)',
                        'glow-blue': '0 0 30px rgba(59,130,246,0.4)',
                        'glow-sm': '0 0 12px rgba(59,130,246,0.3)',
                    },
                    animation: {
                        'float': 'float 4s ease-in-out infinite',
                        'float-slow': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                        'scan': 'scan 2s linear infinite',
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')
</head>

<body class="bg-brand-dark text-white font-sans overflow-x-hidden scroll-smooth">
    <!-- Navigation -->

    @include('pages.layouts.navbar')
    @yield('content')
    @if (Route::currentRouteName() === 'landing')
        @include('pages.component.service')
        @include('pages.component.about')
        @include('pages.component.portfolio')
        @include('pages.component.testimoni')
        @include('pages.component.blogs')
        @include('pages.component.social_media')
        @include('pages.component.contact')
        @include('pages.component.cta')
    @endif
    @include('pages.layouts.footer')
</body>

</html>
