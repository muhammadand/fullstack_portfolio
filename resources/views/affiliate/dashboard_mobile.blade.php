<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Partner Dashboard - Mobile</title>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <x-affiliate.pwa-meta />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            /* Midnight blue */
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(30, 58, 138, 0.1));
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

        .dana-blue {
            background-color: #118EEA;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative">

    <x-affiliate.page-loader />

    <!-- Background Decoration -->
    <div class="fixed top-0 left-0 w-full h-64 bg-blue-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[100px] translate-y-1/2 translate-x-1/3 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        @if($affiliate->status === 'pending')
        <x-affiliate.header-pending :affiliate="$affiliate" />
        <x-affiliate.pending-message />
        @else
        <x-affiliate.header :affiliate="$affiliate" />

        {{-- Session Messages --}}
        @if(session('success'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                showToast("{{ session('success') }}", 'success');
            });

        </script>
        @endif

        @if(session('error') || $errors->any())
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                showToast("{{ session('error') ?? $errors->first() }}", 'error');
            });

        </script>
        @endif

        <x-affiliate.check-in-card :affiliate="$affiliate" />

        <x-affiliate.balance-card :affiliate="$affiliate" />

        <!-- Hidden input for copy -->
        <input type="text" readonly value="{{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}" class="absolute -left-[9999px] opacity-0" id="affiliate-link">

        <x-affiliate.grid-menu :totalProjects="$totalProjects" :totalClicks="$totalClicks" />

        <x-affiliate.promo-banner />

        <x-affiliate.target-ideas />

        <x-affiliate.student-target-ideas />
        @endif
    </div>

    @if($affiliate->status !== 'pending')
    <x-affiliate.bottom-nav />
    <x-affiliate.modals :affiliate="$affiliate" />
    @endif

    @include('partials.flowise')

    <x-affiliate.scripts />
</body>
</html>
