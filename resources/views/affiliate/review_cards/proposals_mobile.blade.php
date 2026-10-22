<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Penawaran Kartu Review - Partner Scalify</title>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <x-affiliate.pwa-meta />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-tap-highlight-color: transparent;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            letter-spacing: -0.01em;
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

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-4px);
            }
        }

        .animate-floating {
            animation: floating 2.5s ease-in-out infinite;
        }

    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative">

    <x-affiliate.page-loader />

    <!-- Background Decoration Blue/Cyan Glow -->
    <div class="fixed top-0 right-0 w-full h-64 bg-blue-600/10 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        <!-- Header -->
        <div class="flex items-center justify-between gap-3 mb-4 z-20 relative">
            <div class="flex items-center gap-3 min-w-0 flex-1">
                <a href="{{ route('affiliate.dashboard') }}" wire:navigate class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-all active:scale-95 shrink-0 border border-white/10 shadow-sm">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-1.5 mb-0.5">
                        <span class="text-[10px] text-blue-400 font-bold tracking-wider uppercase">Marketing Produk</span>
                        <span class="bg-blue-500 text-white text-[8px] font-extrabold px-1.5 py-0.5 rounded-full leading-none">NEW</span>
                    </div>
                    <h1 class="text-[17px] sm:text-lg font-bold text-white tracking-tight leading-snug">Penawaran Kartu Review</h1>
                </div>
            </div>

            <!-- Link ke Stok Kartu Review -->
            <a href="{{ route('affiliate.review_cards.index') }}" wire:navigate class="shrink-0 px-3 py-2 rounded-xl glass-panel text-xs font-semibold text-blue-400 hover:text-white flex items-center gap-1.5 transition-all border border-blue-500/30 active:scale-95 whitespace-nowrap bg-blue-500/5 hover:bg-blue-500/10 shadow-sm">
                <i class="fa-solid fa-layer-group text-xs text-blue-400"></i>
                <span>Stok Kartu</span>
            </a>
        </div>

        <p class="text-xs text-slate-400 mb-5 leading-relaxed font-normal">
            Hubungi bisnis & toko lokal untuk menawarkan <span class="text-slate-100 font-semibold">Smart Google Review Card (NFC & QR)</span> guna menaikkan ulasan bintang 5 Google Maps mereka secara instan.
        </p>

        <!-- Tabs: Global Leads & Follow Up Saya -->
        <div class="flex p-1 bg-white/5 rounded-2xl mb-5">
            <a href="{{ route('affiliate.review_proposals', ['tab' => 'global', 'category_id' => request('category_id')]) }}" wire:navigate class="flex-1 py-2.5 text-xs font-bold text-center rounded-xl transition-all {{ $tab === 'global' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-globe mr-1"></i> Global Leads
            </a>
            <a href="{{ route('affiliate.review_proposals', ['tab' => 'follow_up', 'category_id' => request('category_id')]) }}" wire:navigate class="flex-1 py-2.5 text-xs font-bold text-center rounded-xl transition-all {{ $tab === 'follow_up' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-bookmark mr-1"></i> Follow Up Saya
            </a>
        </div>

        @if($tab === 'follow_up')
        <!-- Search Box -->
        <div class="relative mb-5 z-30">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-search"></i>
                </div>
                <input type="text" id="searchInputReview" value="{{ $search ?? '' }}" placeholder="Cari nama bisnis atau no WA..." class="w-full bg-black/30 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500 transition-colors" autocomplete="off">
                @if(!empty($search))
                <a href="{{ route('affiliate.review_proposals', ['tab' => 'follow_up']) }}" wire:navigate class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                @endif
            </div>

            <!-- Autocomplete Dropdown -->
            <div id="searchDropdownReview" class="absolute left-0 right-0 mt-2 bg-slate-800 border border-white/10 rounded-xl shadow-2xl overflow-hidden hidden z-50 max-h-60 overflow-y-auto">
                <ul id="searchResultsReview" class="divide-y divide-white/5"></ul>
            </div>
        </div>
        @endif

        <!-- Category Filter (Horizontal Scroll) -->
        <div class="flex overflow-x-auto hide-scrollbar gap-2 mb-5 pb-2">
            <a href="{{ route('affiliate.review_proposals', ['tab' => $tab]) }}" wire:navigate class="px-3.5 py-1.5 rounded-full whitespace-nowrap text-xs font-semibold transition-colors {{ !request('category_id') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'glass-panel text-slate-400 hover:text-white' }}">
                Semua Kategori
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('affiliate.review_proposals', ['tab' => $tab, 'category_id' => $cat->id]) }}" wire:navigate class="px-3.5 py-1.5 rounded-full whitespace-nowrap text-xs font-semibold transition-colors {{ request('category_id') == $cat->id ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'glass-panel text-slate-400 hover:text-white' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        <!-- Leads Cards List -->
        <div class="space-y-4">
            @forelse($proposals as $p)
            @include('affiliate.review_cards.partials.review_proposal_card', ['p' => $p])
            @empty
            <div class="p-8 text-center text-slate-400 text-sm flex flex-col items-center glass-panel rounded-2xl">
                <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-2xl mb-3 text-slate-500">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                Belum ada data calon merchant review card yang tersedia di kategori ini.
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
                <a href="{{ $proposals->previousPageUrl() }}" wire:navigate class="px-4 py-2 text-xs text-blue-400 hover:text-blue-300 font-medium transition-colors">
                    <i class="fa-solid fa-chevron-left mr-1"></i> Sebelumnya
                </a>
                @endif

                @if ($proposals->hasMorePages())
                <a href="{{ $proposals->nextPageUrl() }}" wire:navigate class="px-4 py-2 text-xs text-white bg-blue-600 hover:bg-blue-500 rounded-lg shadow-lg shadow-blue-500/30 font-medium transition-colors">
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
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = 'fixed top-10 left-1/2 -translate-x-1/2 px-5 py-3 rounded-full shadow-2xl z-[80] flex items-center gap-3 text-sm font-medium transition-all duration-500 transform -translate-y-10 opacity-0 min-w-[280px] max-w-[90vw] justify-center';

            if (type === 'success') {
                toast.classList.add('bg-slate-800', 'border', 'border-blue-500/30', 'text-white');
                toast.innerHTML = `<div class="w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 shrink-0"><i class="fa-solid fa-check text-xs"></i></div> <span class="truncate">${message}</span>`;
            } else {
                toast.classList.add('bg-slate-800', 'border', 'border-red-500/30', 'text-white');
                toast.innerHTML = `<div class="w-6 h-6 rounded-full bg-red-500/20 flex items-center justify-center text-red-400 shrink-0"><i class="fa-solid fa-xmark text-xs"></i></div> <span class="truncate">${message}</span>`;
            }

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('-translate-y-10', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('-translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 2500);
        }

        async function kirimWaReviewCard(selectElement, proposalId, brandName, waNumber) {
            if (!selectElement.value) return;

            let text = decodeURIComponent(escape(window.atob(selectElement.value)));

            if (brandName) {
                text = text.replace(/\{nama_bisnis\}/g, brandName);
            }
            text = text.replace(/\{pengirim\}/g, "{{ $affiliate->name }}");

            let formattedNumber = waNumber ? waNumber.toString().replace(/[^0-9]/g, '') : '';
            if (formattedNumber.startsWith('0')) {
                formattedNumber = '62' + formattedNumber.substring(1);
            }

            let waUrl = formattedNumber ?
                `https://api.whatsapp.com/send?phone=${formattedNumber}&text=${encodeURIComponent(text)}` :
                `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;

            // Claim lead review card in background jika di tab global
            if ('{{ $tab }}' === 'global') {
                try {
                    await fetch(`/partner/review-proposals/${proposalId}/claim`, {
                        method: 'POST'
                        , headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            , 'Content-Type': 'application/json'
                            , 'Accept': 'application/json'
                        }
                    });

                    setTimeout(() => {
                        showToast('Berhasil mengklaim lead review card!', 'success');
                        setTimeout(() => window.location.reload(), 1500);
                    }, 2000);
                } catch (e) {
                    console.error("Gagal claim lead", e);
                }
            }

            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                window.location.href = waUrl;
            } else {
                window.open(waUrl, '_blank');
            }

            selectElement.value = "";
        }

        async function generateAiReviewCardChat(btnElement, leadId, waNumber, generateUrl, claimUrl = null) {
            const originalHtml = btnElement.innerHTML;
            btnElement.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            btnElement.disabled = true;

            const aiModal = document.getElementById('aiLoadingModalReview');
            aiModal.classList.remove('hidden');

            try {
                const response = await fetch(generateUrl, {
                    method: 'POST'
                    , headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        , 'Accept': 'application/json'
                        , 'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success && data.text) {
                    if (claimUrl) {
                        try {
                            await fetch(claimUrl, {
                                method: 'POST'
                                , headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    , 'Accept': 'application/json'
                                    , 'Content-Type': 'application/json'
                                }
                            });
                        } catch (e) {}
                    }

                    let formattedNumber = waNumber ? waNumber.toString().replace(/[^0-9]/g, '') : '';
                    if (formattedNumber.startsWith('0')) {
                        formattedNumber = '62' + formattedNumber.substring(1);
                    }

                    let waUrl = formattedNumber ?
                        `https://api.whatsapp.com/send?phone=${formattedNumber}&text=${encodeURIComponent(data.text)}` :
                        `https://api.whatsapp.com/send?text=${encodeURIComponent(data.text)}`;

                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                        let a = document.createElement('a');
                        a.href = waUrl;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    } else {
                        let a = document.createElement('a');
                        a.target = '_blank';
                        a.href = waUrl;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    }

                    if (claimUrl) {
                        setTimeout(() => {
                            window.location.href = "{{ route('affiliate.review_proposals', ['tab' => 'follow_up']) }}";
                        }, 2500);
                    }
                } else {
                    alert('Gagal: ' + (data.message || 'Terjadi kendala'));
                }
            } catch (e) {
                console.error(e);
                alert('Gagal membuat pesan AI.');
            } finally {
                btnElement.innerHTML = originalHtml;
                btnElement.disabled = false;
                aiModal.classList.add('hidden');
            }
        }

        window.kirimWaReviewCard = kirimWaReviewCard;
        window.generateAiReviewCardChat = generateAiReviewCardChat;

        // Search Autocomplete
        const searchInput = document.getElementById('searchInputReview');
        const searchDropdown = document.getElementById('searchDropdownReview');
        const searchResults = document.getElementById('searchResultsReview');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(searchTimeout);

                if (query.length >= 3) {
                    searchTimeout = setTimeout(() => {
                        fetch(`{{ route('affiliate.review_proposals.search') }}?q=${encodeURIComponent(query)}`)
                            .then(res => res.json())
                            .then(data => {
                                searchResults.innerHTML = '';
                                if (data.length > 0) {
                                    data.forEach(item => {
                                        const li = document.createElement('li');
                                        li.innerHTML = `
                                            <a href="{{ route('affiliate.review_proposals', ['tab' => 'follow_up']) }}&search=${encodeURIComponent(item.brand_name)}" wire:navigate class="block px-4 py-3 hover:bg-white/5 transition-colors">
                                                <div class="text-sm font-bold text-white">${item.brand_name}</div>
                                                <div class="text-xs text-slate-400 flex items-center gap-2 mt-1">
                                                    <i class="fa-solid fa-phone"></i> ${item.wa_number}
                                                    <span class="px-1.5 py-0.5 rounded bg-slate-700/50 text-[9px] text-slate-300 ml-auto">${item.category_name || 'Bisnis'}</span>
                                                </div>
                                            </a>
                                        `;
                                        searchResults.appendChild(li);
                                    });
                                    searchDropdown.classList.remove('hidden');
                                } else {
                                    searchResults.innerHTML = '<li class="px-4 py-3 text-xs text-slate-400 text-center">Tidak ada hasil ditemukan</li>';
                                    searchDropdown.classList.remove('hidden');
                                }
                            })
                            .catch(err => console.error(err));
                    }, 300);
                } else {
                    searchDropdown.classList.add('hidden');
                }
            });

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    window.location.href = `{{ route('affiliate.review_proposals', ['tab' => 'follow_up']) }}&search=${encodeURIComponent(this.value.trim())}`;
                }
            });

            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                    searchDropdown.classList.add('hidden');
                }
            });
        }

    </script>

    <!-- AI Loading Modal -->
    <div id="aiLoadingModalReview" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-[#0B1120] border border-blue-500/30 rounded-2xl p-6 text-center shadow-2xl shadow-blue-500/20 max-w-xs w-full animate-pulse">
                <div class="w-16 h-16 bg-blue-500/20 text-blue-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-robot text-3xl"></i>
                </div>
                <h3 class="text-white font-bold text-sm mb-2">AI Sedang Merangkai...</h3>
                <p class="text-xs text-slate-400">Menyusun penawaran Smart Review Card yang persuasif untuk toko ini.</p>
            </div>
        </div>
    </div>
</body>
</html>
