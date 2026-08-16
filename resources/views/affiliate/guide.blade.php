@extends('layouts.app')

@section('hide_navbar_mobile', true)
@section('hide_footer_mobile', true)
@section('hide_chatbot', true)

@push('meta')
<x-affiliate.pwa-meta />
@endpush

@push('styles')
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
<style>
    .glass-panel {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    body {
        background-color: #0B1120;
    }

</style>
@endpush

@section('content')

<x-affiliate.page-loader />

<!-- Background Decoration -->
<div class="fixed top-0 left-0 w-full h-64 bg-blue-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>
<div class="fixed bottom-0 right-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[100px] translate-y-1/2 translate-x-1/3 pointer-events-none z-0"></div>

<div class="relative z-10 w-full max-w-md mx-auto min-h-screen px-4 pt-6 pb-24 text-white font-sans">

    <!-- Top Bar -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="text-xl font-bold">Panduan Partner</h1>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Intro -->
        <div class="glass-panel p-6 rounded-3xl relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
            <h2 class="text-lg font-bold text-white mb-2 relative z-10">Mengenal Scalify Intelligence</h2>
            <p class="text-sm text-slate-300 leading-relaxed relative z-10">
                Kami adalah <b>Creative Tech Agency</b> yang fokus membantu UMKM dan Perusahaan di Indonesia bertransformasi ke era digital. Layanan utama kami meliputi pembuatan Website Premium, Landing Page, dan Automasi Bisnis (termasuk Chatbot AI).
            </p>
        </div>

        <!-- Tugas Partner -->
        <div class="glass-panel p-6 rounded-3xl border border-orange-500/20 bg-orange-500/5 relative overflow-hidden">
            <div class="absolute -left-6 -bottom-6 w-32 h-32 bg-orange-500/10 rounded-full blur-2xl"></div>
            <div class="flex items-center gap-3 mb-4 relative z-10">
                <div class="w-10 h-10 rounded-xl bg-orange-500/20 text-orange-400 flex items-center justify-center font-bold shrink-0">
                    <i class="fa-solid fa-bullhorn text-lg"></i>
                </div>
                <h2 class="text-lg font-bold text-white">Tugas Utama Anda</h2>
            </div>
            <p class="text-sm text-slate-300 leading-relaxed relative z-10 mb-3">
                Sebagai Partner (Sobat Scalify), tugas Anda sangat sederhana: <b>Menawarkan jasa pembuatan website/landing page kami ke para pemilik bisnis (UMKM, Cafe, Salon, dll)</b>.
            </p>
            <p class="text-sm text-slate-300 leading-relaxed relative z-10">
                Setiap kali ada klien yang <i>Deal</i> melalui Anda, Anda akan mendapatkan komisi sebesar <b>10% atau mulai dari Rp 200.000 hingga Rp 500.000 per project!</b>
            </p>
        </div>

        <!-- Cara Kerja -->
        <div>
            <h2 class="text-xl font-bold text-white mb-4 px-2">Cara Mendapatkan Klien</h2>

            <div class="space-y-4">
                <!-- Step 1 -->
                <div class="glass-panel p-5 rounded-2xl relative overflow-hidden">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold shrink-0 text-sm mt-1">1</div>
                        <div>
                            <h3 class="font-bold text-white mb-2">Sebarkan Link Afiliasi (Cara Pasif)</h3>
                            <p class="text-sm text-slate-400 leading-relaxed mb-3">
                                Cukup copy <b>Link Referral</b> Anda dari Dashboard dan sebarkan di Bio Instagram, TikTok, WhatsApp Story, atau grup komunitas bisnis.
                            </p>
                            <div class="bg-slate-900/50 p-3 rounded-xl border border-white/5">
                                <p class="text-xs text-slate-300 font-mono"><i class="fa-solid fa-link text-blue-400 mr-2"></i>{{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="glass-panel p-5 rounded-2xl relative overflow-hidden border border-emerald-500/20 bg-emerald-500/5">
                    <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-40 h-40 bg-emerald-500/10 rounded-full blur-2xl"></div>
                    <div class="flex items-start gap-4 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold shrink-0 text-sm mt-1">2</div>
                        <div>
                            <h3 class="font-bold text-white mb-2 flex items-center gap-2">
                                Gunakan Katalog Proposal
                                <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Rekomendasi</span>
                            </h3>
                            <p class="text-sm text-slate-300 leading-relaxed mb-3">
                                Ini adalah fitur <b>"Senjata Rahasia"</b> Anda. Alih-alih hanya menawarkan dengan kata-kata, Anda bisa langsung menunjukkan contoh website yang sudah jadi kepada target klien.
                            </p>

                            <ul class="text-sm text-slate-400 space-y-2 mb-4">
                                <li class="flex items-start gap-2">
                                    <i class="fa-solid fa-check text-emerald-400 mt-1"></i>
                                    <span>Buka menu <b>Katalog Proposal</b> di Dashboard.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa-solid fa-check text-emerald-400 mt-1"></i>
                                    <span>Pilih kategori bisnis target Anda (misal: Cafe & Resto).</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa-solid fa-check text-emerald-400 mt-1"></i>
                                    <span>Masukkan Nama Bisnis dan Nomor WhatsApp target.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa-solid fa-check text-emerald-400 mt-1"></i>
                                    <span>Sistem akan menggenerate Link Website khusus lengkap dengan nama bisnis mereka!</span>
                                </li>
                            </ul>

                            <a href="{{ route('affiliate.proposals') }}" class="inline-flex items-center justify-center w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-bold rounded-xl transition-colors gap-2">
                                Coba Katalog Proposal <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="glass-panel p-5 rounded-2xl relative overflow-hidden">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-purple-500 text-white flex items-center justify-center font-bold shrink-0 text-sm mt-1">3</div>
                        <div>
                            <h3 class="font-bold text-white mb-2">Buat Template Chat</h3>
                            <p class="text-sm text-slate-400 leading-relaxed mb-3">
                                Agar Anda tidak perlu mengetik ulang saat follow up klien di WhatsApp, buatlah <b>Template Chat</b>. Anda bisa menggunakan *placeholder* seperti <code>{nama_bisnis}</code> yang akan terisi otomatis saat Anda mengirim proposal.
                            </p>
                            <a href="{{ route('affiliate.chat_templates.index') }}" class="inline-flex items-center text-sm font-semibold text-purple-400 hover:text-purple-300">
                                Kelola Template Chat <i class="fa-solid fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-panel p-6 rounded-3xl text-center">
            <h3 class="text-white font-bold mb-2">Siap Mulai Menghasilkan?</h3>
            <p class="text-sm text-slate-400 mb-6">Mulai dari hal kecil, sebarkan link Anda ke kontak terdekat.</p>
            <a href="{{ route('affiliate.dashboard') }}" class="inline-flex items-center justify-center w-full py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition-all shadow-[0_0_15px_rgba(37,99,235,0.3)]">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

</div>

<!-- Bottom Navigation -->
<x-affiliate.bottom-nav />

<x-affiliate.scripts />
@endsection
