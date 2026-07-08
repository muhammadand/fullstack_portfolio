@extends('layouts.admin.app')

@section('content')
<div class="px-6 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Withdrawal Requests</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola permintaan penarikan komisi dari Affiliate Partner.</p>
    </div>

    @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Partner</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jumlah & Bank</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($withdrawals as $w)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800">{{ $w->created_at->format('d M Y') }}</div>
                            <div class="text-sm text-slate-500">{{ $w->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-slate-800">{{ $w->affiliate->name ?? '-' }}</div>
                            <div class="text-xs text-slate-500">{{ $w->affiliate->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-blue-600">Rp {{ number_format($w->amount, 0, ',', '.') }}</div>
                            <div class="text-xs text-slate-600 mt-1">{{ $w->bank_info }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($w->status === 'Pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fa-solid fa-clock mr-1"></i> Menunggu Proses
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                <i class="fa-solid fa-check-double mr-1"></i> Selesai
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($w->status === 'Pending')
                            <button onclick="openProofModal('{{ $w->id }}', '{{ $w->affiliate->name }}', '{{ number_format($w->amount, 0, ',', '.') }}')" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors shadow-sm">
                                <i class="fa-solid fa-upload mr-1"></i> Upload Bukti
                            </button>
                            @else
                            <a href="{{ asset('storage/' . $w->proof_of_payment) }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline">Lihat Bukti</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada permintaan penarikan komisi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Upload Proof Modal -->
<div id="proofModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-xl">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-lg font-bold text-slate-800">Upload Bukti Transfer</h3>
            <button type="button" onclick="closeProofModal()" class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <p class="text-sm text-slate-600 mb-4">Partner: <strong id="modalPartnerName" class="text-slate-800"></strong><br>Jumlah: <strong id="modalAmount" class="text-blue-600"></strong></p>

        <form id="proofForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-2">Pilih File Bukti Pembayaran (JPG/PNG)</label>
                <input type="file" name="proof" required accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors">
            </div>

            <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors">
                Kirim Bukti & Selesaikan
            </button>
        </form>
    </div>
</div>

<script>
    function openProofModal(id, partnerName, amount) {
        document.getElementById('proofModal').classList.remove('hidden');
        document.getElementById('modalPartnerName').innerText = partnerName;
        document.getElementById('modalAmount').innerText = 'Rp ' + amount;

        const form = document.getElementById('proofForm');
        form.action = `/admin/withdrawals/${id}/approve`;
    }

    function closeProofModal() {
        document.getElementById('proofModal').classList.add('hidden');
    }

</script>
@endsection
