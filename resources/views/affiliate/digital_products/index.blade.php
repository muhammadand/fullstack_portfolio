<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Katalog Produk Digital (Lynk.id) - Sobat Scalify</title>
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

        .glass-card {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(30, 58, 138, 0.15));
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(245, 158, 11, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
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
    <div class="fixed top-0 left-0 w-full h-64 bg-amber-600/15 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-0 w-64 h-64 bg-blue-600/20 rounded-full blur-[100px] translate-y-1/2 translate-x-1/3 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center">
                <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div class="ml-3">
                    <h1 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-orange-400">Produk Digital</h1>
                    <p class="text-[11px] text-slate-400">Katalog Affiliate Lynk.id</p>
                </div>
            </div>
            <button type="button" onclick="openInfoModal()" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-amber-400 hover:text-amber-300 hover:bg-white/10 transition-colors shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                <i class="fa-solid fa-circle-question text-lg"></i>
            </button>
        </div>

        <!-- Banner Info Link Lynk.id Affiliate -->
        @if($affiliate->lynk_id_link)
        <div class="glass-card p-4 rounded-2xl mb-5 relative overflow-hidden">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-link"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs font-bold text-white">Akun Lynk.id Aktif</span>
                            <span class="inline-block w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        </div>
                        <p class="text-[11px] text-slate-300 truncate font-mono">{{ $affiliate->lynk_id_link }}</p>
                    </div>
                </div>
                <span class="shrink-0 text-[10px] bg-green-500/20 border border-green-500/40 text-green-400 font-bold px-2 py-1 rounded-lg">
                    {{ (int)($affiliate->lynk_commission_rate ?? 10) }}% Komisi
                </span>
            </div>
        </div>
        @else
        <div class="bg-gradient-to-r from-amber-500/20 to-orange-500/20 border border-amber-500/40 p-4 rounded-2xl mb-5 relative">
            <div class="flex items-start gap-3">
                <i class="fa-solid fa-triangle-exclamation text-amber-400 text-lg mt-0.5"></i>
                <div class="flex-1">
                    <h3 class="text-xs font-bold text-amber-300 mb-1">Belum Terhubung ke Lynk.id</h3>
                    <p class="text-[11px] text-slate-300 leading-relaxed mb-3">
                        Masukkan Link Lynk.id kamu di profil agar tombol salin link produk dapat digunakan secara otomatis.
                    </p>
                    <a href="{{ route('affiliate.profile') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-black text-xs font-bold rounded-lg transition-colors">
                        <i class="fa-solid fa-gear"></i> Set Link Lynk.id di Profil
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Search Bar -->
        <form method="GET" action="{{ route('affiliate.digital_products.index') }}" class="mb-4">
            @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari source code, template, skripsi..." class="w-full bg-white/5 border border-white/10 rounded-xl py-2.5 pl-9 pr-8 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-amber-500/50 transition-colors">
                @if(request('search'))
                <a href="{{ route('affiliate.digital_products.index', ['category' => request('category')]) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white text-xs">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                @endif
            </div>
        </form>

        <!-- Category Pills (Horizontal Scroll) -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-4 hide-scrollbar">
            <a href="{{ route('affiliate.digital_products.index', ['search' => request('search')]) }}" class="shrink-0 px-3 py-1.5 rounded-xl text-xs font-medium transition-all {{ !request('category') ? 'bg-amber-500 text-black font-bold shadow-lg shadow-amber-500/30' : 'glass-panel text-slate-300 hover:text-white' }}">
                Semua ({{ \App\Models\DigitalProduct::active()->count() }})
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('affiliate.digital_products.index', ['category' => $cat, 'search' => request('search')]) }}" class="shrink-0 px-3 py-1.5 rounded-xl text-xs font-medium transition-all {{ request('category') === $cat ? 'bg-amber-500 text-black font-bold shadow-lg shadow-amber-500/30' : 'glass-panel text-slate-300 hover:text-white' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>

        <!-- Product Cards List -->
        <div class="space-y-4">
            @forelse($products as $product)
            @php
            $affiliateUrl = $product->getAffiliateUrl($affiliate);
            $commissionRate = $affiliate && $affiliate->lynk_commission_rate ? (float)$affiliate->lynk_commission_rate : 10.00;
            $commissionAmount = $product->calculateCommission($affiliate);
            $encodedUrl = urlencode($affiliateUrl ?? '');
            $waText = urlencode("Halo! Saya mau rekomendasikan produk digital ini:\n\n*{$product->name}*\n\n{$product->short_description}\n\nHarga: Rp " . number_format($product->price, 0, ',', '.') . "\n\nCek dan dapatkan langsung di sini:\n" . ($affiliateUrl ?? ''));
            @endphp
            <div class="glass-panel p-4 rounded-2xl relative overflow-hidden group hover:border-amber-500/30 transition-all">
                <!-- Ambient Glow -->
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-amber-500/10 rounded-full blur-xl group-hover:bg-amber-500/20 transition-all pointer-events-none"></div>

                <!-- Top Badges -->
                <div class="flex items-center justify-between gap-2 mb-2.5">
                    <span class="text-[10px] font-semibold bg-white/10 text-amber-300 px-2.5 py-0.5 rounded-lg border border-white/5">
                        <i class="fa-solid fa-tag text-[9px] mr-1"></i>{{ $product->category ?? 'Produk Digital' }}
                    </span>
                    <span class="text-[11px] font-bold text-green-400 bg-green-500/10 border border-green-500/20 px-2 py-0.5 rounded-lg">
                        Komisi Kamu: Rp {{ number_format($commissionAmount, 0, ',', '.') }} ({{ (int)$commissionRate }}%)
                    </span>
                </div>

                <!-- Title & Description -->
                <h3 class="text-sm font-bold text-white mb-1.5 leading-snug">
                    {{ $product->name }}
                </h3>
                <p class="text-[11px] text-slate-300 leading-relaxed mb-3 line-clamp-2">
                    {{ $product->short_description ?? $product->description }}
                </p>

                <!-- Price & Lynk Slug Info -->
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-white/5 text-xs">
                    <div>
                        <span class="text-[10px] text-slate-400 block">Harga Produk</span>
                        <span class="text-sm font-black text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 block">Kode Lynk</span>
                        <code class="text-[11px] text-amber-300 font-mono bg-white/5 px-2 py-0.5 rounded">{{ $product->lynk_slug }}</code>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($affiliateUrl)
                <div class="grid grid-cols-2 gap-2">
                    <!-- Copy Link Button -->
                    <button type="button" onclick="copyAffiliateLink('{{ $affiliateUrl }}', '{{ addslashes($product->name) }}')" class="w-full py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-black font-bold rounded-xl text-xs transition-all shadow-md shadow-amber-500/20 flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-copy"></i> Salin Link
                    </button>

                    <!-- Share WhatsApp Button -->
                    <a href="https://wa.me/?text={{ $waText }}" target="_blank" class="w-full py-2.5 bg-green-600/20 hover:bg-green-600/30 border border-green-500/40 text-green-300 font-bold rounded-xl text-xs transition-all flex items-center justify-center gap-1.5">
                        <i class="fa-brands fa-whatsapp text-green-400"></i> Share WA
                    </a>
                </div>
                @else
                <a href="{{ route('affiliate.profile') }}" class="w-full py-2.5 bg-white/10 hover:bg-white/15 text-slate-300 font-semibold rounded-xl text-xs transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-link-slash text-amber-400"></i> Atur Link Lynk.id di Profil
                </a>
                @endif
            </div>
            @empty
            <div class="glass-panel p-8 rounded-2xl text-center">
                <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-3 text-slate-400 text-lg">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="text-sm font-bold text-white mb-1">Produk Tidak Ditemukan</h3>
                <p class="text-xs text-slate-400 mb-4">Coba cari dengan kata kunci lain atau pilih kategori lain.</p>
                <a href="{{ route('affiliate.digital_products.index') }}" class="inline-flex items-center gap-1.5 text-xs text-amber-400 hover:underline">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
            </div>
            @endforelse
        </div>

    </div>

    <!-- Info Modal -->
    <div id="infoModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeInfoModal()"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm px-4">
            <div class="bg-[#0B1120] border border-white/10 rounded-[2rem] p-6 shadow-2xl transform transition-all scale-95 opacity-0" id="infoModalContent">
                <div class="w-14 h-14 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fa-solid fa-cube"></i>
                </div>

                <h3 class="text-lg font-bold text-white text-center mb-2">Tentang Produk Digital Lynk.id</h3>
                <p class="text-xs text-slate-300 text-center mb-6 leading-relaxed">
                    Setiap produk yang kamu bagikan memiliki link unik tersambung ke akun affiliate Lynk.id kamu.
                </p>

                <div class="space-y-3 mb-6">
                    <div class="bg-white/5 p-3 rounded-xl border border-white/5 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center shrink-0 text-xs font-bold mt-0.5">1</div>
                        <div>
                            <h4 class="text-xs font-bold text-white">Komisi 10% Otomatis</h4>
                            <p class="text-[11px] text-slate-400">Setiap ada penjualan dari link kamu, Lynk.id otomatis memberikan komisi 10% ke saldo Lynk.id kamu.</p>
                        </div>
                    </div>

                    <div class="bg-white/5 p-3 rounded-xl border border-white/5 flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0 text-xs font-bold mt-0.5">2</div>
                        <div>
                            <h4 class="text-xs font-bold text-white">Otomatis Per Produk</h4>
                            <p class="text-[11px] text-slate-400">Link produk otomatis menyesuaikan kode affiliate kamu: <code class="text-amber-300 font-mono text-[10px]">https://lynk.id/a/[kode]/[slug]</code></p>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="closeInfoModal()" class="w-full py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-black rounded-xl text-xs font-bold transition-all">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-slate-900 border border-amber-500/40 text-white px-4 py-3 rounded-2xl shadow-2xl flex items-center gap-3 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none max-w-xs w-full">
        <div class="w-8 h-8 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 text-sm">
            <i class="fa-solid fa-check"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xs font-bold text-white" id="toastTitle">Link Berhasil Disalin!</p>
            <p class="text-[10px] text-slate-300 truncate" id="toastDesc">Siap dibagikan ke calon pembeli</p>
        </div>
    </div>

    <x-affiliate.bottom-nav />
    <x-affiliate.scripts />

    <script>
        function copyAffiliateLink(url, productName) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(() => {
                    showCustomToast(productName);
                }).catch(() => {
                    fallbackCopyText(url, productName);
                });
            } else {
                fallbackCopyText(url, productName);
            }
        }

        function fallbackCopyText(text, productName) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            textArea.style.top = "-999999px";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                showCustomToast(productName);
            } catch (err) {
                alert("Gagal menyalin link: " + text);
            }
            document.body.removeChild(textArea);
        }

        function showCustomToast(productName) {
            const toast = document.getElementById('toast');
            const desc = document.getElementById('toastDesc');
            desc.textContent = productName;

            toast.classList.remove('translate-y-20', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 2500);
        }

        function openInfoModal() {
            const modal = document.getElementById('infoModal');
            const content = document.getElementById('infoModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeInfoModal() {
            const modal = document.getElementById('infoModal');
            const content = document.getElementById('infoModalContent');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

    </script>
</body>
</html>
