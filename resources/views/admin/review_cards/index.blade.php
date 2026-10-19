@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8" x-data="{ batchModal: false }">

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2.5">
                <i class="fa-solid fa-qrcode text-blue-600"></i>
                Google Review Cards
            </h1>
            <p class="text-slate-500 text-sm mt-1">Kelola unit fisik stiker & kartu QR tap review untuk pelanggan Scalify.</p>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <button @click="batchModal = true" type="button" class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-xl shadow-sm text-sm font-semibold transition-colors flex-1 sm:flex-none">
                <i class="fa-solid fa-layer-group"></i>
                <span>Generate Batch (Cetak)</span>
            </button>
            <a href="{{ route('admin.review_cards.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl shadow-sm text-sm font-semibold transition-colors flex-1 sm:flex-none">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Kartu</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl mb-6 text-sm flex items-center gap-3" role="alert">
        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl mb-6 text-sm flex items-center gap-3" role="alert">
        <i class="fa-solid fa-circle-exclamation text-red-500 text-base"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Quick Stats (Agregat Ringan) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Kartu</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($stats->total ?? 0) }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs font-medium text-emerald-600 uppercase tracking-wider">Aktif Digunakan</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($stats->active ?? 0) }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs font-medium text-amber-500 uppercase tracking-wider">Belum Aktif (Gudang)</p>
            <p class="text-2xl font-bold text-amber-500 mt-1">{{ number_format($stats->pending ?? 0) }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs font-medium text-blue-600 uppercase tracking-wider">Total Scan Review</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($stats->total_scans ?? 0) }}</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.review_cards.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor serial, nama usaha, atau URL slug..." class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>

            <div class="sm:w-44">
                <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending (Gudang)</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition-colors">
                Filter
            </button>
            @if(request('search') || request('status'))
            <a href="{{ route('admin.review_cards.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition-colors text-center">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 text-xs uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">Serial & PIN</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Bisnis / Pemilik</th>
                        <th class="py-3.5 px-4">URL Scan (QR / NFC)</th>
                        <th class="py-3.5 px-4 text-center">Scan</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($cards as $card)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- Serial & PIN -->
                        <td class="py-3.5 px-4">
                            <div class="font-mono font-bold text-slate-900 text-xs tracking-wide">
                                {{ $card->serial_number }}
                            </div>
                            <div class="text-[11px] text-slate-400 mt-0.5">
                                PIN: <span class="font-mono text-slate-600 font-semibold">{{ $card->activation_code }}</span>
                            </div>
                        </td>

                        <!-- Status Badge -->
                        <td class="py-3.5 px-4">
                            @if($card->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @elseif($card->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Belum Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <!-- Bisnis & Link Google Review -->
                        <td class="py-3.5 px-4">
                            @if($card->business_name)
                                <div class="font-semibold text-slate-900">{{ $card->business_name }}</div>
                                @if($card->google_review_url)
                                    <a href="{{ $card->google_review_url }}" target="_blank" rel="noopener noreferrer" class="text-xs text-blue-600 hover:underline inline-flex items-center gap-1 mt-0.5 truncate max-w-xs block">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        <span>Lihat Link Google Review</span>
                                    </a>
                                @endif
                            @else
                                <span class="text-slate-400 text-xs italic">Belum diklaim</span>
                            @endif
                        </td>

                        <!-- URL Scan / Slug -->
                        <td class="py-3.5 px-4">
                            @php $scanUrl = url('/r/' . $card->slug); @endphp
                            <div class="flex items-center gap-2">
                                <a href="{{ $scanUrl }}" target="_blank" class="font-mono text-xs text-blue-600 hover:text-blue-800 bg-blue-50 px-2 py-1 rounded border border-blue-200">
                                    /r/{{ $card->slug }}
                                </a>
                                <button type="button" onclick="navigator.clipboard.writeText('{{ $scanUrl }}'); alert('Link scan berhasil disalin!');" class="text-slate-400 hover:text-slate-600 p-1" title="Salin URL">
                                    <i class="fa-regular fa-copy text-xs"></i>
                                </button>
                            </div>
                        </td>

                        <!-- Counter Scan -->
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-700">
                                {{ number_format($card->total_scans) }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <!-- Quick Toggle Status -->
                                <form action="{{ route('admin.review_cards.toggle_status', $card->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-amber-600 rounded-lg hover:bg-slate-100 transition-colors" title="Ubah Status Aktif/Nonaktif">
                                        <i class="fa-solid fa-power-off text-xs"></i>
                                    </button>
                                </form>

                                <!-- Detail & Template Cetak -->
                                <a href="{{ route('admin.review_cards.show', $card->id) }}" class="p-1.5 text-blue-600 hover:text-blue-800 rounded-lg hover:bg-blue-50 transition-colors" title="Lihat Desain & Cetak Kartu">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.review_cards.edit', $card->id) }}" class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition-colors" title="Edit Kartu">
                                    <i class="fa-regular fa-pen-to-square text-xs"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.review_cards.destroy', $card->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kartu {{ $card->serial_number }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded-lg hover:bg-slate-100 transition-colors" title="Hapus">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-slate-400">
                            <i class="fa-solid fa-qrcode text-4xl mb-3 text-slate-300 block"></i>
                            <p class="font-medium">Belum ada Review Card yang terdaftar.</p>
                            <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Generate Batch" untuk membuat unit siap cetak massal.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($cards->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $cards->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Generate Batch Massal (Cepat & Ringan) -->
    <div x-show="batchModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(15, 23, 42, 0.6);">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div @click.away="batchModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-blue-600"></i>
                        Generate Batch Cetak
                    </h3>
                    <button @click="batchModal = false" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('admin.review_cards.batch_generate') }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Jumlah Unit Kartu/Stiker</label>
                        <input type="number" name="quantity" min="1" max="100" value="10" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <p class="text-[11px] text-slate-400 mt-1">Maksimal 100 unit per sekali generate untuk performa kilat.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Prefix Serial Number</label>
                        <input type="text" name="prefix" value="SCL" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <p class="text-[11px] text-slate-400 mt-1">Format: SCL-2610-XXXX (Tercetak di kartu/box).</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Catatan Batch (Opsional)</label>
                        <input type="text" name="notes" placeholder="Contoh: Batch Cetak Vendor A 100 Pcs" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div class="pt-2 flex items-center justify-end gap-2">
                        <button type="button" @click="batchModal = false" class="px-4 py-2 text-sm text-slate-600 hover:bg-slate-100 rounded-lg">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">
                            Generate Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
