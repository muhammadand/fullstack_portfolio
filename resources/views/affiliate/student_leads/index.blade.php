<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Data Mahasiswa - Mobile</title>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <x-affiliate.pwa-meta />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
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
    <div class="fixed top-0 right-0 w-full h-64 bg-cyan-600/10 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6 z-20 relative">
            <div class="flex items-center">
                <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div class="ml-4">
                    <p class="text-xs text-cyan-400 font-medium tracking-wider uppercase">CRM</p>
                    <h1 class="text-xl font-bold text-white">Data Mahasiswa</h1>
                </div>
            </div>

            <div class="relative">
                <button onclick="openAddLeadModal(); dismissCoachMark()" class="w-10 h-10 rounded-full bg-cyan-500 text-white shadow-lg shadow-cyan-500/30 flex items-center justify-center hover:bg-cyan-600 transition-colors shrink-0 relative z-10">
                    <i class="fa-solid fa-plus"></i>
                </button>

                <!-- Coach Mark -->
                <div id="coach-mark" class="absolute top-14 right-0 w-56 bg-cyan-600 text-white p-3.5 rounded-2xl shadow-2xl hidden z-50 transform origin-top-right transition-all duration-500 scale-0 opacity-0 border border-cyan-400/30">
                    <div class="absolute -top-2 right-3 w-4 h-4 bg-cyan-600 border-t border-l border-cyan-400/30 rotate-45 rounded-sm"></div>
                    <div class="relative z-10">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center shrink-0 shadow-inner">
                                <i class="fa-solid fa-lightbulb text-yellow-300"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium leading-relaxed mb-3">Klik tombol ini untuk simpan nomor prospek mahasiswa secara manual & cepat!</p>
                                <button onclick="dismissCoachMark()" class="bg-black/20 hover:bg-black/30 border border-black/10 px-3 py-1.5 rounded-lg text-[10px] font-bold text-white transition-colors w-full text-center active:scale-95">
                                    Oke, Mengerti
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-slate-400 mb-6 leading-relaxed">
            Kelola prospek mahasiswa yang butuh bantuan Tugas Akhir/Skripsi. Anda bisa klaim data global untuk menjadi prospek Anda.
        </p>

        {{-- Tabs --}}
        <div class="flex p-1 bg-white/5 rounded-xl mb-6 relative z-10 border border-white/5">
            <a href="{{ route('affiliate.student_leads.index', ['tab' => 'global']) }}" wire:navigate class="flex-1 py-2 text-center text-xs font-semibold rounded-lg transition-all {{ $tab == 'global' ? 'bg-cyan-500 text-white shadow-lg' : 'text-slate-400 hover:text-white' }}">
                Data Global
            </a>
            <a href="{{ route('affiliate.student_leads.index', ['tab' => 'my_leads']) }}" wire:navigate class="flex-1 py-2 text-center text-xs font-semibold rounded-lg transition-all {{ $tab == 'my_leads' ? 'bg-cyan-500 text-white shadow-lg' : 'text-slate-400 hover:text-white' }}">
                Mahasiswaku
            </a>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-400 p-3 rounded-xl mb-6 text-xs font-semibold">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/50 text-red-400 p-3 rounded-xl mb-6 text-xs font-semibold">
            {{ session('error') }}
        </div>
        @endif

        {{-- List --}}
        @if($leads->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-slate-500 text-2xl mb-4">
                <i class="fa-solid fa-users-slash"></i>
            </div>
            <p class="text-slate-400 text-sm font-medium">Belum ada data prospek mahasiswa.</p>
        </div>
        @else
        <div class="flex flex-col gap-4">
            @foreach($leads as $lead)
            @if($tab === 'global')
            @include('affiliate.student_leads.partials.global_leads')
            @else
            @include('affiliate.student_leads.partials.my_leads')
            @endif
            @endforeach
        </div>

        <div class="mt-6 mb-8">
            {{ $leads->links() }}
        </div>
        @endif
    </div>

    {{-- Modals (Tambah Lead, Edit Lead, AI Loading) --}}
    @include('affiliate.student_leads.partials.modals')

    <x-affiliate.bottom-nav />
    <x-affiliate.scripts />

    {{-- Page Specific Scripts (CoachMark, Modals, WA Direct, AI Generator) --}}
    @include('affiliate.student_leads.partials.scripts')
</body>
</html>
