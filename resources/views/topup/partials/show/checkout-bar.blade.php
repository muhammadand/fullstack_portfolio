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
</div>
