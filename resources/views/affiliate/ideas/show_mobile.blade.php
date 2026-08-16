@extends('layouts.app')

@section('hide_navbar_mobile', true)
@section('hide_footer_mobile', true)
@section('hide_chatbot', true)

@push('meta')
<x-affiliate.pwa-meta />
@endpush

@push('styles')
<style>
    body {
        background-color: #0B1120;
    }

    .glass-panel {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

</style>
@endpush

@section('content')
<!-- Hero Image -->
<div class="relative w-full h-64 sm:h-80">
    <img src="{{ $idea['image'] }}" alt="{{ $idea['title'] }}" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-[#0B1120]"></div>

    <!-- Top Bar -->
    <div class="absolute top-0 left-0 w-full p-4 flex items-center justify-between z-10 pt-6">
        <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-white hover:bg-white/20 transition-colors backdrop-blur-md">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>
</div>

<div class="relative z-10 -mt-16 px-4 pb-32 max-w-md mx-auto">
    <!-- Title Card -->
    <div class="glass-panel rounded-3xl p-6 mb-6 relative overflow-hidden shadow-2xl shadow-blue-900/20">
        <div class="absolute -top-12 -right-12 w-24 h-24 bg-blue-500/20 rounded-full blur-xl"></div>
        <h1 class="text-2xl font-bold text-white mb-2">{{ $idea['title'] }}</h1>
        <p class="text-sm text-slate-300 font-medium">{{ $idea['short_desc'] }}</p>
    </div>

    <!-- Reason Section -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                <i class="fa-solid fa-circle-question"></i>
            </div>
            <h2 class="text-lg font-bold text-white">Kenapa Butuh Website?</h2>
        </div>
        <div class="bg-blue-900/10 border border-blue-500/20 rounded-2xl p-5">
            <p class="text-sm text-slate-300 leading-relaxed">
                {{ $idea['reason'] }}
            </p>
        </div>
    </div>

    <!-- Features to Offer Section -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <h2 class="text-lg font-bold text-white">Fitur yang Bisa Ditawarkan</h2>
        </div>
        <div class="space-y-3">
            @foreach($idea['features'] as $feature)
            <div class="glass-panel rounded-xl p-4 flex items-center gap-3">
                <i class="fa-solid fa-check text-emerald-400"></i>
                <span class="text-sm text-slate-200 font-medium">{{ $feature }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Sticky Bottom Action -->
<div class="fixed bottom-0 left-0 w-full p-4 bg-gradient-to-t from-[#0B1120] via-[#0B1120] to-transparent z-50">
    <div class="max-w-md mx-auto">
        <button onclick="openModalProposal()" class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl transition-all shadow-[0_0_20px_rgba(37,99,235,0.4)] flex items-center justify-center gap-2 text-sm">
            <i class="fa-solid fa-rocket"></i> Buat Proposal untuk Klien Ini
        </button>
    </div>
</div>

<!-- Modal Buat Proposal (Copied from proposals_mobile.blade.php for seamless UX) -->
<div id="modal-buat-proposal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeModalProposal()"></div>
    <div class="bg-slate-900 border border-white/10 rounded-2xl w-full max-w-sm m-4 relative z-10 transform scale-95 transition-transform duration-300 p-5 shadow-2xl">
        <button onclick="closeModalProposal()" class="absolute top-4 right-4 text-slate-400 hover:text-white transition-colors w-8 h-8 flex items-center justify-center rounded-full bg-white/5">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h2 class="text-lg font-bold text-white mb-1"><i class="fa-solid fa-wand-magic-sparkles text-blue-400 mr-2"></i>Buat Proposal Baru</h2>
        <p class="text-xs text-slate-400 mb-5 leading-relaxed">Buat website landing page dan proposal khusus untuk <span class="text-blue-400 font-semibold">{{ $idea['title'] }}</span> secara instan.</p>

        <form action="{{ route('affiliate.proposals.generate') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Kategori Bisnis</label>
                    <select id="select-category" name="business_category_id" required class="w-full bg-black/30 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500 transition-colors">
                        <option value="" disabled selected class="text-slate-800">Pilih Kategori...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" class="text-slate-800">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Nama Bisnis / Brand</label>
                    <input type="text" name="brand_name" required placeholder="Contoh: Kopi Kenangan" class="w-full bg-black/30 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Nomor WhatsApp</label>
                    <input type="text" name="wa_number" required placeholder="Contoh: 6281234567890" class="w-full bg-black/30 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500 transition-colors">
                    <p class="text-[10px] text-slate-400 mt-1"><i class="fa-solid fa-circle-info mr-1"></i>Gunakan format 628... (tanpa tanda +)</p>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-medium py-2.5 rounded-xl transition-colors shadow-lg shadow-blue-500/30 text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-rocket"></i> Buat Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalProposal() {
        const modal = document.getElementById('modal-buat-proposal');
        const modalContent = modal.querySelector('.transform');
        modal.classList.remove('hidden');
        // Trigger reflow
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
    }

    function closeModalProposal() {
        const modal = document.getElementById('modal-buat-proposal');
        const modalContent = modal.querySelector('.transform');
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Expose functions globally for Livewire SPA compatibility
    window.openModalProposal = openModalProposal;
    window.closeModalProposal = closeModalProposal;

</script>
@endsection
