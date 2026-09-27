<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $client->brand_name ?? 'Apex Arena' }} - Sports Hub, Booking Lapangan & Komunitas Mabar</title>
    <meta name="description" content="Pusat sewa lapangan futsal, badminton standar BWF, padel tennis panoramic, mini soccer 7v7 FIFA, dan voli. Lengkap dengan sistem booking real-time, membership diskon, dan platform mabar komunitas.">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sport: {
                            50: '#ecfdf5'
                            , 100: '#d1fae5'
                            , 200: '#a7f3d0'
                            , 300: '#6ee7b7'
                            , 400: '#34d399'
                            , 500: '#10b981'
                            , 600: '#059669'
                            , 700: '#047857'
                            , 800: '#065f46'
                            , 900: '#064e3b'
                            , dark: '#022c22'
                        }
                    }
                    , fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif']
                        , heading: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif']
                    }
                }
            }
        }

    </script>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #020617;
            color: #f8fafc;
            overflow-x: hidden;
            -webkit-tap-highlight-color: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0f172a;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 9999px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #10b981;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

    </style>
</head>
<body class="antialiased selection:bg-emerald-500 selection:text-slate-950 pb-16 md:pb-0">

    @php
    $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) {
    $cleanWa = '62' . substr($cleanWa, 1);
    }
    $brandName = $client->brand_name ?? 'Apex Arena Sport Center';

    // Load JSON database from data.json in this directory
    $jsonPath = resource_path('views/client-proposals/sport/data.json');
    if (file_exists($jsonPath)) {
    $sportDatabase = json_decode(file_get_contents($jsonPath), true);
    } else {
    $sportDatabase = [];
    }
    @endphp

    <!-- Global JSON database for client-side JavaScript engine -->
    <script>
        const SPORT_DATABASE = @json($sportDatabase);
        const WA_NUMBER = '{{ $cleanWa }}';
        const BRAND_NAME = '{{ $brandName }}';

    </script>

    <!-- Partials Structure -->
    @include('client-proposals.sport.partials.navbar')
    @include('client-proposals.sport.partials.hero')
    @include('client-proposals.sport.partials.sport_categories')
    @include('client-proposals.sport.partials.courts')
    @include('client-proposals.sport.partials.membership')
    @include('client-proposals.sport.partials.community')
    @include('client-proposals.sport.partials.facilities')
    @include('client-proposals.sport.partials.how_it_works')
    @include('client-proposals.sport.partials.cta')
    @include('client-proposals.sport.partials.footer')
    @include('client-proposals.sport.partials.booking_modal')

    <!-- Sticky Mobile Quick Action Bar -->
    <div class="fixed bottom-0 inset-x-0 bg-slate-950/95 backdrop-blur-lg border-t border-slate-800 py-2.5 px-3 z-40 md:hidden flex items-center gap-2 shadow-[0_-8px_20px_rgba(0,0,0,0.5)]">
        @if(isset($client->slug))
        <a href="{{ route('demo.customer.sport', $client->slug) }}" class="flex-1 py-2.5 px-2 rounded-xl bg-slate-800 border border-emerald-500/30 text-emerald-400 text-[11px] font-bold text-center flex items-center justify-center gap-1.5 active:scale-95 transition-all">
            <i class="fas fa-mobile-screen-button text-xs"></i>
            <span>Demo App</span>
        </a>
        @endif
        <a href="#lapangan" class="flex-1 py-2.5 px-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-[11px] font-bold text-center flex items-center justify-center gap-1.5 active:scale-95 transition-all">
            <i class="fas fa-calendar-alt text-xs text-emerald-400"></i>
            <span>Cek Slot</span>
        </a>
        <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin sewa lapangan olahraga.') }}" target="_blank" class="flex-1 py-2.5 px-2 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-400 text-slate-950 text-[11px] font-black text-center flex items-center justify-center gap-1.5 active:scale-95 transition-all shadow-md">
            <i class="fab fa-whatsapp text-xs"></i>
            <span>WhatsApp</span>
        </a>
    </div>

    <!-- Dynamic JS Scripts Engine -->
    @include('client-proposals.sport.partials.scripts')

</body>
</html>
