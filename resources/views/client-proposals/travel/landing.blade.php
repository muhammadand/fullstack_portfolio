<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $client->brand_name ?? 'SkyKey Travel' }} - Travel Shuttle Elf & Minibus Antar Kota Door to Door</title>
    <meta name="description" content="Layanan travel shuttle Isuzu Elf, HiAce & Mini Bus eksekutif antar kota dengan jadwal harian Ciamis, Kuningan, Tasikmalaya, Bandung, Jakarta. Kuota kursi real-time, gratis snack & makan, serta program membership loyalitas.">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        travel: {
                            50: '#f0f9ff'
                            , 100: '#e0f2fe'
                            , 200: '#bae6fd'
                            , 400: '#38bdf8'
                            , 500: '#0ea5e9'
                            , 600: '#0284c7'
                            , 700: '#0369a1'
                            , 800: '#075985'
                            , 900: '#0c4a6e'
                            , dark: '#0f172a'
                            , navy: '#1e293b'
                            , accent: '#f59e0b'
                            , emerald: '#10b981'
                        }
                    }
                    , fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif']
                        , heading: ['Montserrat', 'Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        }

    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        .font-heading {
            font-family: 'Montserrat', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
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

        .membership-active {
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.2);
            border-color: #f59e0b !important;
        }

    </style>
</head>
<body class="antialiased selection:bg-travel-600 selection:text-white">

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

    <!-- Dynamic JS Scripts Engine -->
    @include('client-proposals.travel.partials.scripts')

</body>
</html>
