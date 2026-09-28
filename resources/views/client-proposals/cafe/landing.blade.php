<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $client->brand_name ?? 'Artisan Coffee Roasters' }} - Specialty Coffee, Self-Order Meja & Modern POS</title>
    <meta name="description" content="Kopi artisan pilihan dengan kemudahan pemesanan mandiri scan barcode meja, pembayaran QRIS instan, loyalty membership eksklusif, dan sistem kasir POS terintegrasi.">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cafe: {
                            espresso: '#15110E',
                            mocha: '#231B15',
                            roast: '#362921',
                            bronze: '#C59B6C',
                            gold: '#D8AA73',
                            cream: '#FAF7F2',
                            latte: '#EFE7DA',
                            card: '#1F1813'
                        }
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
                        heading: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts: Plus Jakarta Sans & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #120E0C;
            color: #FAF7F2;
            overflow-x: hidden;
            -webkit-tap-highlight-color: transparent;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #15110E;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #362921;
            border-radius: 9999px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #C59B6C;
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
<body class="antialiased selection:bg-[#C59B6C] selection:text-[#140F0C] pb-16 md:pb-0">

    @php
    $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) {
        $cleanWa = '62' . substr($cleanWa, 1);
    }
    $brandName = $client->brand_name ?? 'Artisan Coffee Roasters';

    // Load JSON database from data.json in this directory
    $jsonPath = resource_path('views/client-proposals/cafe/data.json');
    if (file_exists($jsonPath)) {
        $cafeDatabase = json_decode(file_get_contents($jsonPath), true);
    } else {
        $cafeDatabase = [];
    }
    @endphp

    <!-- Global JSON database for client-side JavaScript engine -->
    <script>
        const CAFE_DATABASE = @json($cafeDatabase);
        const WA_NUMBER = '{{ $cleanWa }}';
        const BRAND_NAME = '{{ $brandName }}';
    </script>

    <!-- Partials Structure -->
    @include('client-proposals.cafe.partials.navbar')
    @include('client-proposals.cafe.partials.hero')
    @include('client-proposals.cafe.partials.menu_categories')
    @include('client-proposals.cafe.partials.menu')
    @include('client-proposals.cafe.partials.pos_qris')
    @include('client-proposals.cafe.partials.membership')
    @include('client-proposals.cafe.partials.how_it_works')
    @include('client-proposals.cafe.partials.facilities')
    @include('client-proposals.cafe.partials.cta')
    @include('client-proposals.cafe.partials.footer')
    @include('client-proposals.cafe.partials.order_modal')

    <!-- Sticky Mobile Quick Action Bar (Persis seperti di sport & travel!) -->
    <div class="fixed bottom-0 inset-x-0 bg-[#16110E]/95 backdrop-blur-lg border-t border-[#362921] py-2.5 px-3 z-40 md:hidden flex items-center gap-2 shadow-[0_-8px_20px_rgba(0,0,0,0.6)]">
        @if(isset($client->slug))
        <a href="{{ route('demo.customer.cafe', $client->slug) }}" class="flex-1 py-2.5 px-2 rounded-xl bg-gradient-to-r from-amber-600/30 to-amber-500/20 border border-amber-500/40 text-amber-300 text-[11px] font-bold text-center flex items-center justify-center gap-1.5 active:scale-95 transition-all">
            <i class="fas fa-mobile-alt text-xs text-amber-400"></i>
            <span>Demo App</span>
        </a>
        @endif
        <a href="#menu" class="flex-1 py-2.5 px-2 rounded-xl bg-[#261E18] border border-[#4A3B32] text-white text-[11px] font-bold text-center flex items-center justify-center gap-1.5 active:scale-95 transition-all">
            <i class="fas fa-mug-hot text-xs text-[#C59B6C]"></i>
            <span>Lihat Menu</span>
        </a>
        <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin reservasi meja kafe.') }}" target="_blank" class="flex-1 py-2.5 px-2 rounded-xl bg-gradient-to-r from-[#C59B6C] to-[#D8AA73] text-[#15110E] text-[11px] font-black text-center flex items-center justify-center gap-1.5 active:scale-95 transition-all shadow-md">
            <i class="fab fa-whatsapp text-xs"></i>
            <span>WhatsApp</span>
        </a>
    </div>

    <!-- Dynamic JS Scripts Engine -->
    @include('client-proposals.cafe.partials.scripts')

</body>
</html>
