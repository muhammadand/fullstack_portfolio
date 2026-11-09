<!DOCTYPE html>
<html lang="id">
<head>
    @include('affiliate.ppob.partials.head', ['title' => $game['brand']['name']])
</head>
@php
    $fields = $game['form']['fields'];
    $firstAvailable = collect($game['products'])->firstWhere('available', true);
@endphp
<body class="pb-40 overflow-x-hidden min-h-screen relative"
      x-data="{ selected: @js(old('product_id')), products: @js(collect($game['products'])->keyBy('id')), balance: {{ $walletBalance }}, submitting: false,
                get item() { return this.products[this.selected] || null },
                get insufficient() { return this.item && this.balance < this.item.price },
                rupiah(v) { return 'Rp ' + Math.round(v).toLocaleString('id-ID') } }">
    <x-affiliate.page-loader />
    <div class="fixed top-0 left-0 w-full h-64 bg-indigo-600/10 rounded-full blur-[110px] -translate-y-1/2 pointer-events-none z-0"></div>

    <form method="POST" action="{{ route('affiliate.ppob.game.order', $game['brand']['slug']) }}" @submit="submitting = true"
          class="relative z-10 w-full max-w-md mx-auto px-4 pt-5">
        @csrf
        <input type="hidden" name="idempotency_key" value="{{ $idempotencyKey }}">
        <input type="hidden" name="product_id" :value="selected">

        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('affiliate.ppob.games') }}" class="w-10 h-10 rounded-xl glass-panel flex items-center justify-center text-slate-300 active:scale-95" aria-label="Kembali">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            @if($game['brand']['image'])
            <img src="{{ asset('storage/' . $game['brand']['image']) }}" alt="" class="w-10 h-10 rounded-xl object-cover bg-slate-800">
            @endif
            <div class="min-w-0">
                <h1 class="text-base font-bold text-white leading-tight truncate">{{ $game['brand']['name'] }}</h1>
                <p class="text-xs text-slate-400">Harga {{ $game['level']['name'] }}</p>
            </div>
        </div>

        <div class="mb-4">@include('affiliate.ppob.partials.wallet')</div>

        @if(session('error') || $errors->any())
        <div class="mb-4 flex items-start gap-2 text-xs text-red-200 bg-red-500/10 border border-red-500/30 rounded-xl px-3 py-2.5" role="alert">
            <i class="fa-solid fa-circle-exclamation text-red-400 mt-0.5"></i><span>{{ session('error') ?? $errors->first() }}</span>
        </div>
        @endif

        {{-- 1. Akun game --}}
        @if($fields)
        <section class="glass-panel rounded-2xl p-4 mb-4">
            <h2 class="text-xs font-bold text-white mb-3"><span class="text-indigo-300">1.</span> Data akun pembeli</h2>
            <div class="grid {{ count($fields) > 1 ? 'grid-cols-2' : 'grid-cols-1' }} gap-2.5">
                @foreach($fields as $f)
                <div>
                    <label for="acc_{{ $f['key'] }}" class="block text-[11px] font-semibold text-slate-400 mb-1">{{ $f['label'] }}</label>
                    <input id="acc_{{ $f['key'] }}" name="account[{{ $f['key'] }}]" value="{{ old('account.' . $f['key']) }}" required
                           inputmode="{{ $f['inputmode'] }}" placeholder="{{ $f['placeholder'] }}" autocomplete="off"
                           class="w-full rounded-xl bg-white/5 border border-white/10 px-3 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-indigo-400/60">
                </div>
                @endforeach
            </div>
            @if($game['form']['hint'])
            <p class="mt-2 text-[11px] text-slate-400"><i class="fa-solid fa-circle-info mr-1"></i>{{ $game['form']['hint'] }}</p>
            @endif
        </section>
        @endif

        {{-- 2. Nominal --}}
        <section>
            <h2 class="text-xs font-bold text-white mb-2"><span class="text-indigo-300">{{ $fields ? '2.' : '1.' }}</span> Pilih nominal</h2>
            <div class="grid grid-cols-2 gap-2.5">
                @foreach($game['products'] as $p)
                    @if($p['available'])
                    <button type="button" @click="selected = {{ $p['id'] }}" :class="selected == {{ $p['id'] }} ? 'is-selected' : ''"
                            class="glass-panel rounded-2xl p-3 text-left active:scale-[0.97] transition" data-product-id="{{ $p['id'] }}">
                        <span class="block text-sm font-bold text-white leading-tight mb-2 break-words">{{ $p['name'] }}</span>
                        <span class="block text-[10px] text-emerald-300/80">Harga Partner</span>
                        <span class="block text-sm font-bold text-emerald-400">Rp {{ number_format($p['price'], 0, ',', '.') }}</span>
                        @if($p['profit'] > 0)
                        <span class="inline-block mt-1.5 text-[10px] text-amber-300 font-semibold bg-amber-500/10 rounded-full px-1.5 py-0.5">Untung Rp {{ number_format($p['profit'], 0, ',', '.') }}</span>
                        @endif
                    </button>
                    @else
                    <div class="glass-panel rounded-2xl p-3 opacity-50" aria-disabled="true">
                        <span class="block text-sm font-bold text-white leading-tight mb-2 break-words">{{ $p['name'] }}</span>
                        <span class="block text-[10px] text-slate-400">Sementara tidak tersedia</span>
                    </div>
                    @endif
                @endforeach
            </div>
        </section>

        {{-- Bar bayar (menempel di atas bottom nav) --}}
        <div class="fixed inset-x-0 bottom-20 z-30 px-4" x-show="item" x-cloak>
            <div class="max-w-md mx-auto glass-panel rounded-2xl p-3 bg-[#0B1120]/95 flex items-center gap-3">
                <div class="min-w-0 flex-1">
                    <p class="text-[11px] text-slate-400 truncate" x-text="item ? item.name : ''"></p>
                    <p class="text-sm font-bold" :class="insufficient ? 'text-red-400' : 'text-emerald-400'" x-text="item ? rupiah(item.price) : ''"></p>
                </div>
                <template x-if="insufficient">
                    <a href="{{ route('affiliate.dashboard', ['isi_saldo' => 1]) }}" class="shrink-0 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold">Isi Saldo</a>
                </template>
                <template x-if="!insufficient">
                    <button type="submit" :disabled="submitting" class="shrink-0 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold disabled:opacity-50">
                        <span x-show="!submitting"><i class="fa-solid fa-lock mr-1"></i>Bayar Saldo</span>
                        <span x-show="submitting" x-cloak><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memproses</span>
                    </button>
                </template>
            </div>
        </div>
    </form>

    <x-affiliate.bottom-nav />
</body>
</html>
