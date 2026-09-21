<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $client->brand_name ?? 'LPK Kizuna Global Indonesia' }} - Sistem Informasi LMS, Ujian Online & Penyaluran Kerja</title>
    <meta name="description" content="Lembaga Pelatihan Kerja (LPK) resmi terakreditasi: Kursus bahasa & kejuruan luar negeri (Jepang, Korea, Jerman, Kapal Pesiar, Welder BNSP), Modul E-Learning LMS, Absensi Digital QR, Ujian Online CBT Pretest/Posttest, E-Sertifikat Terverifikasi & Pendaftaran Calon Pekerja.">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        lpk: {
                            50: '#eff6ff'
                            , 100: '#dbeafe'
                            , 200: '#bfdbfe'
                            , 400: '#60a5fa'
                            , 500: '#3b82f6'
                            , 600: '#2563eb'
                            , 700: '#1d4ed8'
                            , 800: '#1e40af'
                            , 900: '#1e3a8a'
                            , dark: '#0f172a'
                            , navy: '#0f172a'
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

    <!-- Font Awesome Icons -->
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

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

    </style>
</head>
<body class="antialiased selection:bg-blue-600 selection:text-white">

    @php
    $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) {
    $cleanWa = '62' . substr($cleanWa, 1);
    }
    $brandName = $client->brand_name ?? 'LPK Kizuna Global Indonesia';

    // Load JSON database from data.json
    $jsonPath = resource_path('views/client-proposals/lpk/data.json');
    if (file_exists($jsonPath)) {
    $lpkDatabase = json_decode(file_get_contents($jsonPath), true);
    } else {
    $lpkDatabase = [];
    }
    @endphp

    <!-- Global JSON Data for Client-Side JavaScript -->
    <script>
        const LPK_DATABASE = @json($lpkDatabase);
        const WA_NUMBER = '{{ $cleanWa }}';
        const BRAND_NAME = '{{ $brandName }}';

    </script>

    <!-- Partials Structure -->
    @include('client-proposals.lpk.partials.navbar')
    @include('client-proposals.lpk.partials.hero')
    @include('client-proposals.lpk.partials.before_after')
    @include('client-proposals.lpk.partials.courses')
    @include('client-proposals.lpk.partials.exam_simulator')
    @include('client-proposals.lpk.partials.attendance_system')
    @include('client-proposals.lpk.partials.certificate_verifier')
    @include('client-proposals.lpk.partials.instructors')
    @include('client-proposals.lpk.partials.placement_partners')
    @include('client-proposals.lpk.partials.registration_section')
    @include('client-proposals.lpk.partials.pricing_matrix')
    @include('client-proposals.lpk.partials.footer')
    @include('client-proposals.lpk.partials.registration_modal')
    @include('client-proposals.lpk.partials.bottom_nav')

    <!-- Dynamic JS Engine -->
    @include('client-proposals.lpk.partials.scripts')

</body>
</html>
