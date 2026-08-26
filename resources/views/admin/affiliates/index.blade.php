@extends('layouts.admin.app')

@section('content')
<div class="px-4 sm:px-6 py-4 sm:py-8">
    <div class="flex flex-col sm:flex-row mb-6 justify-between items-start sm:items-end gap-4 sm:gap-0">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Affiliate Dashboard</h1>
            <p class="text-slate-500 text-xs mt-1">Pantau performa partner dan kelola komisi di satu tempat.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <button onclick="sendPushNotification()" class="flex items-center justify-center w-full sm:w-auto gap-1.5 px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                <i class="fa-solid fa-bell"></i> Broadcast Notif
            </button>
            <button onclick="openAddPartnerModal()" class="flex items-center justify-center w-full sm:w-auto gap-1.5 px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                <i class="fa-solid fa-plus"></i> Tambah Partner
            </button>
        </div>
    </div>

    <!-- Dashboard Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-6">
        <!-- Total Partners -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-slate-500 text-[10px] sm:text-xs font-medium leading-tight mb-1 sm:mb-0">Total Partner</p>
                <p class="text-base sm:text-xl font-bold text-slate-800 leading-none">{{ $totalPartners }}</p>
            </div>
        </div>

        <!-- Total Clicks -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3">
            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-hand-pointer"></i>
            </div>
            <div>
                <p class="text-slate-500 text-[10px] sm:text-xs font-medium leading-tight mb-1 sm:mb-0">Total Klik</p>
                <p class="text-base sm:text-xl font-bold text-slate-800 leading-none">{{ $totalClicks }}</p>
            </div>
        </div>

        <!-- Total Commissions -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <p class="text-slate-500 text-[10px] sm:text-xs font-medium leading-tight mb-1 sm:mb-0">Diberikan</p>
                <p class="text-base sm:text-lg font-bold text-slate-800 leading-none truncate max-w-[80px] sm:max-w-none">Rp {{ number_format($totalCommissions, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Pending Approval -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex flex-col sm:flex-row items-center text-center sm:text-left gap-2 sm:gap-3">
            <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div>
                <p class="text-slate-500 text-[10px] sm:text-xs font-medium leading-tight mb-1 sm:mb-0">Persetujuan</p>
                <p class="text-base sm:text-xl font-bold text-slate-800 leading-none">{{ $totalPending }}</p>
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

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Partner</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Performa</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Saldo Komisi</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($affiliates as $affiliate)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-800">{{ $affiliate->name }}</div>
                            <div class="text-xs text-slate-500">{{ $affiliate->email }}</div>
                            <div class="text-[10px] text-slate-400 mt-0.5">Kode: <span class="font-bold text-blue-600">{{ $affiliate->affiliate_code }}</span></div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-purple-50 text-purple-700 rounded-lg text-xs font-medium">
                                <i class="fa-solid fa-hand-pointer"></i> {{ $affiliate->clicks_count ?? 0 }} Klik
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-bold text-slate-800">Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</div>
                            <div class="text-[10px] text-slate-500 mt-0.5">{{ $affiliate->bank_info }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @if($affiliate->status === 'pending')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                            @elseif($affiliate->status === 'approved')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-800">
                                Approved
                            </span>
                            @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-100 text-red-800">
                                Rejected
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($affiliate->status === 'pending')
                            <div class="flex items-center justify-end gap-1.5">
                                <form action="{{ route('admin.affiliates.approve', $affiliate->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-1.5 px-2 py-1 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors min-w-[50px]" onclick="return confirm('Setujui partner ini?')">
                                        <i class="fa-solid fa-check text-[10px] sm:text-[12px]"></i>
                                        <span class="text-[9px] sm:text-xs">Approve</span>
                                    </button>
                                </form>
                                <form action="{{ route('admin.affiliates.reject', $affiliate->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-1.5 px-2 py-1 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors min-w-[50px]" onclick="return confirm('Tolak partner ini?')">
                                        <i class="fa-solid fa-xmark text-[10px] sm:text-[12px]"></i>
                                        <span class="text-[9px] sm:text-xs">Reject</span>
                                    </button>
                                </form>
                            </div>
                            @elseif($affiliate->status === 'approved')
                            <div class="flex items-center justify-end gap-1.5">
                                @php
                                $magicLoginUrl = \Illuminate\Support\Facades\URL::signedRoute('affiliate.magic_login', ['affiliate' => $affiliate->id]);
                                @endphp
                                <button type="button" onclick="copyMagicLink('{{ $magicLoginUrl }}')" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-1.5 px-2 py-1 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors shadow-sm min-w-[50px]" title="Salin Magic Login Link">
                                    <i class="fa-solid fa-link text-[10px] sm:text-[12px]"></i>
                                    <span class="text-[9px] sm:text-xs">Magic Link</span>
                                </button>
                                <a href="{{ route('admin.affiliates.show', $affiliate->id) }}" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-1.5 px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors border border-slate-200 min-w-[50px]">
                                    <i class="fa-solid fa-eye text-[10px] sm:text-[12px]"></i>
                                    <span class="text-[9px] sm:text-xs">Detail</span>
                                </a>
                                <button type="button" onclick="openCommissionModal({{ $affiliate->id }}, '{{ addslashes($affiliate->name) }}')" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-1.5 px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm min-w-[50px]">
                                    <i class="fa-solid fa-plus text-[10px] sm:text-[12px]"></i>
                                    <span class="text-[9px] sm:text-xs">Komisi</span>
                                </button>
                            </div>
                            @else
                            <a href="{{ route('admin.affiliates.show', $affiliate->id) }}" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-1.5 px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors border border-slate-200 inline-flex min-w-[50px]">
                                <i class="fa-solid fa-eye text-[10px] sm:text-[12px]"></i>
                                <span class="text-[9px] sm:text-xs">Detail</span>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-slate-500 text-sm">
                            Belum ada pendaftar affiliate.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden divide-y divide-slate-100">
            @forelse($affiliates as $affiliate)
            <div class="p-4 hover:bg-slate-50 transition-colors">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <div class="font-bold text-slate-800 text-sm">{{ $affiliate->name }}</div>
                        <div class="text-[11px] text-slate-500">{{ $affiliate->email }}</div>
                    </div>
                    <div>
                        @if($affiliate->status === 'pending')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-yellow-100 text-yellow-800">Pending</span>
                        @elseif($affiliate->status === 'approved')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-800">Approved</span>
                        @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-100 text-red-800">Rejected</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4 bg-slate-50 rounded-lg p-3 border border-slate-100">
                    <div>
                        <p class="text-[10px] text-slate-500 mb-0.5">Kode Referral</p>
                        <p class="text-xs font-bold text-blue-600">{{ $affiliate->affiliate_code }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 mb-0.5">Performa</p>
                        <p class="text-xs font-medium text-purple-700"><i class="fa-solid fa-hand-pointer mr-1"></i> {{ $affiliate->clicks_count ?? 0 }} Klik</p>
                    </div>
                    <div class="col-span-2 pt-2 border-t border-slate-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-[10px] text-slate-500 mb-0.5">Saldo Komisi</p>
                                <p class="text-sm font-bold text-emerald-600">Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right max-w-[50%]">
                                <p class="text-[10px] text-slate-500 mb-0.5">Bank</p>
                                <p class="text-[10px] font-medium text-slate-700 truncate">{{ $affiliate->bank_info ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 justify-end">
                    @if($affiliate->status === 'pending')
                    <form action="{{ route('admin.affiliates.approve', $affiliate->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-1.5 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition-colors" onclick="return confirm('Setujui partner ini?')">
                            <i class="fa-solid fa-check"></i> Approve
                        </button>
                    </form>
                    <form action="{{ route('admin.affiliates.reject', $affiliate->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-1.5 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg transition-colors" onclick="return confirm('Tolak partner ini?')">
                            <i class="fa-solid fa-xmark"></i> Reject
                        </button>
                    </form>
                    @elseif($affiliate->status === 'approved')
                    @php
                    $magicLoginUrl = \Illuminate\Support\Facades\URL::signedRoute('affiliate.magic_login', ['affiliate' => $affiliate->id]);
                    @endphp
                    <button type="button" onclick="copyMagicLink('{{ $magicLoginUrl }}')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                        <i class="fa-solid fa-link"></i> Link
                    </button>
                    <a href="{{ route('admin.affiliates.show', $affiliate->id) }}" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition-colors border border-slate-200">
                        <i class="fa-solid fa-eye"></i> Detail
                    </a>
                    <button type="button" onclick="openCommissionModal({{ $affiliate->id }}, '{{ addslashes($affiliate->name) }}')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                        <i class="fa-solid fa-plus"></i> Komisi
                    </button>
                    @else
                    <a href="{{ route('admin.affiliates.show', $affiliate->id) }}" class="w-full flex items-center justify-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition-colors border border-slate-200">
                        <i class="fa-solid fa-eye"></i> Detail
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-500 text-sm">
                Belum ada pendaftar affiliate.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $affiliates->links() }}
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

    function sendPushNotification() {
        if (!confirm('Kirim notifikasi Push ("Semangat Pagi") ke semua Partner sekarang?')) return;

        fetch('/api/cron/send-daily-push?secret=cuan-tiap-hari')
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Sukses: ' + data.message);
                } else {
                    alert('Info: ' + (data.message || data.error || 'Gagal mengirim notifikasi.'));
                }
            })
            .catch(err => {
                alert('Terjadi kesalahan sistem: ' + err);
            });
    }

    function openAddPartnerModal() {
        const modal = document.getElementById('addPartnerModal');
        const content = document.getElementById('addPartnerModalContent');

        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }

    function closeAddPartnerModal() {
        const modal = document.getElementById('addPartnerModal');
        const content = document.getElementById('addPartnerModalContent');

        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 150);
    }

    function copyMagicLink(url) {
        navigator.clipboard.writeText(url).then(function() {
            alert('Magic Login Link berhasil disalin!\nLink ini berlaku selamanya.\nAnda dapat mengirimkan link ini kepada Partner.');
        }, function(err) {
            alert('Gagal menyalin link: ' + err);
        });
    }

</script>

<!-- Add Partner Modal -->
<div id="addPartnerModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white w-full max-w-lg p-6 rounded-3xl shadow-2xl transform scale-95 transition-transform duration-300" id="addPartnerModalContent">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800">Tambah Partner Baru</h3>
            <button type="button" onclick="closeAddPartnerModal()" class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.affiliates.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 rounded-xl py-2.5 px-4 focus:outline-none focus:border-blue-400 transition-colors" placeholder="Masukkan nama">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 rounded-xl py-2.5 px-4 focus:outline-none focus:border-blue-400 transition-colors" placeholder="email@contoh.com">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required minlength="8" class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 rounded-xl py-2.5 px-4 focus:outline-none focus:border-blue-400 transition-colors" placeholder="Minimal 8 karakter">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1">Status Awal</label>
                <select name="status" class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 rounded-xl py-2.5 px-4 focus:outline-none focus:border-blue-400 transition-colors">
                    <option value="approved">Approved (Langsung Aktif)</option>
                    <option value="pending">Pending (Perlu Review)</option>
                </select>
            </div>

            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-sm">
                Simpan Partner
            </button>
        </form>
    </div>
</div>

@endsection
