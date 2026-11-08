@extends('layouts.app')

@section('meta_tags')
<title>Tarik Saldo | Scalify Intelligence</title>
<meta name="robots" content="noindex, nofollow" />
@endsection

@section('content')
@php
    $min = \App\Models\CustomerWithdrawal::MIN_AMOUNT;
    $feePercent = \App\Models\CustomerWithdrawal::FEE_PERCENT;
    $balance = (float) $customer->balance;
@endphp
<div class="max-w-md mx-auto px-4 pt-6 pb-16"
     x-data="{ amount: {{ (int) old('amount', $balance) }}, balance: {{ $balance }}, ewallet: @js(old('ewallet', '')), submitting: false,
               get fee() { return Math.round((this.amount || 0) * {{ $feePercent }} / 100) },
               get net() { return Math.max(0, (this.amount || 0) - this.fee) },
               rp(v) { return 'Rp ' + Math.round(v).toLocaleString('id-ID') } }">

    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('customer.account') }}" class="w-10 h-10 rounded-xl border border-white/10 flex items-center justify-center text-white/70 hover:text-white" aria-label="Kembali">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="font-display font-bold text-lg text-white">Tarik Saldo</h1>
            <p class="text-xs text-white/45">Saldo tersedia: <span class="text-white font-semibold">Rp {{ number_format($balance, 0, ',', '.') }}</span></p>
        </div>
    </div>

    @if(session('error'))
    <div class="mb-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200" role="alert">{{ session('error') }}</div>
    @endif
    @if($errors->any())
    <div class="mb-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200" role="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('customer.withdraw.store') }}" class="space-y-5" @submit="submitting = true">
        @csrf

        {{-- Nominal --}}
        <div>
            <label for="amount" class="block text-xs font-semibold text-white/70 mb-1.5">Nominal penarikan</label>
            <div class="flex items-center gap-2 rounded-xl bg-white/[0.04] border border-white/10 px-4 focus-within:border-blue-400/60">
                <span class="text-white/50 text-sm">Rp</span>
                <input id="amount" name="amount" type="number" inputmode="numeric" min="{{ $min }}" max="{{ (int) $balance }}" required
                       x-model.number="amount" class="w-full bg-transparent py-3 text-lg font-bold text-white outline-none">
            </div>
            <button type="button" @click="amount = {{ (int) $balance }}" class="mt-2 text-xs font-semibold text-brand-accent">Tarik semua saldo</button>
        </div>

        {{-- E-wallet --}}
        <fieldset>
            <legend class="block text-xs font-semibold text-white/70 mb-1.5">E-wallet tujuan</legend>
            <div class="grid grid-cols-3 gap-2">
                @foreach(\App\Models\CustomerWithdrawal::EWALLETS as $ew)
                <label class="cursor-pointer">
                    <input type="radio" name="ewallet" value="{{ $ew }}" x-model="ewallet" class="sr-only peer" required>
                    <span class="block text-center py-2.5 rounded-xl border border-white/10 bg-white/[0.04] text-xs font-semibold text-white/70
                                 peer-checked:border-blue-400 peer-checked:bg-blue-500/15 peer-checked:text-white transition">{{ $ew }}</span>
                </label>
                @endforeach
            </div>
        </fieldset>

        <div>
            <label for="account_no" class="block text-xs font-semibold text-white/70 mb-1.5">Nomor <span x-text="ewallet || 'e-wallet'"></span></label>
            <input id="account_no" name="account_no" type="tel" inputmode="numeric" autocomplete="tel" required value="{{ old('account_no') }}" placeholder="0812xxxxxxxx"
                   class="w-full rounded-xl bg-white/[0.04] border border-white/10 px-4 py-3 text-sm text-white placeholder-white/30 outline-none focus:border-blue-400/60">
        </div>

        <div>
            <label for="account_name" class="block text-xs font-semibold text-white/70 mb-1.5">Nama pemilik akun</label>
            <input id="account_name" name="account_name" type="text" maxlength="100" required value="{{ old('account_name', $customer->name) }}"
                   class="w-full rounded-xl bg-white/[0.04] border border-white/10 px-4 py-3 text-sm text-white outline-none focus:border-blue-400/60">
        </div>

        {{-- Rincian --}}
        <div class="rounded-xl bg-white/[0.04] border border-white/10 p-4 space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-white/55">Nominal ditarik</span><span class="text-white" x-text="rp(amount || 0)"></span></div>
            <div class="flex justify-between"><span class="text-white/55">Biaya admin {{ $feePercent }}%</span><span class="text-white" x-text="'− ' + rp(fee)"></span></div>
            <div class="flex justify-between pt-2 border-t border-white/10"><span class="text-white font-semibold">Diterima</span><span class="text-emerald-300 font-bold" x-text="rp(net)"></span></div>
        </div>

        <p x-show="amount > balance" x-cloak class="text-xs text-red-300">Nominal melebihi saldo.</p>
        <p x-show="amount && amount < {{ $min }}" x-cloak class="text-xs text-red-300">Minimal penarikan Rp {{ number_format($min, 0, ',', '.') }}.</p>

        <button type="submit" :disabled="submitting || !amount || amount < {{ $min }} || amount > balance || !ewallet"
                class="w-full py-3.5 rounded-xl bg-white text-slate-900 text-sm font-bold active:scale-[0.98] disabled:opacity-40 disabled:cursor-not-allowed">
            <span x-show="!submitting">Ajukan Penarikan</span>
            <span x-show="submitting" x-cloak><i class="fa-solid fa-spinner fa-spin mr-1"></i>Memproses...</span>
        </button>
        <p class="text-[11px] text-white/40 text-center">Penarikan diproses manual oleh admin. Saldo ditahan selama diproses dan kembali utuh bila ditolak.</p>
    </form>
</div>
@endsection
