@props(['affiliate'])

<div class="glass-card rounded-3xl p-5 mb-6 relative overflow-hidden">
    <!-- Decorative circle inside card -->
    <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/5 rounded-full"></div>

    <p class="text-sm text-blue-100/80 font-medium mb-1 relative z-10 flex items-center gap-2">
        <i class="fa-solid fa-wallet text-blue-400"></i> Saldo Komisi
    </p>
    <div class="flex justify-between items-end relative z-10 mb-4">
        <div class="text-3xl font-bold text-white tracking-tight">
            <span class="text-lg text-blue-200/70 font-medium mr-1">Rp</span>{{ number_format($affiliate->balance, 0, ',', '.') }}
        </div>
    </div>

    <div class="flex gap-3 relative z-10 mt-6">
        @if($affiliate->balance < 50000) 
            <button onclick="alert('Maaf, saldo komisi Anda minimal Rp 50.000 untuk dapat melakukan penarikan.')" class="flex-1 py-2 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl transition-colors backdrop-blur-md flex flex-col justify-center items-center gap-1">
                <i class="fa-solid fa-money-bill-transfer text-[18px]"></i>
                <span class="text-[10px]">Tarik (Min 50rb)</span>
            </button>
        @else
            <button onclick="openWithdrawModal()" class="flex-1 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 transition-colors flex flex-col justify-center items-center gap-1">
                <i class="fa-solid fa-money-bill-transfer text-[18px]"></i>
                <span class="text-[10px]">Tarik Komisi</span>
            </button>
        @endif
        <button onclick="copyLink()" class="flex-1 py-2 glass-panel text-white font-semibold rounded-xl transition-colors flex flex-col justify-center items-center gap-1">
            <i class="fa-solid fa-link text-blue-300 text-[18px]"></i>
            <span class="text-[10px]">Salin Link</span>
        </button>
    </div>
</div>
