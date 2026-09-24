<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $client->brand_name ?? 'SkyKey Travel' }} - Executive Minibus & Shuttle Door to Door</title>
    <meta name="description" content="Layanan travel shuttle Isuzu Elf & Toyota HiAce eksekutif antar kota dengan penjemputan door to door, transparansi kuota kursi real-time, gratis makan & snack di rest area, serta membership reward.">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        travel: {
                            50: '#f0f7ff'
                            , 100: '#e0effe'
                            , 200: '#bae0fd'
                            , 300: '#7dd3fc'
                            , 400: '#38bdf8'
                            , 500: '#0ea5e9'
                            , 600: '#0284c7'
                            , 700: '#0369a1'
                            , 800: '#075985'
                            , 900: '#0c4a6e'
                            , 950: '#082f49'
                            , dark: '#0a1120'
                            , navy: '#0f172a'
                            , gold: '#d97706'
                            , goldlight: '#fef3c7'
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
            background-color: #fafbfc;
            color: #0f172a;
            overflow-x: hidden;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
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
<body class="antialiased selection:bg-travel-700 selection:text-white pb-16 md:pb-0">

    @php
    $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) {
    $cleanWa = '62' . substr($cleanWa, 1);
    }
    $brandName = $client->brand_name ?? 'SkyKey Travel Minibus';

    // Load JSON database from data.json in this directory
    $jsonPath = resource_path('views/client-proposals/travel/data.json');
    if (file_exists($jsonPath)) {
    $travelDatabase = json_decode(file_get_contents($jsonPath), true);
    } else {
    $travelDatabase = [];
    }
    @endphp

    <!-- Global JSON database for client-side JavaScript engine -->
    <script>
        const TRAVEL_DATABASE = @json($travelDatabase);
        const WA_NUMBER = '{{ $cleanWa }}';
        const BRAND_NAME = '{{ $brandName }}';

    </script>

    <!-- Partials Structure -->
    @include('client-proposals.travel.partials.navbar')
    @include('client-proposals.travel.partials.hero')
    @include('client-proposals.travel.partials.benefits')
    @include('client-proposals.travel.partials.schedules')
    @include('client-proposals.travel.partials.fleets')
    @include('client-proposals.travel.partials.membership')
    @include('client-proposals.travel.partials.how_it_works')
    @include('client-proposals.travel.partials.cta')
    @include('client-proposals.travel.partials.footer')
    @include('client-proposals.travel.partials.seat_modal')

    <!-- Sticky Mobile Quick Action Bar -->
    <div class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-lg border-t border-slate-200/80 py-2 px-3 z-40 md:hidden flex items-center gap-2 shadow-[0_-8px_20px_rgba(0,0,0,0.06)]">
        @if(isset($client->slug))
        <a href="{{ route('demo.customer.travel', $client->slug) }}" class="flex-1 py-2.5 px-2.5 rounded-xl bg-travel-700 text-white text-[11px] font-bold text-center flex items-center justify-center gap-1.5 active:scale-95 transition-all shadow-xs">
            <i class="fas fa-mobile-screen-button text-xs"></i>
            <span>Demo App</span>
        </a>
        @endif
        <a href="#jadwal" class="flex-1 py-2.5 px-2.5 rounded-xl bg-slate-900 text-white text-[11px] font-bold text-center flex items-center justify-center gap-1.5 active:scale-95 transition-all">
            <i class="fas fa-calendar-alt text-xs text-travel-400"></i>
            <span>Cek Kursi</span>
        </a>
        <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin pesan tiket travel.') }}" target="_blank" class="flex-1 py-2.5 px-2.5 rounded-xl bg-emerald-600 text-white text-[11px] font-bold text-center flex items-center justify-center gap-1.5 active:scale-95 transition-all shadow-sm">
            <i class="fab fa-whatsapp text-xs"></i>
            <span>WhatsApp</span>
        </a>
    </div>

    <!-- Dynamic JS Scripts Engine -->
    @include('client-proposals.travel.partials.scripts')

</body>
</html>
