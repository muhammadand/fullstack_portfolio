@props(['affiliate'])

@php
$today = now()->format('Y-m-d');
$hasClaimedToday = $affiliate->last_claim_date === $today;

$streak = $affiliate->current_streak;

$yesterday = now()->subDay()->format('Y-m-d');
if ($affiliate->last_claim_date !== $today && $affiliate->last_claim_date !== $yesterday) {
$streak = 0;
}

$fireColor = 'text-slate-600';
$fireBg = 'bg-slate-800';
$fireGlow = '';
$fireLevel = 0;

if ($streak > 0) {
if ($streak < 30) { $fireColor='text-orange-500' ; $fireBg='bg-orange-500/20' ; $fireGlow='drop-shadow-[0_0_8px_rgba(249,115,22,0.8)] animate-pulse' ; $fireLevel=1; } elseif ($streak < 60) { $fireColor='text-cyan-400' ; $fireBg='bg-cyan-500/20' ; $fireGlow='drop-shadow-[0_0_12px_rgba(34,211,238,0.9)] animate-pulse' ; $fireLevel=2; } else { $fireColor='text-yellow-400' ; $fireBg='bg-yellow-500/20' ; $fireGlow='drop-shadow-[0_0_15px_rgba(250,204,21,1)] animate-pulse' ; $fireLevel=3; } } @endphp <div class="glass-panel rounded-3xl p-5 mb-6 relative overflow-hidden flex items-center justify-between">
    <!-- Dekorasi -->
    <div class="absolute -right-6 -top-6 w-24 h-24 {{ $fireBg }} rounded-full blur-2xl"></div>

    <div class="flex items-center gap-4 relative z-10">
        <!-- Ikon Api -->
        <div class="w-12 h-12 rounded-full {{ $fireBg }} flex items-center justify-center shrink-0">
            <i class="fa-solid fa-fire text-2xl {{ $fireColor }} {{ $fireGlow }}"></i>
            @if($fireLevel == 2)
            <i class="fa-solid fa-bolt absolute text-[10px] text-white opacity-80 bottom-2 right-2"></i>
            @elseif($fireLevel == 3)
            <i class="fa-solid fa-crown absolute text-[12px] text-white opacity-90 -top-2"></i>
            @endif
        </div>

        <div>
            <h4 class="text-sm font-bold text-white mb-0.5">Api Streak</h4>
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-300">{{ $streak }} Hari Beruntun</span>
                @if($streak > 0 && $streak % 7 == 0 && $hasClaimedToday)
                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-yellow-500/20 text-yellow-400">+ Bonus</span>
                @endif
            </div>
            <p class="text-[10px] text-slate-400 mt-1"><i class="fa-solid fa-coins text-yellow-500 mr-1"></i> {{ number_format($affiliate->points, 0, ',', '.') }} Poin Terkumpul</p>
        </div>
    </div>

    <div class="relative z-10">
        @if($hasClaimedToday)
        <a href="{{ route('affiliate.streak') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 hover:border-slate-600 text-slate-300 text-xs font-bold rounded-xl flex items-center gap-1.5 transition-colors">
            <i class="fa-solid fa-fire text-orange-500"></i> Lihat Streak
        </a>
        @else
        <form action="{{ route('affiliate.claim_points') }}" method="POST" id="claim-points-form">
            @csrf
            <button type="button" onclick="handleClaimClick()" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 shadow-lg shadow-orange-500/30 text-white text-xs font-bold rounded-xl flex items-center gap-1.5 transition-transform active:scale-95">
                <i class="fa-solid fa-fire"></i> Klaim
            </button>
        </form>
        @endif
    </div>
    </div>

    <script>
        async function handleClaimClick() {
            const form = document.getElementById('claim-points-form');
            const btn = form.querySelector('button');

            // Ganti text tombol sementara saat loading
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Loading...';
            btn.disabled = true;

            try {
                // Coba pancing popup notifikasi browser
                if (typeof subscribeUserToPush === 'function') {
                    // Hanya minta jika browser support dan belum pernah ditanya
                    if (typeof Notification !== 'undefined' && Notification.permission === 'default') {
                        await subscribeUserToPush();
                    }
                }
            } catch (e) {
                console.error('Push error:', e);
            } finally {
                // Lanjutkan submit form klaim poin (jangan sampai poin gagal diklaim)
                form.submit();
            }
        }

    </script>
