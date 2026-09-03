@extends('layouts.app')

@section('hide_chatbot', true)

@section('content')
<div class="bg-slate-50 min-h-screen pb-20">
    <!-- Premium Header Background -->
    <div class="relative bg-brand-dark pt-32 pb-40 overflow-hidden" style="background-color: #0A0E2A; background-image: radial-gradient(circle at top right, rgba(59,130,246,0.15), transparent 50%);">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 text-blue-300 text-xs font-bold mb-4 tracking-wider uppercase border border-white/10 backdrop-blur-sm">
                        <i class="fa-solid fa-clock-rotate-left mr-2"></i> Riwayat Transaksi
                    </div>
                    <h1 class="text-3xl md:text-5xl font-bold text-white font-display tracking-tight mb-2">Riwayat Dana</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container (Overlapping Header) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 -mt-24">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Komisi Masuk -->
            <div class="bg-white rounded-3xl shadow-xl shadow-blue-900/5 border border-slate-100 p-8">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-arrow-down"></i>
                    </div>
                    Riwayat Komisi Masuk
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[500px]">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider rounded-tl-xl">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right rounded-tr-xl">Nominal (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($commissions as $comm)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $comm->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ $comm->description ?? 'Komisi Project' }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-emerald-600 text-right">+{{ number_format($comm->amount, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-500 bg-slate-50/50">
                                    Belum ada riwayat komisi masuk.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($commissions->hasPages())
                <div class="mt-6 border-t border-slate-100 pt-4">
                    {{ $commissions->links() }}
                </div>
                @endif
            </div>

            <!-- Penarikan -->
            <div class="bg-white rounded-3xl shadow-xl shadow-blue-900/5 border border-slate-100 p-8">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-arrow-up"></i>
                    </div>
                    Riwayat Penarikan
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[500px]">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider rounded-tl-xl">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nominal (Rp)</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right rounded-tr-xl">Bukti</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($withdrawals as $w)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $w->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-slate-800">{{ number_format($w->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($w->status === 'Pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fa-solid fa-clock mr-1"></i> Menunggu Proses
                                    </span>
                                    @elseif($w->status === 'Completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-check mr-1"></i> Selesai
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fa-solid fa-xmark mr-1"></i> Ditolak
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($w->proof_of_payment)
                                    <a href="{{ asset('storage/' . $w->proof_of_payment) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-xs font-medium transition-colors">
                                        <i class="fa-solid fa-file-invoice"></i> Lihat
                                    </a>
                                    @else
                                    <span class="text-xs text-slate-400 italic">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500 bg-slate-50/50">
                                    Belum ada riwayat penarikan komisi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($withdrawals->hasPages())
                <div class="mt-6 border-t border-slate-100 pt-4">
                    {{ $withdrawals->links() }}
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
