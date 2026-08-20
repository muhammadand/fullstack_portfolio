@extends('layouts.app')

@section('hide_navbar_mobile', true)
@section('hide_footer_mobile', true)
@section('hide_chatbot', true)

@push('meta')
<x-affiliate.pwa-meta />
@endpush

@push('styles')
<style>
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

    body {
        background-color: #0B1120;
    }

</style>
@endpush

@section('content')
<!-- Background Decoration -->
<div class="fixed top-0 left-0 w-full h-64 bg-blue-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>
<div class="fixed bottom-0 right-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[100px] translate-y-1/2 translate-x-1/3 pointer-events-none z-0"></div>

<div class="relative z-10 w-full max-w-md mx-auto min-h-screen px-4 pt-6 pb-24 text-white font-sans">

    <!-- Top Bar -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="text-xl font-bold">Template Chat</h1>
        </div>
        <button type="button" onclick="openTemplateModal()" class="w-10 h-10 rounded-full bg-blue-600 hover:bg-blue-500 flex items-center justify-center text-white transition-colors shadow-[0_0_15px_rgba(37,99,235,0.3)]">
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>

    <!-- Suggestion Button -->
    <div class="mb-6">
        <button type="button" onclick="openSuggestionModal()" class="w-full py-3 glass-panel rounded-2xl flex items-center justify-center gap-2 text-sm font-bold text-blue-400 hover:bg-white/5 transition-colors border-blue-500/30">
            <i class="fa-solid fa-lightbulb text-yellow-400"></i> Lihat Contoh Template (Siap Salin)
        </button>
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
                <div>
                    <h3 class="font-bold text-white">{{ $t->name }}</h3>
                    @if($t->businessCategory)
                    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-blue-500/20 text-blue-300 border border-blue-500/30">
                        {{ $t->businessCategory->name }}
                    </span>
                    @endif
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="openTemplateModal({{ $t->id }}, '{{ addslashes($t->name) }}', '{{ base64_encode($t->content) }}', '{{ $t->business_category_id }}')" class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 border border-amber-500/20 flex items-center justify-center transition-colors">
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
                    <p class="text-xs text-emerald-100/70 whitespace-pre-wrap font-mono leading-relaxed">{{ Str::limit($t->content, 150) }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="glass-panel rounded-3xl p-8 text-center flex flex-col items-center">
            <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-2xl text-slate-400 mb-4">
                <i class="fa-regular fa-message"></i>
            </div>
            <h3 class="text-white font-bold mb-2">Belum Ada Template</h3>
            <p class="text-slate-400 text-sm mb-6">Buat template kustom Anda sendiri untuk mempermudah saat follow up klien.</p>
            <button type="button" onclick="openTemplateModal()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-xl transition-all shadow-[0_0_15px_rgba(37,99,235,0.3)] flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Buat Template
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- Suggestion Modal -->
<div id="suggestionModal" class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 overflow-y-auto pb-safe">
    <div class="bg-[#1e293b] w-full max-w-md p-6 rounded-t-3xl sm:rounded-3xl shadow-2xl transform translate-y-full sm:translate-y-0 sm:scale-95 transition-transform duration-300 sm:mx-4 border border-white/10 max-h-[85vh] overflow-y-auto flex flex-col my-auto" id="suggestionModalContent">
        <div class="flex justify-between items-center mb-6 shrink-0">
            <h3 class="text-lg font-bold text-white flex items-center gap-2"><i class="fa-solid fa-lightbulb text-yellow-400"></i> Contoh Template</h3>
            <button type="button" onclick="closeSuggestionModal()" class="text-slate-400 hover:text-white w-8 h-8 rounded-full bg-white/5 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="space-y-4">
            <!-- Template 1 -->
            <div class="bg-slate-900/50 border border-slate-700/50 rounded-2xl p-4">
                <h4 class="font-bold text-sm text-blue-400 mb-2">Perkenalan Singkat</h4>
                <p class="text-xs text-slate-300 mb-3 whitespace-pre-wrap font-mono leading-relaxed" id="sug-1">Halo {nama_bisnis}, perkenalkan saya partner dari Scalify. Kami menyediakan solusi digitalisasi (website, kasir, dll) yang bisa membantu operasional bisnis Anda jadi lebih efisien dan modern. Boleh saya kirimkan proposal penawarannya? Info lengkap: {link_landing}</p>
                <button type="button" onclick="useSuggestion('Perkenalan Singkat (General)', document.getElementById('sug-1').innerText)" class="w-full py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-bold rounded-xl transition-colors border border-white/10 flex justify-center items-center gap-2">
                    <i class="fa-regular fa-copy"></i> Gunakan Template Ini
                </button>
            </div>

            <!-- Template 2 -->
            <div class="bg-slate-900/50 border border-slate-700/50 rounded-2xl p-4">
                <h4 class="font-bold text-sm text-blue-400 mb-2">Follow Up Proposal</h4>
                <p class="text-xs text-slate-300 mb-3 whitespace-pre-wrap font-mono leading-relaxed" id="sug-2">Selamat siang {nama_bisnis}, menindaklanjuti obrolan kita sebelumnya, berikut adalah proposal lengkap mengenai solusi digital dari Scalify:
                    {link_proposal}

                    Jika ada yang ingin didiskusikan lebih lanjut, silakan hubungi saya kembali ya. Terima kasih!</p>
                <button type="button" onclick="useSuggestion('Follow Up Proposal', document.getElementById('sug-2').innerText)" class="w-full py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-bold rounded-xl transition-colors border border-white/10 flex justify-center items-center gap-2">
                    <i class="fa-regular fa-copy"></i> Gunakan Template Ini
                </button>
            </div>

            <!-- Template 3 -->
            <div class="bg-slate-900/50 border border-slate-700/50 rounded-2xl p-4">
                <h4 class="font-bold text-sm text-blue-400 mb-2">Penawaran Promo Khusus</h4>
                <p class="text-xs text-slate-300 mb-3 whitespace-pre-wrap font-mono leading-relaxed" id="sug-3">Halo {nama_bisnis}! Khusus bulan ini, Scalify sedang mengadakan promo spesial untuk pembuatan website dan sistem kasir. Sangat cocok untuk meningkatkan penjualan bisnis Anda! Yuk cek promonya di sini: {link_landing}</p>
                <button type="button" onclick="useSuggestion('Penawaran Promo Khusus', document.getElementById('sug-3').innerText)" class="w-full py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-bold rounded-xl transition-colors border border-white/10 flex justify-center items-center gap-2">
                    <i class="fa-regular fa-copy"></i> Gunakan Template Ini
                </button>
            </div>

            <!-- Template 4 -->
            <div class="bg-slate-900/50 border border-slate-700/50 rounded-2xl p-4">
                <h4 class="font-bold text-sm text-blue-400 mb-2">Penawaran Bantuan Skripsi/Tugas Akhir</h4>
                <p class="text-xs text-slate-300 mb-3 whitespace-pre-wrap font-mono leading-relaxed" id="sug-4">Halo {nama}, kenalin aku {{ auth()->guard('affiliate')->user()->name }}. Sebentar lagi kamu mau skripsian ya, aku ada penawaran barangkali kamu mau bikin website nya disini itu bisa banget ya, ini ada beberapa methode yang bisa dibuat atau costume juga boleh. Kamu bisa cek detailnya di sini: {{ url('/sobat-scalify') }}?ref={{ auth()->guard('affiliate')->user()->affiliate_code }}</p>
                <button type="button" onclick="useSuggestion('Bantuan Project Skripsi', document.getElementById('sug-4').innerText)" class="w-full py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-bold rounded-xl transition-colors border border-white/10 flex justify-center items-center gap-2">
                    <i class="fa-regular fa-copy"></i> Gunakan Template Ini
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Template Form Modal -->
<div id="templateModal" class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 overflow-y-auto pb-safe">
    <div class="bg-[#1e293b] w-full max-w-md p-6 rounded-t-3xl sm:rounded-3xl shadow-2xl transform translate-y-full sm:translate-y-0 sm:scale-95 transition-transform duration-300 sm:mx-4 border border-white/10 max-h-[85vh] overflow-y-auto flex flex-col my-auto" id="templateModalContent">
        <div class="flex justify-between items-center mb-6 shrink-0">
            <h3 class="text-lg font-bold text-white" id="modalTitle">Tambah Template Baru</h3>
            <button type="button" onclick="closeTemplateModal()" class="text-slate-400 hover:text-white w-8 h-8 rounded-full bg-white/5 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="templateForm" action="{{ route('affiliate.chat_templates.store') }}" method="POST" class="flex flex-col flex-1 pb-4">
            @csrf
            <div id="methodField"></div>

            <div class="mb-4">
                <label class="block text-xs font-medium text-slate-400 mb-1.5 ml-1">Nama Template</label>
                <input type="text" name="name" id="templateName" required class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-xl py-3 px-4 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-sm placeholder:text-slate-600" placeholder="Contoh: Penawaran Promo">
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

            <button type="submit" class="w-full py-3.5 mt-auto bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl transition-all shadow-[0_0_15px_rgba(37,99,235,0.3)]">
                Simpan Template
            </button>
        </form>
    </div>
</div>

<!-- Bottom Navigation -->
<x-affiliate.bottom-nav />

<x-affiliate.scripts />

<script>
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

    function useSuggestion(name, content) {
        closeSuggestionModal();
        setTimeout(() => {
            openTemplateModal();
            document.getElementById('templateName').value = name;
            document.getElementById('templateContent').value = content;
        }, 300);
    }

    function openTemplateModal(id = null, name = '', contentB64 = '', categoryId = '') {
        const modal = document.getElementById('templateModal');
        const modalContent = document.getElementById('templateModalContent');
        const form = document.getElementById('templateForm');
        const title = document.getElementById('modalTitle');
        const nameInput = document.getElementById('templateName');
        const categoryInput = document.getElementById('businessCategoryId');
        const contentInput = document.getElementById('templateContent');
        const methodField = document.getElementById('methodField');

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

        // For mobile slide up, for desktop scale up
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
