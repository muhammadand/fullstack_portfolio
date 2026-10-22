@extends('layouts.app')

@section('hide_navbar_mobile', true)
@section('hide_footer_mobile', true)
@section('hide_chatbot', true)

@push('meta')
<x-affiliate.pwa-meta />
@endpush

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body {
        background-color: #0B1120;
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
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

    .glass-card {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(30, 58, 138, 0.1));
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.15);
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
@endpush

@section('content')
<!-- Background Decoration -->
<div class="fixed top-0 left-0 w-full h-64 bg-blue-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>
<div class="fixed bottom-0 right-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[100px] translate-y-1/2 translate-x-1/3 pointer-events-none z-0"></div>

<div class="relative z-10 w-full max-w-md mx-auto min-h-screen px-4 pt-6 pb-24 text-white">

    <!-- Top Bar -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('affiliate.dashboard') }}" wire:navigate class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <p class="text-[10px] text-blue-400 font-bold tracking-wider uppercase">Pesan Follow Up</p>
                <h1 class="text-xl font-bold text-white tracking-tight">Template Chat</h1>
            </div>
        </div>
        <button type="button" onclick="openTemplateModal()" class="w-10 h-10 rounded-full bg-blue-600 hover:bg-blue-500 flex items-center justify-center text-white transition-all shadow-[0_0_15px_rgba(37,99,235,0.3)] active:scale-95">
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>

    <!-- Suggestion Button -->
    <div class="mb-4">
        <button type="button" onclick="openSuggestionModal()" class="w-full py-3 glass-panel rounded-2xl flex items-center justify-center gap-2 text-xs font-bold text-blue-400 hover:bg-white/5 transition-all border border-blue-500/30 active:scale-98 shadow-sm">
            <i class="fa-solid fa-lightbulb text-yellow-400"></i> Lihat Contoh Template (Siap Salin)
        </button>
    </div>

    <!-- Tabs Filter: Semua, Website, Kartu Review -->
    <div class="flex p-1 bg-white/5 rounded-2xl mb-5">
        <a href="{{ route('affiliate.chat_templates.index') }}" wire:navigate class="flex-1 py-2 text-xs font-bold text-center rounded-xl transition-all {{ empty($selectedProduct) ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:text-white' }}">
            Semua
        </a>
        <a href="{{ route('affiliate.chat_templates.index', ['product_type' => 'website']) }}" wire:navigate class="flex-1 py-2 text-xs font-bold text-center rounded-xl transition-all {{ $selectedProduct === 'website' ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/30' : 'text-slate-400 hover:text-white' }}">
            <i class="fa-solid fa-globe mr-1 text-[10px]"></i> Website
        </a>
        <a href="{{ route('affiliate.chat_templates.index', ['product_type' => 'review_card']) }}" wire:navigate class="flex-1 py-2 text-xs font-bold text-center rounded-xl transition-all {{ $selectedProduct === 'review_card' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:text-white' }}">
            <i class="fa-solid fa-qrcode mr-1 text-[10px]"></i> Kartu Review
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-2xl mb-6 text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 p-4 rounded-2xl mb-6 text-sm">
        <ul class="list-disc ml-5 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="space-y-4">
        @forelse($templates as $t)
        <div class="glass-panel rounded-3xl overflow-hidden flex flex-col">
            <div class="p-4 border-b border-white/5 flex justify-between items-start bg-white/5">
                <div class="min-w-0 flex-1 pr-2">
                    <h3 class="font-bold text-white tracking-tight truncate">{{ $t->name }}</h3>
                    <div class="flex flex-wrap items-center gap-1.5 mt-1.5">
                        @if(($t->product_type ?? 'website') === 'review_card')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                            <i class="fa-solid fa-qrcode mr-1 text-[8px]"></i> Kartu Review
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                            <i class="fa-solid fa-globe mr-1 text-[8px]"></i> Website
                        </span>
                        @endif

                        @if($t->businessCategory)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-medium bg-white/10 text-slate-300 border border-white/10">
                            {{ $t->businessCategory->name }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="flex gap-2 shrink-0">
                    <button type="button" onclick="openTemplateModal({{ $t->id }}, '{{ addslashes($t->name) }}', '{{ base64_encode($t->content) }}', '{{ $t->business_category_id }}', '{{ $t->product_type ?? 'website' }}')" class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 border border-amber-500/20 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-pen text-xs"></i>
                    </button>
                    <form action="{{ route('affiliate.chat_templates.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus template ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-xl bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 border border-rose-500/20 flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="p-4">
                <div class="bg-emerald-500/10 rounded-xl p-3 border border-emerald-500/20 relative">
                    <div class="absolute -top-3 -right-3 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <p class="text-xs text-emerald-100/80 whitespace-pre-wrap font-mono leading-relaxed">{{ Str::limit($t->content, 150) }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="glass-panel rounded-3xl p-8 text-center flex flex-col items-center">
            <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-2xl text-slate-400 mb-4">
                <i class="fa-regular fa-message"></i>
            </div>
            <h3 class="text-white font-bold mb-2">Belum Ada Template</h3>
            <p class="text-slate-400 text-xs mb-6 max-w-xs leading-relaxed">Buat template kustom Anda sendiri untuk mempermudah saat follow up klien {{ $selectedProduct === 'review_card' ? 'Kartu Review' : ($selectedProduct === 'website' ? 'Website' : '') }}.</p>
            <button type="button" onclick="openTemplateModal(null, '', '', '', '{{ $selectedProduct ?? 'website' }}')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all shadow-[0_0_15px_rgba(37,99,235,0.3)] flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Buat Template Sekarang
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- Suggestion Modal -->
<div id="suggestionModal" class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 overflow-y-auto pb-safe">
    <div class="bg-[#1e293b] w-full max-w-md p-6 rounded-t-3xl sm:rounded-3xl shadow-2xl transform translate-y-full sm:translate-y-0 sm:scale-95 transition-transform duration-300 sm:mx-4 border border-white/10 max-h-[85vh] overflow-y-auto flex flex-col my-auto" id="suggestionModalContent">
        <div class="flex justify-between items-center mb-5 shrink-0">
            <div>
                <h3 class="text-base font-bold text-white flex items-center gap-2"><i class="fa-solid fa-lightbulb text-yellow-400"></i> Contoh Template Siap Salin</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Pilih salah satu template untuk langsung diterapkan</p>
            </div>
            <button type="button" onclick="closeSuggestionModal()" class="text-slate-400 hover:text-white w-8 h-8 rounded-full bg-white/5 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Suggestion Filter Sub-tabs -->
        <div class="flex p-1 bg-black/30 rounded-xl mb-4 shrink-0 text-xs font-bold">
            <button type="button" id="tabSugReview" onclick="switchSugTab('review')" class="flex-1 py-2 rounded-lg text-white bg-blue-600 transition-all flex items-center justify-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-qrcode text-[11px]"></i> Kartu Review
            </button>
            <button type="button" id="tabSugWebsite" onclick="switchSugTab('website')" class="flex-1 py-2 rounded-lg text-slate-400 hover:text-white transition-all flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-globe text-[11px]"></i> Website
            </button>
        </div>

        <div class="space-y-4 overflow-y-auto pr-1">
            <!-- GROUP: KARTU REVIEW -->
            <div id="sugGroupReview" class="space-y-4">
                <!-- Template Review 1 -->
                <div class="bg-slate-900/50 border border-blue-500/20 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-xs text-blue-400">Edukasi Rating Google Maps</h4>
                        <span class="text-[9px] bg-blue-500/20 text-blue-300 px-2 py-0.5 rounded-full font-bold">Kartu Review</span>
                    </div>
                    <p class="text-xs text-slate-300 mb-3 whitespace-pre-wrap font-mono leading-relaxed" id="sug-rev-1">Halo Kak {nama_bisnis}, salam kenal dari {pengirim}.

                        Saya perhatikan bisnis {nama_bisnis} sudah ada di Google Maps, tapi ulasannya masih bisa dimaksimalkan lagi nih kak agar toko selalu muncul di urutan teratas pencarian Google.

                        Sekarang ada cara praktis: *Smart Google Review Card (NFC & QR)*. Pelanggan di kasir cukup tempelkan HP ke kartu, langsung terbuka form ulasan bintang 5 tanpa perlu cari manual.

                        Apakah berkenan jika saya kirimkan info detail & contoh demonya kak? Terima kasih 🙏</p>
                    <button type="button" onclick="useSuggestion('Review Card - Edukasi Rating Google Maps', document.getElementById('sug-rev-1').innerText, 'review_card')" class="w-full py-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-300 text-xs font-bold rounded-xl transition-colors border border-blue-500/30 flex justify-center items-center gap-2">
                        <i class="fa-regular fa-copy"></i> Gunakan Template Ini
                    </button>
                </div>

                <!-- Template Review 2 -->
                <div class="bg-slate-900/50 border border-blue-500/20 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-xs text-blue-400">Solusi Kasir Praktis (Tap NFC)</h4>
                        <span class="text-[9px] bg-blue-500/20 text-blue-300 px-2 py-0.5 rounded-full font-bold">Kartu Review</span>
                    </div>
                    <p class="text-xs text-slate-300 mb-3 whitespace-pre-wrap font-mono leading-relaxed" id="sug-rev-2">Halo Tim {nama_bisnis}, izin sharing solusi praktis untuk kasir toko.

                        Seringkali pelanggan puas tapi malas atau lupa kasih review di Google Maps karena ribet harus search nama toko dulu.

                        Dengan *Kartu Google Review Pintar*, pelanggan cukup tempel HP (NFC) atau scan QR di meja kasir, hitungan 3 detik langsung diarahkan kasih ulasan bintang 5 ⭐⭐⭐⭐⭐.

                        Bisa custom nama & logo {nama_bisnis} juga kak. Boleh saya kirimkan preview kartu & promo spesialnya kak?</p>
                    <button type="button" onclick="useSuggestion('Review Card - Solusi Kasir Praktis', document.getElementById('sug-rev-2').innerText, 'review_card')" class="w-full py-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-300 text-xs font-bold rounded-xl transition-colors border border-blue-500/30 flex justify-center items-center gap-2">
                        <i class="fa-regular fa-copy"></i> Gunakan Template Ini
                    </button>
                </div>

                <!-- Template Review 3 -->
                <div class="bg-slate-900/50 border border-blue-500/20 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-xs text-blue-400">Promo Khusus Merchant Lokal</h4>
                        <span class="text-[9px] bg-blue-500/20 text-blue-300 px-2 py-0.5 rounded-full font-bold">Kartu Review</span>
                    </div>
                    <p class="text-xs text-slate-300 mb-3 whitespace-pre-wrap font-mono leading-relaxed" id="sug-rev-3">Selamat siang Kak, salam kenal saya {pengirim}.

                        Untuk mendukung kemajuan usaha lokal di sekitar, kami lagi ada program promo khusus merchant: *Smart NFC Review Card Toko* untuk meningkatkan reputasi & bintang Google Maps bisnis {nama_bisnis}.

                        Kartunya siap pakai tanpa baterai, tanpa biaya langganan bulanan, dan langsung aktif selamanya.

                        Kira-kira nomor ini terhubung dengan owner / manager {nama_bisnis} kak? Ada penawaran khusus minggu ini. Terima kasih kak!</p>
                    <button type="button" onclick="useSuggestion('Review Card - Promo Merchant Lokal', document.getElementById('sug-rev-3').innerText, 'review_card')" class="w-full py-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-300 text-xs font-bold rounded-xl transition-colors border border-blue-500/30 flex justify-center items-center gap-2">
                        <i class="fa-regular fa-copy"></i> Gunakan Template Ini
                    </button>
                </div>
            </div>

            <!-- GROUP: WEBSITE -->
            <div id="sugGroupWebsite" class="space-y-4 hidden">
                <!-- Template 1 -->
                <div class="bg-slate-900/50 border border-slate-700/50 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-xs text-rose-400">Perkenalan Singkat</h4>
                        <span class="text-[9px] bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded-full font-bold">Website</span>
                    </div>
                    <p class="text-xs text-slate-300 mb-3 whitespace-pre-wrap font-mono leading-relaxed" id="sug-1">Halo {nama_bisnis}, perkenalkan saya partner dari Scalify. Kami menyediakan solusi digitalisasi (website, kasir, dll) yang bisa membantu operasional bisnis Anda jadi lebih efisien dan modern. Boleh saya kirimkan proposal penawarannya? Info lengkap: {link_landing}</p>
                    <button type="button" onclick="useSuggestion('Perkenalan Singkat (General)', document.getElementById('sug-1').innerText, 'website')" class="w-full py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-bold rounded-xl transition-colors border border-white/10 flex justify-center items-center gap-2">
                        <i class="fa-regular fa-copy"></i> Gunakan Template Ini
                    </button>
                </div>

                <!-- Template 2 -->
                <div class="bg-slate-900/50 border border-slate-700/50 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-xs text-rose-400">Follow Up Proposal</h4>
                        <span class="text-[9px] bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded-full font-bold">Website</span>
                    </div>
                    <p class="text-xs text-slate-300 mb-3 whitespace-pre-wrap font-mono leading-relaxed" id="sug-2">Selamat siang {nama_bisnis}, menindaklanjuti obrolan kita sebelumnya, berikut adalah proposal lengkap mengenai solusi digital dari Scalify:
                        {link_proposal}

                        Jika ada yang ingin didiskusikan lebih lanjut, silakan hubungi saya kembali ya. Terima kasih!</p>
                    <button type="button" onclick="useSuggestion('Follow Up Proposal', document.getElementById('sug-2').innerText, 'website')" class="w-full py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-bold rounded-xl transition-colors border border-white/10 flex justify-center items-center gap-2">
                        <i class="fa-regular fa-copy"></i> Gunakan Template Ini
                    </button>
                </div>

                <!-- Template 3 -->
                <div class="bg-slate-900/50 border border-slate-700/50 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-xs text-rose-400">Penawaran Promo Khusus</h4>
                        <span class="text-[9px] bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded-full font-bold">Website</span>
                    </div>
                    <p class="text-xs text-slate-300 mb-3 whitespace-pre-wrap font-mono leading-relaxed" id="sug-3">Halo {nama_bisnis}! Khusus bulan ini, Scalify sedang mengadakan promo spesial untuk pembuatan website dan sistem kasir. Sangat cocok untuk meningkatkan penjualan bisnis Anda! Yuk cek promonya di sini: {link_landing}</p>
                    <button type="button" onclick="useSuggestion('Penawaran Promo Khusus', document.getElementById('sug-3').innerText, 'website')" class="w-full py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-bold rounded-xl transition-colors border border-white/10 flex justify-center items-center gap-2">
                        <i class="fa-regular fa-copy"></i> Gunakan Template Ini
                    </button>
                </div>

                <!-- Template 4 -->
                <div class="bg-slate-900/50 border border-slate-700/50 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-xs text-rose-400">Penawaran Bantuan Skripsi/Tugas Akhir</h4>
                        <span class="text-[9px] bg-rose-500/20 text-rose-300 px-2 py-0.5 rounded-full font-bold">Website</span>
                    </div>
                    <p class="text-xs text-slate-300 mb-3 whitespace-pre-wrap font-mono leading-relaxed" id="sug-4">Halo {nama}, kenalin aku {{ auth()->guard('affiliate')->user()->name }}. Sebentar lagi kamu mau skripsian ya, aku ada penawaran barangkali kamu mau bikin website nya disini itu bisa banget ya, ini ada beberapa methode yang bisa dibuat atau costume juga boleh. Kamu bisa cek detailnya di sini: {{ url('/sobat-scalify') }}?ref={{ auth()->guard('affiliate')->user()->affiliate_code }}</p>
                    <button type="button" onclick="useSuggestion('Bantuan Project Skripsi', document.getElementById('sug-4').innerText, 'website')" class="w-full py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-bold rounded-xl transition-colors border border-white/10 flex justify-center items-center gap-2">
                        <i class="fa-regular fa-copy"></i> Gunakan Template Ini
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template Form Modal -->
<div id="templateModal" class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 overflow-y-auto pb-safe">
    <div class="bg-[#1e293b] w-full max-w-md p-6 rounded-t-3xl sm:rounded-3xl shadow-2xl transform translate-y-full sm:translate-y-0 sm:scale-95 transition-transform duration-300 sm:mx-4 border border-white/10 max-h-[85vh] overflow-y-auto flex flex-col my-auto" id="templateModalContent">
        <div class="flex justify-between items-center mb-5 shrink-0">
            <h3 class="text-base font-bold text-white tracking-tight" id="modalTitle">Tambah Template Baru</h3>
            <button type="button" onclick="closeTemplateModal()" class="text-slate-400 hover:text-white w-8 h-8 rounded-full bg-white/5 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="templateForm" action="{{ route('affiliate.chat_templates.store') }}" method="POST" class="flex flex-col flex-1 pb-4">
            @csrf
            <div id="methodField"></div>

            <!-- Target Produk -->
            <div class="mb-4">
                <label class="block text-xs font-medium text-slate-400 mb-1.5 ml-1">Target Produk</label>
                <input type="hidden" name="product_type" id="productTypeInput" value="website">
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" id="btnSelectWebsite" onclick="setProductType('website')" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl border border-rose-500 bg-rose-500/25 text-white text-xs font-bold transition-all shadow-md shadow-rose-500/20 active:scale-95 cursor-pointer">
                        <i class="fa-solid fa-globe text-xs text-rose-400"></i>
                        <span>Website</span>
                        <i class="fa-solid fa-circle-check text-xs text-rose-400 ml-1" id="checkWebsite"></i>
                    </button>
                    <button type="button" id="btnSelectReview" onclick="setProductType('review_card')" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl border border-white/10 bg-slate-900/50 text-slate-400 hover:text-white text-xs font-semibold transition-all active:scale-95 cursor-pointer">
                        <i class="fa-solid fa-qrcode text-xs text-blue-400"></i>
                        <span>Kartu Review</span>
                        <i class="fa-solid fa-circle-check text-xs text-blue-400 ml-1 hidden" id="checkReview"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-medium text-slate-400 mb-1.5 ml-1">Nama Template</label>
                <input type="text" name="name" id="templateName" required class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-xl py-3 px-4 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-sm placeholder:text-slate-600" placeholder="Contoh: Penawaran Promo Review Toko">
            </div>

            <div class="mb-4">
                <label class="block text-xs font-medium text-slate-400 mb-1.5 ml-1">Kategori Bisnis (Opsional)</label>
                <select name="business_category_id" id="businessCategoryId" class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-xl py-3 px-4 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-sm appearance-none" onchange="toggleNewCategory(this)">
                    <option value="" class="bg-slate-800">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" class="bg-slate-800">{{ $cat->name }}</option>
                    @endforeach
                    <option value="new" class="bg-slate-800 font-bold text-blue-400">+ Tambah Kategori Baru</option>
                </select>
            </div>

            <div class="mb-4 hidden" id="newCategoryContainer">
                <label class="block text-xs font-medium text-slate-400 mb-1.5 ml-1">Nama Kategori Baru</label>
                <input type="text" name="new_business_category" id="newBusinessCategory" class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-xl py-3 px-4 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-sm placeholder:text-slate-600" placeholder="Contoh: Kuliner">
            </div>

            <div class="mb-6 flex-1">
                <label class="block text-xs font-medium text-slate-400 mb-1.5 ml-1">Isi Pesan</label>
                <textarea name="content" id="templateContent" rows="5" required class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-xl py-3 px-4 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-sm placeholder:text-slate-600 font-mono leading-relaxed" placeholder="Halo {nama_bisnis}, kami dari..."></textarea>
                <p class="text-[10px] text-slate-500 mt-2">Placeholder: <code class="bg-slate-800 px-1 py-0.5 rounded text-blue-300">{nama_bisnis}</code>, <code class="bg-slate-800 px-1 py-0.5 rounded text-blue-300">{link_proposal}</code>, <code class="bg-slate-800 px-1 py-0.5 rounded text-blue-300">{link_landing}</code></p>
            </div>

            <button type="submit" class="w-full py-3.5 mt-auto bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl transition-all shadow-[0_0_15px_rgba(37,99,235,0.3)] active:scale-98">
                Simpan Template
            </button>
        </form>
    </div>
</div>

<!-- Bottom Navigation -->
<x-affiliate.bottom-nav />

<x-affiliate.scripts />

<script>
    function switchSugTab(tab) {
        const btnRev = document.getElementById('tabSugReview');
        const btnWeb = document.getElementById('tabSugWebsite');
        const grpRev = document.getElementById('sugGroupReview');
        const grpWeb = document.getElementById('sugGroupWebsite');

        if (tab === 'review') {
            btnRev.className = "flex-1 py-2 rounded-lg text-white bg-blue-600 transition-all flex items-center justify-center gap-1.5 shadow-sm";
            btnWeb.className = "flex-1 py-2 rounded-lg text-slate-400 hover:text-white transition-all flex items-center justify-center gap-1.5";
            grpRev.classList.remove('hidden');
            grpWeb.classList.add('hidden');
        } else {
            btnWeb.className = "flex-1 py-2 rounded-lg text-white bg-rose-600 transition-all flex items-center justify-center gap-1.5 shadow-sm";
            btnRev.className = "flex-1 py-2 rounded-lg text-slate-400 hover:text-white transition-all flex items-center justify-center gap-1.5";
            grpWeb.classList.remove('hidden');
            grpRev.classList.add('hidden');
        }
    }

    function openSuggestionModal() {
        const modal = document.getElementById('suggestionModal');
        const modalContent = document.getElementById('suggestionModalContent');

        modal.classList.remove('opacity-0', 'pointer-events-none');
        if (window.innerWidth < 640) {
            modalContent.classList.remove('translate-y-full');
        } else {
            modalContent.classList.remove('sm:scale-95');
            modalContent.classList.add('sm:scale-100');
        }
    }

    function closeSuggestionModal() {
        const modal = document.getElementById('suggestionModal');
        const modalContent = document.getElementById('suggestionModalContent');

        if (window.innerWidth < 640) {
            modalContent.classList.add('translate-y-full');
        } else {
            modalContent.classList.remove('sm:scale-100');
            modalContent.classList.add('sm:scale-95');
        }

        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }

    function setProductType(type) {
        const input = document.getElementById('productTypeInput');
        const btnWeb = document.getElementById('btnSelectWebsite');
        const btnRev = document.getElementById('btnSelectReview');
        const checkWeb = document.getElementById('checkWebsite');
        const checkRev = document.getElementById('checkReview');

        if (!input || !btnWeb || !btnRev) return;

        input.value = type;

        if (type === 'review_card') {
            btnRev.className = "flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl border border-blue-500 bg-blue-500/25 text-white text-xs font-bold transition-all shadow-md shadow-blue-500/20 active:scale-95 cursor-pointer";
            btnWeb.className = "flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl border border-white/10 bg-slate-900/50 text-slate-400 hover:text-white text-xs font-semibold transition-all active:scale-95 cursor-pointer";
            if (checkRev) checkRev.classList.remove('hidden');
            if (checkWeb) checkWeb.classList.add('hidden');
        } else {
            btnWeb.className = "flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl border border-rose-500 bg-rose-500/25 text-white text-xs font-bold transition-all shadow-md shadow-rose-500/20 active:scale-95 cursor-pointer";
            btnRev.className = "flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl border border-white/10 bg-slate-900/50 text-slate-400 hover:text-white text-xs font-semibold transition-all active:scale-95 cursor-pointer";
            if (checkWeb) checkWeb.classList.remove('hidden');
            if (checkRev) checkRev.classList.add('hidden');
        }
    }

    function useSuggestion(name, content, productType = 'website') {
        closeSuggestionModal();
        setTimeout(() => {
            openTemplateModal(null, name, btoa(unescape(encodeURIComponent(content))), '', productType);
        }, 300);
    }

    function openTemplateModal(id = null, name = '', contentB64 = '', categoryId = '', productType = 'website') {
        const modal = document.getElementById('templateModal');
        const modalContent = document.getElementById('templateModalContent');
        const form = document.getElementById('templateForm');
        const title = document.getElementById('modalTitle');
        const nameInput = document.getElementById('templateName');
        const categoryInput = document.getElementById('businessCategoryId');
        const contentInput = document.getElementById('templateContent');
        const methodField = document.getElementById('methodField');

        // Set visual & input state for Target Produk
        setProductType(productType || 'website');

        if (id) {
            title.textContent = 'Edit Template';
            form.action = `/partner/chat-templates/${id}`;
            methodField.innerHTML = '@method("PUT")';
            nameInput.value = name;
            categoryInput.value = categoryId;
            contentInput.value = decodeURIComponent(escape(window.atob(contentB64)));
        } else {
            title.textContent = 'Tambah Template Baru';
            form.action = "{{ route('affiliate.chat_templates.store') }}";
            methodField.innerHTML = '';
            nameInput.value = '';
            categoryInput.value = '';
            contentInput.value = '';
        }

        modal.classList.remove('opacity-0', 'pointer-events-none');

        if (window.innerWidth < 640) {
            modalContent.classList.remove('translate-y-full');
        } else {
            modalContent.classList.remove('sm:scale-95');
            modalContent.classList.add('sm:scale-100');
        }
    }

    function closeTemplateModal() {
        const modal = document.getElementById('templateModal');
        const modalContent = document.getElementById('templateModalContent');

        if (window.innerWidth < 640) {
            modalContent.classList.add('translate-y-full');
        } else {
            modalContent.classList.remove('sm:scale-100');
            modalContent.classList.add('sm:scale-95');
        }

        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }

    function toggleNewCategory(select) {
        const container = document.getElementById('newCategoryContainer');
        const input = document.getElementById('newBusinessCategory');

        if (select.value === 'new') {
            container.classList.remove('hidden');
            input.setAttribute('required', 'required');
            input.focus();
        } else {
            container.classList.add('hidden');
            input.removeAttribute('required');
            input.value = '';
        }
    }

</script>
@endsection
