<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Katalog Proposal - Mobile</title>
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

    <!-- Background Decoration -->
    <div class="fixed top-0 right-0 w-full h-64 bg-rose-600/10 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <p class="text-xs text-rose-400 font-medium tracking-wider uppercase">Marketing</p>
                <h1 class="text-xl font-bold text-white">Katalog Proposal</h1>
            </div>
        </div>

        <p class="text-xs text-slate-400 mb-6 leading-relaxed">
            Pilih dan bagikan link proposal atau landing page di bawah ini ke calon klien Anda. Link sudah otomatis tertaut dengan kode affiliate Anda.
        </p>

        <!-- Category Filter (Horizontal Scroll) -->
        <div class="flex overflow-x-auto hide-scrollbar gap-2 mb-6 pb-2">
            <a href="{{ route('affiliate.proposals') }}" class="px-4 py-2 rounded-full whitespace-nowrap text-xs font-semibold transition-colors {{ !request('category_id') ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/30' : 'glass-panel text-slate-400 hover:text-white' }}">
                Semua Kategori
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('affiliate.proposals', ['category_id' => $cat->id]) }}" class="px-4 py-2 rounded-full whitespace-nowrap text-xs font-semibold transition-colors {{ request('category_id') == $cat->id ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/30' : 'glass-panel text-slate-400 hover:text-white' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        <!-- Proposals List -->
        <div class="space-y-4">
            @forelse($proposals as $p)
            <div class="glass-panel rounded-2xl p-4">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h3 class="text-base font-bold text-white mb-0.5">{{ $p->brand_name }}</h3>
                        <div class="flex items-center gap-2 text-[10px] text-slate-400">
                            <span class="px-2 py-0.5 rounded {{ $p->category ? 'bg-blue-500/20 text-blue-400' : 'bg-slate-700/50 text-slate-300' }}">
                                {{ $p->category ? $p->category->name : 'Tanpa Kategori' }}
                            </span>
                            @if($p->project_price)
                            <span><i class="fa-solid fa-tag mr-1 text-slate-500"></i>Rp {{ number_format($p->project_price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-rose-500/10 flex items-center justify-center text-rose-400 text-lg">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-4">
                    <a href="{{ route('proposal.dynamic', $p->slug) }}?ref={{ $affiliate->affiliate_code }}" target="_blank" class="flex-1 py-2 bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/30 text-emerald-400 text-[11px] font-semibold rounded-xl transition-colors flex items-center justify-center gap-1.5 active:scale-95">
                        <i class="fa-solid fa-eye"></i> Lihat
                    </a>
                    <button onclick="copyLink('{{ route('landing.dynamic', $p->slug) }}?ref={{ $affiliate->affiliate_code }}')" class="flex-1 py-2 bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/30 text-blue-400 text-[11px] font-semibold rounded-xl transition-colors flex items-center justify-center gap-1.5 active:scale-95">
                        <i class="fa-solid fa-copy"></i> Landing
                    </button>
                    <button onclick="copyLink('{{ route('proposal.dynamic', $p->slug) }}?ref={{ $affiliate->affiliate_code }}')" class="flex-1 py-2 bg-rose-500/20 hover:bg-rose-500/30 border border-rose-500/30 text-rose-400 text-[11px] font-semibold rounded-xl transition-colors flex items-center justify-center gap-1.5 active:scale-95">
                        <i class="fa-solid fa-copy"></i> Proposal
                    </button>
                </div>

                <div class="border-t border-white/10 mt-4 mb-3"></div>

                <div>
                    <label class="block text-[10px] font-semibold text-emerald-400 mb-1.5"><i class="fa-brands fa-whatsapp mr-1"></i> Share via WhatsApp:</label>
                    <div class="relative">
                        <select onchange="kirimWaLangsungAffiliate(this, '{{ $p->brand_name }}', '{{ route('landing.dynamic', $p->slug) }}?ref={{ $affiliate->affiliate_code }}', '{{ route('proposal.dynamic', $p->slug) }}?ref={{ $affiliate->affiliate_code }}')" class="w-full appearance-none pl-3 pr-8 py-2 bg-white/5 border border-emerald-500/30 text-emerald-300 text-xs font-medium rounded-xl focus:outline-none focus:border-emerald-500 cursor-pointer transition-all">
                            <option value="" disabled selected class="text-slate-800">Pilih Template Chat...</option>
                            @foreach($chatTemplates as $ct)
                            <option value="{{ base64_encode($ct->content) }}" class="text-slate-800">{{ $ct->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-emerald-400/70">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-400 text-sm flex flex-col items-center glass-panel rounded-2xl">
                <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-2xl mb-3 text-slate-500">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                Belum ada data client proposal yang tersedia saat ini.
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6 mb-4">
            @if ($proposals->hasPages())
            <div class="flex justify-between items-center glass-panel rounded-xl p-2">
                @if ($proposals->onFirstPage())
                <div class="px-4 py-2 text-xs text-slate-500 font-medium cursor-not-allowed">
                    <i class="fa-solid fa-chevron-left mr-1"></i> Sebelumnya
                </div>
                @else
                <a href="{{ $proposals->previousPageUrl() }}" class="px-4 py-2 text-xs text-rose-400 hover:text-rose-300 font-medium transition-colors">
                    <i class="fa-solid fa-chevron-left mr-1"></i> Sebelumnya
                </a>
                @endif

                @if ($proposals->hasMorePages())
                <a href="{{ $proposals->nextPageUrl() }}" class="px-4 py-2 text-xs text-white bg-rose-500 hover:bg-rose-600 rounded-lg shadow-lg shadow-rose-500/30 font-medium transition-colors">
                    Selanjutnya <i class="fa-solid fa-chevron-right ml-1"></i>
                </a>
                @else
                <div class="px-4 py-2 text-xs text-slate-500 font-medium cursor-not-allowed">
                    Selanjutnya <i class="fa-solid fa-chevron-right ml-1"></i>
                </div>
                @endif
            </div>
            @endif
        </div>

    </div>

    <!-- Hidden input for copying text -->
    <input type="text" readonly class="absolute -left-[9999px] opacity-0" id="clipboard-input">

    <script>
        function copyLink(url) {
            const copyInput = document.getElementById("clipboard-input");
            copyInput.value = url;
            copyInput.select();
            copyInput.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyInput.value);

            showToast('Link berhasil disalin ke clipboard!', 'success');
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            // Base styles
            toast.className = 'fixed top-10 left-1/2 -translate-x-1/2 px-5 py-3 rounded-full shadow-2xl z-[80] flex items-center gap-3 text-sm font-medium transition-all duration-500 transform -translate-y-10 opacity-0 min-w-[280px] max-w-[90vw] justify-center';

            if (type === 'success') {
                toast.classList.add('bg-slate-800', 'border', 'border-emerald-500/30', 'text-white');
                toast.innerHTML = `<div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0"><i class="fa-solid fa-check text-xs"></i></div> <span class="truncate">${message}</span>`;
            } else {
                toast.classList.add('bg-slate-800', 'border', 'border-red-500/30', 'text-white');
                toast.innerHTML = `<div class="w-6 h-6 rounded-full bg-red-500/20 flex items-center justify-center text-red-400 shrink-0"><i class="fa-solid fa-xmark text-xs"></i></div> <span class="truncate">${message}</span>`;
            }

            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.remove('-translate-y-10', 'opacity-0');
            }, 10);

            // Animate out
            setTimeout(() => {
                toast.classList.add('-translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 2500);
        }

        function kirimWaLangsungAffiliate(selectElement, brandName, linkLandingPage, linkProposal) {
            if (!selectElement.value) return;

            // Decode template text
            let text = decodeURIComponent(escape(window.atob(selectElement.value)));

            // Replace placeholders
            if (brandName) {
                text = text.replace(/\{nama_bisnis\}/g, brandName);
            }
            if (linkLandingPage) {
                text = text.replace(/\{link_landing_page\}/g, linkLandingPage);
            }
            if (linkProposal) {
                text = text.replace(/\{link_proposal\}/g, linkProposal);
            }

            // Open WA Share Link (tanpa nomor spesifik, jadi afiliator bisa pilih kontak di HP mereka)
            const waUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;

            // Deteksi jika dibuka via HP (Mobile) agar langsung buka aplikasi tanpa diblokir browser
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                window.location.href = waUrl;
            } else {
                window.open(waUrl, '_blank');
            }

            // Reset dropdown back to default
            selectElement.value = "";
        }

    </script>
</body>
</html>
