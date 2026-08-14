@extends('layouts.admin.app')

@section('content')
<div class="px-6 py-8">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Detail Partner: {{ $affiliate->name }}</h1>
            <p class="text-slate-500 text-sm mt-1">
                <a href="{{ route('admin.affiliates.index') }}" class="text-blue-600 hover:underline">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Partner
                </a>
            </p>
        </div>
    </div>

    <!-- Affiliate Info Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 mb-8 flex flex-col md:flex-row gap-6 justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-slate-800">{{ $affiliate->name }}</h2>
            <p class="text-slate-500">{{ $affiliate->email }}</p>
            <div class="mt-2 text-sm">
                <span class="text-slate-500">Kode Referral:</span>
                <span class="font-bold text-blue-600">{{ $affiliate->affiliate_code }}</span>
            </div>
            <div class="mt-1 text-sm">
                <span class="text-slate-500">Info Bank:</span>
                <span class="font-medium text-slate-700">{{ $affiliate->bank_info }}</span>
            </div>
            <div class="mt-2">
                @if($affiliate->status === 'pending')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                @elseif($affiliate->status === 'approved')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                @endif
            </div>
        </div>
        <div class="flex flex-col items-center justify-center p-4 bg-slate-50 rounded-xl border border-slate-100 min-w-[200px]">
            <span class="text-slate-500 text-sm font-medium mb-1">Saldo Saat Ini</span>
            <span class="text-3xl font-bold text-emerald-600">Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Affiliate Stats Mini Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <!-- Total Clicks -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex flex-col items-center justify-center text-center">
            <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm mb-2">
                <i class="fa-solid fa-hand-pointer"></i>
            </div>
            <p class="text-xs text-slate-500 font-medium mb-0.5">Total Klik Link</p>
            <p class="text-lg font-bold text-slate-800">{{ $affiliate->clicks_count ?? 0 }}</p>
        </div>

        <!-- Total Points -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex flex-col items-center justify-center text-center">
            <div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center text-sm mb-2">
                <i class="fa-solid fa-star"></i>
            </div>
            <p class="text-xs text-slate-500 font-medium mb-0.5">Total Poin</p>
            <p class="text-lg font-bold text-slate-800">{{ $affiliate->points ?? 0 }}</p>
        </div>

        <!-- Current Streak -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex flex-col items-center justify-center text-center">
            <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-sm mb-2">
                <i class="fa-solid fa-fire"></i>
            </div>
            <p class="text-xs text-slate-500 font-medium mb-0.5">Streak Aktif (Hari)</p>
            <p class="text-lg font-bold text-slate-800">{{ $affiliate->current_streak ?? 0 }}</p>
        </div>

        <!-- Highest Streak -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex flex-col items-center justify-center text-center">
            <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-sm mb-2">
                <i class="fa-solid fa-trophy"></i>
            </div>
            <p class="text-xs text-slate-500 font-medium mb-0.5">Rekor Streak</p>
            <p class="text-lg font-bold text-slate-800">{{ $affiliate->highest_streak ?? 0 }}</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Komisi History -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-wallet text-blue-500"></i> Riwayat Komisi
                </h3>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Keterangan</th>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase text-right">Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($commissions as $comm)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $comm->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-slate-800">{{ $comm->description ?? 'Komisi Project' }}</td>
                            <td class="px-4 py-3 text-sm font-bold text-emerald-600 text-right">+{{ number_format($comm->amount, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-slate-500 text-sm">Belum ada riwayat komisi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($commissions->hasPages())
                <div class="p-4 border-t border-slate-200">
                    {{ $commissions->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Withdrawal History -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-money-bill-transfer text-yellow-500"></i> Riwayat Penarikan
                </h3>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase text-right">Nominal (Rp)</th>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($withdrawals as $wd)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $wd->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm font-bold text-slate-800 text-right">{{ number_format($wd->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @if($wd->status === 'Pending')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($wd->status === 'Completed')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                                @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-slate-500 text-sm">Belum ada riwayat penarikan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($withdrawals->hasPages())
                <div class="p-4 border-t border-slate-200">
                    {{ $withdrawals->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Chat Templates List -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-message text-indigo-500"></i> Template Chat Dibuat
                </h3>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="max-h-[400px] overflow-y-auto">
                    @forelse($chatTemplates as $ct)
                    <div class="p-4 border-b border-slate-100 hover:bg-slate-50 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-sm text-slate-800">{{ $ct->name }}</h4>
                            @if($ct->businessCategory)
                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800">
                                {{ $ct->businessCategory->name }}
                            </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-600 bg-slate-100 p-2 rounded-lg font-mono whitespace-pre-wrap">{{ Str::limit($ct->content, 120) }}</p>
                    </div>
                    @empty
                    <div class="px-4 py-8 text-center text-slate-500 text-sm">
                        Belum ada template chat yang dibuat oleh partner ini.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Point Histories -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-orange-500"></i> Aktivitas Log In (Poin)
                </h3>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Waktu Klaim</th>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Aktivitas</th>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase text-right">Poin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($pointHistories as $ph)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-xs text-slate-600">{{ $ph->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-4 py-3 text-xs font-medium text-slate-800">{{ $ph->description }}</td>
                            <td class="px-4 py-3 text-xs font-bold text-yellow-600 text-right">+{{ $ph->points_earned }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-slate-500 text-sm">Belum ada aktivitas poin.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($pointHistories->hasPages())
                <div class="p-3 border-t border-slate-200 text-xs">
                    {{ $pointHistories->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
