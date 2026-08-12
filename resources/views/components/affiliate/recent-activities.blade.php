@props(['withdrawals'])

<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-bold text-white">Aktivitas Terakhir</h3>
    <a href="{{ route('affiliate.history') }}" class="text-[11px] font-semibold text-blue-400">Lihat Semua</a>
</div>

<div class="glass-panel rounded-2xl p-2 mb-8">
    @forelse($withdrawals->take(3) as $w)
    <div class="flex items-center justify-between p-3 border-b border-white/5 last:border-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-blue-300">
                @if($w->status === 'Pending')
                <i class="fa-solid fa-clock"></i>
                @elseif($w->status === 'Completed')
                <i class="fa-solid fa-check text-emerald-400"></i>
                @else
                <i class="fa-solid fa-xmark text-red-400"></i>
                @endif
            </div>
            <div>
                <p class="text-sm font-medium text-white">Penarikan Dana</p>
                <p class="text-[10px] text-slate-400">{{ $w->created_at->format('d M, H:i') }} • {{ $w->status }}</p>
            </div>
        </div>
        <div class="text-sm font-bold text-white">
            -Rp {{ number_format($w->amount, 0, ',', '.') }}
        </div>
    </div>
    @empty
    <div class="p-6 text-center text-slate-400 text-sm">
        Belum ada aktivitas penarikan.
    </div>
    @endforelse
</div>
