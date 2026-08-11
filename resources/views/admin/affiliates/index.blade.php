@extends('layouts.admin.app')

@section('content')
<div class="px-4 sm:px-6 py-4 sm:py-8">
    <div class="hidden sm:flex mb-8 justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Affiliate Dashboard</h1>
            <p class="text-slate-500 text-sm mt-1">Pantau performa partner dan kelola komisi di satu tempat.</p>
        </div>
    </div>

    <!-- Dashboard Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
        <!-- Total Partners -->
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-slate-500 text-[10px] sm:text-sm font-medium leading-tight mb-1 sm:mb-0">Total Partner</p>
                <p class="text-base sm:text-2xl font-bold text-slate-800 leading-none">{{ $totalPartners }}</p>
            </div>
        </div>

        <!-- Total Clicks -->
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
                <i class="fa-solid fa-hand-pointer"></i>
            </div>
            <div>
                <p class="text-slate-500 text-[10px] sm:text-sm font-medium leading-tight mb-1 sm:mb-0">Total Klik</p>
                <p class="text-base sm:text-2xl font-bold text-slate-800 leading-none">{{ $totalClicks }}</p>
            </div>
        </div>

        <!-- Total Commissions -->
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <p class="text-slate-500 text-[10px] sm:text-sm font-medium leading-tight mb-1 sm:mb-0">Diberikan</p>
                <p class="text-base sm:text-xl font-bold text-slate-800 leading-none truncate max-w-[80px] sm:max-w-none">Rp {{ number_format($totalCommissions, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Pending Approval -->
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div>
                <p class="text-slate-500 text-[10px] sm:text-sm font-medium leading-tight mb-1 sm:mb-0">Persetujuan</p>
                <p class="text-base sm:text-2xl font-bold text-slate-800 leading-none">{{ $totalPending }}</p>
            </div>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Partner</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Performa</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Saldo Komisi</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($affiliates as $affiliate)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800">{{ $affiliate->name }}</div>
                            <div class="text-sm text-slate-500">{{ $affiliate->email }}</div>
                            <div class="text-xs text-slate-400 mt-1">Kode: <span class="font-bold text-blue-600">{{ $affiliate->affiliate_code }}</span></div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex items-center gap-1 px-3 py-1 bg-purple-50 text-purple-700 rounded-lg text-sm font-medium">
                                <i class="fa-solid fa-hand-pointer"></i> {{ $affiliate->clicks_count ?? 0 }} Klik
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-slate-800">Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</div>
                            <div class="text-xs text-slate-500 mt-1">{{ $affiliate->bank_info }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($affiliate->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                            @elseif($affiliate->status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Approved
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Rejected
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($affiliate->status === 'pending')
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.affiliates.approve', $affiliate->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors min-w-[50px]" onclick="return confirm('Setujui partner ini?')">
                                        <i class="fa-solid fa-check text-[14px] sm:text-[12px]"></i>
                                        <span class="text-[9px] sm:text-xs">Approve</span>
                                    </button>
                                </form>
                                <form action="{{ route('admin.affiliates.reject', $affiliate->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors min-w-[50px]" onclick="return confirm('Tolak partner ini?')">
                                        <i class="fa-solid fa-xmark text-[14px] sm:text-[12px]"></i>
                                        <span class="text-[9px] sm:text-xs">Reject</span>
                                    </button>
                                </form>
                            </div>
                            @elseif($affiliate->status === 'approved')
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.affiliates.show', $affiliate->id) }}" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors border border-slate-200 min-w-[50px]">
                                    <i class="fa-solid fa-eye text-[14px] sm:text-[12px]"></i>
                                    <span class="text-[9px] sm:text-xs">Detail</span>
                                </a>
                                <button type="button" onclick="openCommissionModal({{ $affiliate->id }}, '{{ addslashes($affiliate->name) }}')" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm min-w-[50px]">
                                    <i class="fa-solid fa-plus text-[14px] sm:text-[12px]"></i>
                                    <span class="text-[9px] sm:text-xs">Komisi</span>
                                </button>
                            </div>
                            @else
                            <a href="{{ route('admin.affiliates.show', $affiliate->id) }}" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors border border-slate-200 inline-flex min-w-[50px]">
                                <i class="fa-solid fa-eye text-[14px] sm:text-[12px]"></i>
                                <span class="text-[9px] sm:text-xs">Detail</span>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada pendaftar affiliate.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Commission Modal -->
<div id="commissionModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white w-full max-w-md p-6 rounded-3xl shadow-2xl transform scale-95 transition-transform duration-300" id="commissionModalContent">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800">Tambah Komisi Partner</h3>
            <button type="button" onclick="closeCommissionModal()" class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="mb-4 p-3 bg-blue-50 border border-blue-100 rounded-xl text-sm">
            <span class="font-semibold text-blue-800">Partner:</span> <span id="partnerNameDisplay" class="text-blue-900 font-bold"></span>
        </div>

        <form id="commissionForm" action="" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-2">Keterangan / Komisi dari Project Apa?</label>
                <input type="text" name="description" required class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 rounded-xl py-3 px-4 mb-4 focus:outline-none focus:border-blue-400 transition-colors" placeholder="Contoh: Komisi Project Web E-Commerce PT XYZ">

                <label class="block text-sm font-medium text-slate-700 mb-2">Nominal Komisi (Rp)</label>
                <input type="number" name="amount" min="1000" required class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 font-bold rounded-xl py-3 px-4 focus:outline-none focus:border-blue-400 transition-colors" placeholder="Contoh: 150000">

                <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-xs text-yellow-800 leading-relaxed">
                    <i class="fa-solid fa-circle-info mr-1"></i> <b>Keterangan Sistem:</b><br>
                    Sesuai kebijakan sistem, komisi yang diberikan kepada partner adalah <b>10% dari nilai total project</b> yang berhasil (deal). Pastikan nominal yang diinput sudah sesuai.
                </div>
            </div>

            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-sm">
                Tambahkan Komisi
            </button>
        </form>
    </div>
</div>

<script>
    function openCommissionModal(id, name) {
        const modal = document.getElementById('commissionModal');
        const content = document.getElementById('commissionModalContent');
        const form = document.getElementById('commissionForm');
        const nameDisplay = document.getElementById('partnerNameDisplay');

        nameDisplay.textContent = name;
        form.action = `/admin/affiliates/${id}/commission`;

        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }

    function closeCommissionModal() {
        const modal = document.getElementById('commissionModal');
        const content = document.getElementById('commissionModalContent');

        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 150);
    }

</script>
@endsection
