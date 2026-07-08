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
    </div>
</div>
@endsection
