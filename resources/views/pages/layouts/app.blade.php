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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
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
