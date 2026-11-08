@extends('layouts.admin.app')

@section('content')
<div x-data="{
    proofModalOpen: false,
    viewProofModalOpen: false,
    selectedId: null,
    selectedPartnerName: '',
    selectedAmount: '',
    selectedBank: '',
    selectedSource: '',
    viewProofUrl: '',
    openProof(id, partnerName, amount, bank, source) {
        this.selectedId = id;
        this.selectedPartnerName = partnerName;
        this.selectedAmount = amount;
        this.selectedBank = bank;
        this.selectedSource = source;
        this.proofModalOpen = true;
    },
    viewProof(url, partnerName, amount) {
        this.viewProofUrl = url;
        this.selectedPartnerName = partnerName;
        this.selectedAmount = amount;
        this.viewProofModalOpen = true;
    }
}">

    {{-- Page Header --}}
    <x-admin.page-header title="Permintaan Penarikan" subtitle="Kelola permintaan penarikan Saldo Komisi & Saldo Wallet dari Affiliate Partner (Target transfer maks. 3x24 jam)." />

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        {{-- Total Requests --}}
        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                </div>
                <div>
                    <p class="text-slate-500 text-xs font-medium">Total Permintaan</p>
                    <p class="text-lg font-bold text-slate-900 mt-0.5">{{ number_format($totalCount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Pending Requests --}}
        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="text-slate-500 text-xs font-medium truncate">Menunggu Proses</p>
                        @if($pendingCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200 animate-pulse">
                            Perlu Transfer
                        </span>
                        @endif
                    </div>
                    <div class="flex items-baseline gap-2 mt-0.5">
                        <p class="text-lg font-bold {{ $pendingCount > 0 ? 'text-amber-600' : 'text-slate-900' }}">{{ $pendingCount }}</p>
                        <span class="text-xs text-slate-400 truncate">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Completed Requests --}}
        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-slate-500 text-xs font-medium truncate">Selesai Ditransfer</p>
                    <div class="flex items-baseline gap-2 mt-0.5">
                        <p class="text-lg font-bold text-emerald-600">{{ $completedCount }}</p>
                        <span class="text-xs text-slate-400 truncate">Rp {{ number_format($completedAmount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
    <x-admin.alert type="error">
        <p class="font-medium mb-1">Periksa kembali data yang diinput:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </x-admin.alert>
    @endif

    {{-- Main Card --}}
    <x-admin.card :padding="false">
        {{-- Toolbar Filter & Pencarian --}}
        <form method="GET" action="{{ route('admin.withdrawals.index') }}" class="flex flex-col sm:flex-row gap-2.5 p-4 border-b border-slate-200">
            <div class="relative flex-1 sm:max-w-sm">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                <x-admin.input name="q" :value="request('q') ?? request('search')" placeholder="Cari nama, email, no rekening..." class="pl-9" />
            </div>

            <div class="sm:w-44">
                <x-admin.select name="status">
                    <option value="">Semua Status</option>
                    <option value="{{ \App\Models\Withdrawal::STATUS_PENDING }}" {{ request('status') === \App\Models\Withdrawal::STATUS_PENDING ? 'selected' : '' }}>Menunggu Proses</option>
                    <option value="{{ \App\Models\Withdrawal::STATUS_COMPLETED }}" {{ request('status') === \App\Models\Withdrawal::STATUS_COMPLETED ? 'selected' : '' }}>Selesai</option>
                </x-admin.select>
            </div>

            <div class="sm:w-44">
                <x-admin.select name="source">
                    <option value="">Semua Sumber</option>
                    <option value="{{ \App\Models\Withdrawal::SOURCE_COMMISSION }}" {{ request('source') === \App\Models\Withdrawal::SOURCE_COMMISSION ? 'selected' : '' }}>Saldo Komisi</option>
                    <option value="{{ \App\Models\Withdrawal::SOURCE_WALLET }}" {{ request('source') === \App\Models\Withdrawal::SOURCE_WALLET ? 'selected' : '' }}>Saldo Wallet</option>
                </x-admin.select>
            </div>

            <div class="flex gap-2">
                <x-admin.button type="submit" variant="secondary">Filter</x-admin.button>
                @if(request('q') || request('search') || request('status') || request('source'))
                <x-admin.button variant="secondary" icon="fa-solid fa-xmark" :href="route('admin.withdrawals.index')">Reset</x-admin.button>
                @endif
            </div>
        </form>

        {{-- Table List (tablet & desktop) --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3 w-12">#</th>
                        <th class="px-4 py-3">Tanggal & Batas</th>
                        <th class="px-4 py-3">Partner</th>
                        <th class="px-4 py-3">Jumlah & Sumber</th>
                        <th class="px-4 py-3">Rekening Tujuan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($withdrawals as $w)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-4 py-3 text-slate-400">{{ $withdrawals->firstItem() + $loop->index }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-medium text-slate-900">{{ $w->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-slate-400">{{ $w->created_at->format('H:i') }} WIB</div>
                            @if($w->status === \App\Models\Withdrawal::STATUS_PENDING)
                            @if($w->created_at->copy()->addDays(3)->isPast())
                            <div class="text-[11px] text-rose-600 font-semibold mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-triangle-exclamation text-[10px]"></i> Lewat Batas 3 Hari
                            </div>
                            @else
                            <div class="text-[11px] text-slate-400 mt-1">
                                Batas: {{ $w->created_at->copy()->addDays(3)->format('d M H:i') }}
                            </div>
                            @endif
                            @elseif($w->processed_at)
                            <div class="text-[11px] text-emerald-600 mt-1 flex items-center gap-1 font-medium">
                                <i class="fa-solid fa-check text-[10px]"></i> {{ $w->processed_at->format('d M H:i') }}
                            </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 max-w-xs">
                            @if($w->affiliate)
                            <a href="{{ route('admin.affiliates.show', $w->affiliate->id) }}" class="font-medium text-slate-900 hover:text-blue-600 block truncate" title="{{ $w->affiliate->name }}">
                                {{ $w->affiliate->name }}
                            </a>
                            <span class="text-xs text-slate-400 truncate block">{{ $w->affiliate->email }}</span>
                            @else
                            <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-bold text-slate-900 text-sm">
                                Rp {{ number_format($w->amount, 0, ',', '.') }}
                            </div>
                            <div class="mt-1">
                                @if($w->source === \App\Models\Withdrawal::SOURCE_WALLET)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                    <i class="fa-solid fa-wallet text-[9px]"></i> Saldo Wallet
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200/70">
                                    <i class="fa-solid fa-handshake text-[9px]"></i> Saldo Komisi
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-xs font-medium text-slate-800 break-words max-w-[200px]">
                                {{ $w->bank_info }}
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($w->status === \App\Models\Withdrawal::STATUS_PENDING)
                            <x-admin.badge color="yellow">
                                <i class="fa-solid fa-clock text-[10px]"></i> Menunggu
                            </x-admin.badge>
                            @else
                            <x-admin.badge color="green">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> Selesai
                            </x-admin.badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right">
                            @if($w->status === \App\Models\Withdrawal::STATUS_PENDING)
                            <x-admin.button type="button" size="sm" icon="fa-solid fa-upload" @click="openProof('{{ $w->id }}', '{{ addslashes($w->affiliate->name ?? 'Partner') }}', '{{ number_format($w->amount, 0, ',', '.') }}', '{{ addslashes($w->bank_info) }}', '{{ \App\Models\Withdrawal::sourceLabel($w->source) }}')">
                                Upload Bukti
                            </x-admin.button>
                            @else
                            <x-admin.button type="button" variant="secondary" size="sm" icon="fa-solid fa-receipt" @click="viewProof('{{ asset('storage/' . $w->proof_of_payment) }}', '{{ addslashes($w->affiliate->name ?? 'Partner') }}', '{{ number_format($w->amount, 0, ',', '.') }}')">
                                Lihat Bukti
                            </x-admin.button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-money-bill-transfer text-xl"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-700">
                                {{ request('q') || request('search') || request('status') || request('source') ? 'Tidak ada penarikan yang cocok dengan filter.' : 'Belum ada permintaan penarikan dana.' }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">
                                {{ request('q') || request('search') || request('status') || request('source') ? 'Coba ganti filter atau reset pencarian.' : 'Permintaan penarikan dari partner affiliate akan muncul di sini.' }}
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- HP: kartu --}}
        <div class="md:hidden divide-y divide-slate-100">
            @forelse($withdrawals as $w)
            @php $pending = $w->status === \App\Models\Withdrawal::STATUS_PENDING; @endphp
            <div class="p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-semibold text-slate-900 truncate">{{ $w->affiliate->name ?? '-' }}</p>
                        <p class="text-[11px] text-slate-400">{{ $w->created_at->format('d M Y, H:i') }} · {{ \App\Models\Withdrawal::sourceLabel($w->source) }}</p>
                    </div>
                    @if($pending)
                    <x-admin.badge color="yellow">Menunggu</x-admin.badge>
                    @else
                    <x-admin.badge color="green">Selesai</x-admin.badge>
                    @endif
                </div>
                <p class="mt-2 text-xl font-bold text-slate-900">Rp {{ number_format($w->amount, 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-slate-600 break-words"><i class="fa-solid fa-building-columns text-slate-400 mr-1"></i>{{ $w->bank_info }}</p>
                @if($pending && $w->created_at->copy()->addDays(3)->isPast())
                <p class="mt-1 text-[11px] font-semibold text-rose-600"><i class="fa-solid fa-triangle-exclamation"></i> Lewat batas 3 hari</p>
                @endif
                <div class="mt-3">
                    @if($pending)
                    <x-admin.button type="button" size="sm" icon="fa-solid fa-upload" class="w-full justify-center" @click="openProof('{{ $w->id }}', '{{ addslashes($w->affiliate->name ?? 'Partner') }}', '{{ number_format($w->amount, 0, ',', '.') }}', '{{ addslashes($w->bank_info) }}', '{{ \App\Models\Withdrawal::sourceLabel($w->source) }}')">Upload Bukti</x-admin.button>
                    @else
                    <x-admin.button type="button" variant="secondary" size="sm" icon="fa-solid fa-receipt" class="w-full justify-center" @click="viewProof('{{ asset('storage/' . $w->proof_of_payment) }}', '{{ addslashes($w->affiliate->name ?? 'Partner') }}', '{{ number_format($w->amount, 0, ',', '.') }}')">Lihat Bukti</x-admin.button>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-4 py-12 text-center text-sm text-slate-500">
                {{ request('q') || request('search') || request('status') || request('source') ? 'Tidak ada penarikan yang cocok dengan filter.' : 'Belum ada permintaan penarikan dana.' }}
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($withdrawals->hasPages())
        <div class="px-4 py-3 border-t border-slate-200">
            {{ $withdrawals->links('pagination::tailwind') }}
        </div>
        @endif
    </x-admin.card>

    {{-- Modal Upload Bukti Transfer --}}
    <div x-show="proofModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="proofModalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div class="min-h-full p-4 flex items-center justify-center">
            <div x-show="proofModalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @click.away="proofModalOpen = false" class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-6 z-10">

                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-file-invoice-dollar text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Upload Bukti Transfer</h3>
                            <p class="text-xs text-slate-400">Selesaikan penarikan dana partner.</p>
                        </div>
                    </div>
                    <button type="button" @click="proofModalOpen = false" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                {{-- Detail Rekap Transfer --}}
                <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-xl space-y-2 mb-4 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Partner:</span>
                        <span class="font-bold text-slate-800" x-text="selectedPartnerName"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Jumlah Transfer:</span>
                        <span class="font-bold text-emerald-600 text-sm">Rp <span x-text="selectedAmount"></span></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Sumber Saldo:</span>
                        <span class="font-semibold text-slate-700" x-text="selectedSource"></span>
                    </div>
                    <div class="pt-2 border-t border-slate-200 flex flex-col gap-0.5">
                        <span class="text-slate-500">Rekening Tujuan:</span>
                        <span class="font-medium text-slate-900 break-words" x-text="selectedBank"></span>
                    </div>
                </div>

                <form :action="'/admin/withdrawals/' + selectedId + '/approve'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <x-admin.label required>Pilih File Bukti Pembayaran (JPG/PNG)</x-admin.label>
                        <input type="file" name="proof" required accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors border border-slate-200 rounded-xl p-1 bg-white">
                        <x-admin.hint for="proof">Format gambar maksimal 2MB. Partner akan menerima notifikasi otomatis.</x-admin.hint>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                        <x-admin.button type="button" variant="secondary" @click="proofModalOpen = false">Batal</x-admin.button>
                        <x-admin.button type="submit" icon="fa-solid fa-paper-plane">Kirim Bukti & Selesaikan</x-admin.button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Lihat Bukti Transfer --}}
    <div x-show="viewProofModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="viewProofModalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div class="min-h-full p-4 flex items-center justify-center">
            <div x-show="viewProofModalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @click.away="viewProofModalOpen = false" class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl border border-slate-200 p-6 z-10">

                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="fa-solid fa-receipt text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Bukti Pembayaran</h3>
                            <p class="text-xs text-slate-400">Transfer untuk <span class="font-medium text-slate-700" x-text="selectedPartnerName"></span> (Rp <span x-text="selectedAmount"></span>)</p>
                        </div>
                    </div>
                    <button type="button" @click="viewProofModalOpen = false" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden max-h-[420px] flex items-center justify-center p-2 mb-4">
                    <img :src="viewProofUrl" alt="Bukti Transfer" class="max-w-full max-h-[380px] object-contain rounded-lg">
                </div>

                <div class="flex items-center justify-between gap-2">
                    <a :href="viewProofUrl" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:underline">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Gambar Penuh
                    </a>
                    <x-admin.button type="button" variant="secondary" @click="viewProofModalOpen = false">Tutup</x-admin.button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
