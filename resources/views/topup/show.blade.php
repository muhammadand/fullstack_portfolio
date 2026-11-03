@extends('layouts.app')

@section('meta_tags')
@php $gameName = $brand['name']; @endphp
<title>Top Up {{ $gameName }} Murah, Cepat &amp; Aman | Scalify Intelligence</title>
<meta name="description" content="Top up {{ $gameName }} murah dan proses otomatis 24 jam. Masukkan ID game, pilih nominal, bayar via QRIS." />
<meta name="robots" content="index, follow" />
<link rel="canonical" href="{{ url()->current() }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="Scalify Intelligence" />
<meta property="og:locale" content="id_ID" />
<meta property="og:title" content="Top Up {{ $gameName }} Murah, Cepat &amp; Aman" />
<meta property="og:description" content="Top up {{ $gameName }} otomatis 24 jam. Cukup masukkan ID dan bayar via QRIS." />
<meta property="og:image" content="{{ $brand['image'] ? asset('storage/' . $brand['image']) : asset('og-image.png') }}" />
<meta name="twitter:card" content="summary_large_image" />
@endsection

@section('content')
@php
$fields = $form['fields'];
$state = [
    'fields' => $fields,
    'products' => collect($products)->keyBy('id')->all(),
];
@endphp

<div x-data="topupForm(@js($state))" class="bg-brand-dark min-h-screen pb-32 lg:pb-16">

    {{-- Breadcrumb --}}
    <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-3 text-xs text-white/50 flex items-center gap-1.5" aria-label="Breadcrumb">
        <a href="{{ route('topup.index') }}" class="hover:text-white transition-colors">Top Up Game</a>
        <i class="fa-solid fa-chevron-right text-[8px]"></i>
        <span class="text-white/80 truncate">{{ $gameName }}</span>
    </nav>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 lg:grid lg:grid-cols-[320px_1fr] lg:gap-8 lg:items-start">

        {{-- Info game --}}
        <header class="lg:sticky lg:top-24 flex items-center gap-4 lg:flex-col lg:items-stretch lg:gap-0 p-4 lg:p-0 rounded-2xl lg:rounded-none bg-white/[0.04] lg:bg-transparent border border-white/10 lg:border-0 mb-4 lg:mb-0">
            <div class="w-20 lg:w-full shrink-0 aspect-[3/4] rounded-xl lg:rounded-2xl overflow-hidden bg-gradient-to-br from-blue-600/30 to-indigo-600/30 border border-white/10 relative">
                @if($brand['image'])
                <img src="{{ asset('storage/' . $brand['image']) }}" alt="Top up {{ $gameName }}" width="320" height="427" fetchpriority="high" class="absolute inset-0 w-full h-full object-cover">
                @else
                <span class="absolute inset-0 flex items-center justify-center font-sans font-black text-4xl text-white/70 select-none">{{ mb_strtoupper(mb_substr($gameName, 0, 1)) }}</span>
                @endif
            </div>
            <div class="min-w-0 lg:mt-4">
                <h1 class="font-sans font-extrabold text-lg lg:text-2xl text-white leading-tight tracking-tight">Top Up {{ $gameName }}</h1>
                <div class="flex flex-wrap gap-1.5 mt-2.5">
                    @foreach([['fa-bolt', 'text-amber-400', 'Proses instan'], ['fa-qrcode', 'text-cyan-400', 'QRIS'], ['fa-shield-halved', 'text-emerald-400', 'Aman']] as [$ic, $col, $lbl])
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-white/5 border border-white/10 text-[10px] font-semibold text-white/70">
                        <i class="fa-solid {{ $ic }} {{ $col }}"></i>{{ $lbl }}
                    </span>
                    @endforeach
                </div>
            </div>
        </header>

        <form @submit.prevent="submit" class="space-y-4" novalidate>

            {{-- 1. Data akun --}}
            @if(count($fields) > 0)
            <section class="p-4 sm:p-5 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md">
                <h2 class="flex items-center gap-2.5 font-sans font-bold text-sm sm:text-base text-white mb-3">
                    <span class="w-6 h-6 rounded-lg bg-btn-gradient flex items-center justify-center text-[11px] font-black">1</span>
                    Masukkan Data Akun
                </h2>
                <div class="grid gap-3 {{ count($fields) > 1 ? 'grid-cols-[1fr_7rem] sm:grid-cols-2' : 'grid-cols-1' }}">
                    @foreach($fields as $f)
                    <label class="block">
                        <span class="block text-xs font-semibold text-white/70 mb-1.5">{{ $f['label'] }}</span>
                        <input type="text" name="{{ $f['key'] }}" x-model.trim="values['{{ $f['key'] }}']" @blur="touched['{{ $f['key'] }}'] = true"
                            inputmode="{{ $f['inputmode'] }}" placeholder="{{ $f['placeholder'] }}" autocomplete="off" enterkeyhint="next"
                            :class="errors['{{ $f['key'] }}'] ? 'border-red-400/70' : 'border-white/15 focus:border-brand-accent/60'"
                            class="w-full h-12 rounded-xl bg-white/5 border focus:bg-white/10 focus:outline-none text-white placeholder:text-white/30 text-base px-4 transition-colors">
                        <span x-show="errors['{{ $f['key'] }}']" x-text="errors['{{ $f['key'] }}']" style="display:none" class="block text-[11px] text-red-300 mt-1"></span>
                    </label>
                    @endforeach
                </div>
                @if($form['hint'])
                <p class="flex gap-2 text-[11px] text-white/50 leading-relaxed mt-3">
                    <i class="fa-solid fa-circle-info mt-0.5 text-brand-accent/80"></i><span>{{ $form['hint'] }}</span>
                </p>
                @endif
            </section>
            @endif

            {{-- 2. Pilih nominal --}}
            <section class="p-4 sm:p-5 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md">
                <h2 class="flex items-center gap-2.5 font-sans font-bold text-sm sm:text-base text-white mb-3">
                    <span class="w-6 h-6 rounded-lg bg-btn-gradient flex items-center justify-center text-[11px] font-black">{{ count($fields) > 0 ? 2 : 1 }}</span>
                    Pilih Nominal
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5" role="radiogroup" aria-label="Pilih nominal top up">
                    @foreach($products as $p)
                    <button type="button" role="radio" :aria-checked="selected === {{ $p['id'] }}"
                        @if($p['available']) @click="selected = {{ $p['id'] }}; errors.product = null" @else disabled @endif
                        :class="selected === {{ $p['id'] }} ? 'border-brand-accent bg-brand-blue/20 shadow-glow-sm' : 'border-white/10 bg-white/[0.04] hover:border-white/25'"
                        class="relative text-left p-3 rounded-xl border transition-all active:scale-[0.97] disabled:opacity-40 disabled:cursor-not-allowed">
                        <span class="block text-[13px] font-bold text-white leading-snug line-clamp-2 min-h-[2.4em]">{{ $p['name'] }}</span>
                        <span class="block text-xs font-semibold text-cyan-300 mt-1.5">Rp {{ number_format($p['price'], 0, ',', '.') }}</span>
                        @unless($p['available'])
                        <span class="block text-[10px] text-white/50 mt-0.5">Sedang gangguan</span>
                        @endunless
                        <i x-show="selected === {{ $p['id'] }}" style="display:none" class="fa-solid fa-circle-check absolute top-2 right-2 text-brand-accent text-sm"></i>
                    </button>
                    @endforeach
                </div>
                <p x-show="errors.product" x-text="errors.product" style="display:none" class="text-[11px] text-red-300 mt-2"></p>
            </section>

            {{-- 3. Catatan --}}
            <section class="p-4 sm:p-5 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md">
                <h2 class="flex items-center gap-2.5 font-sans font-bold text-sm sm:text-base text-white mb-3">
                    <span class="w-6 h-6 rounded-lg bg-btn-gradient flex items-center justify-center text-[11px] font-black">{{ count($fields) > 0 ? 3 : 2 }}</span>
                    Catatan <span class="text-white/40 font-medium text-xs">(opsional)</span>
                </h2>
                <textarea x-model="note" rows="2" maxlength="200" placeholder="Tulis catatan untuk pesananmu"
                    class="w-full rounded-xl bg-white/5 border border-white/15 focus:border-brand-accent/60 focus:bg-white/10 focus:outline-none text-white placeholder:text-white/30 text-base px-4 py-3 resize-none transition-colors"></textarea>
                <ul class="mt-3 space-y-1 text-[11px] text-white/45 leading-relaxed list-disc pl-4">
                    <li>Pastikan data akun sudah benar sebelum membayar.</li>
                    <li>Pesanan diproses otomatis setelah pembayaran berhasil.</li>
                    <li>Pesanan yang sudah diproses tidak dapat dibatalkan.</li>
                </ul>
            </section>

            {{-- Checkout: bar tetap di bawah (mobile), kartu biasa di desktop --}}
            <div class="fixed bottom-0 inset-x-0 z-40 lg:static lg:z-auto bg-brand-dark/95 backdrop-blur-xl lg:bg-transparent lg:backdrop-blur-none border-t border-white/10 lg:border-0 px-4 py-3 lg:p-0 pb-[max(0.75rem,env(safe-area-inset-bottom))]">
                <div class="max-w-6xl mx-auto flex items-center gap-3 lg:p-5 lg:rounded-2xl lg:bg-white/[0.04] lg:border lg:border-white/10">
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] text-white/50 truncate" x-text="selected ? products[selected].name : 'Belum memilih nominal'"></p>
                        <p class="text-base lg:text-lg font-extrabold text-white" x-text="selected ? rupiah(products[selected].price) : 'Rp 0'"></p>
                    </div>
                    <button type="submit"
                        class="shrink-0 h-12 px-6 rounded-xl bg-btn-gradient text-white font-bold text-sm shadow-glow-sm active:scale-95 transition-transform">
                        Checkout
                    </button>
                </div>
                <p x-show="notice" x-text="notice" style="display:none" class="max-w-6xl mx-auto mt-2 text-[11px] text-cyan-300 text-center lg:text-left"></p>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('topupForm', (cfg) => ({
        fields: cfg.fields,
        products: cfg.products,
        values: Object.fromEntries(cfg.fields.map(f => [f.key, ''])),
        touched: {},
        selected: null,
        note: '',
        notice: '',
        submitted: false,

        get errors() {
            const e = {};
            this.fields.forEach(f => {
                const v = this.values[f.key];
                if ((this.touched[f.key] || this.submitted) && !new RegExp(f.pattern).test(v)) {
                    e[f.key] = v ? `${f.label} tidak valid` : `${f.label} wajib diisi`;
                }
            });
            if (this.submitted && !this.selected) e.product = 'Pilih nominal terlebih dahulu';
            return e;
        },

        rupiah(n) { return 'Rp ' + Math.round(n).toLocaleString('id-ID'); },

        submit() {
            this.submitted = true;
            this.notice = '';
            if (Object.keys(this.errors).length) {
                this.$nextTick(() => document.querySelector('.border-red-400\\/70')?.focus());
                return;
            }
            // Pembayaran belum diaktifkan: tahap ini hanya halaman dan validasi form.
            this.notice = 'Data lengkap. Pembayaran segera tersedia.';
        },
    }));
});
</script>
@endsection
