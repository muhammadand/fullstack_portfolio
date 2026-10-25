@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8" x-data="{
    batchModal: false,
    soldModal: false,
    soldCard: { serial_number: '', customer_name: '', actionUrl: '' },
    openSoldModal(serial, customer, url) {
        this.soldCard = { serial_number: serial, customer_name: customer || '-', actionUrl: url };
        this.soldModal = true;
    },
    verifyOrderModal: false,
    cancelOrderModal: false,
    selectedOrder: { order_id: '', partner: '', qty: 1, amount: '', actionUrl: '' },
    openVerifyModal(orderId, partner, qty, amount, url) {
        this.selectedOrder = { order_id: orderId, partner: partner, qty: qty, amount: amount, actionUrl: url };
        this.verifyOrderModal = true;
    },
    openCancelModal(orderId, partner, qty, amount, url) {
        this.selectedOrder = { order_id: orderId, partner: partner, qty: qty, amount: amount, actionUrl: url };
        this.cancelOrderModal = true;
    }
}">

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
            <p class="text-xs font-medium text-emerald-600 uppercase tracking-wider">Terjual</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($stats->sold ?? 0) }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs font-medium text-amber-500 uppercase tracking-wider">Belum Terjual</p>
            <p class="text-2xl font-bold text-amber-500 mt-1">{{ number_format($stats->unsold ?? 0) }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs font-medium text-blue-600 uppercase tracking-wider">Total Scan Review</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($stats->total_scans ?? 0) }}</p>
        </div>
    </div>

    <!-- Pesanan QRIS Partner Menunggu Verifikasi (Full Width) -->
    @if(!empty($pendingOrders))
    <div class="bg-white border border-amber-200 rounded-2xl p-5 mb-6 shadow-sm overflow-hidden relative">
        <div class="absolute top-0 left-0 bottom-0 w-1.5 bg-amber-500"></div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4 pl-1">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Menunggu Verifikasi Pembayaran QRIS ({{ count($pendingOrders) }} Pesanan)</h2>
                    <p class="text-xs text-slate-500">Partner telah melakukan transfer QRIS. Klik verifikasi jika dana sudah masuk untuk menyerahkan kuota kartu.</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200 w-fit">
                Perlu Tindakan
            </span>
        </div>

        <div class="space-y-2.5 pl-1">
            @foreach($pendingOrders as $order)
            <div class="bg-slate-50 hover:bg-slate-100/80 transition-colors rounded-xl p-3.5 border border-slate-200/80 flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-sm text-slate-800 font-mono">#{{ $order['order_id'] ?? '' }}</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200/80">
                            {{ $order['quantity'] ?? 1 }} Unit Kartu
                        </span>
                        <span class="text-[11px] text-slate-400">
                            {{ \Carbon\Carbon::parse($order['ordered_at'] ?? now())->diffForHumans() }}
                        </span>
                    </div>

                    <div class="text-xs text-slate-600 flex flex-wrap items-center gap-x-4 gap-y-1">
                        <span>Partner: <b class="text-slate-800">{{ $order['partner_name'] ?? '-' }}</b> ({{ $order['partner_email'] ?? '-' }})</span>
                        <span>Total Tagihan: <b class="text-emerald-600 font-mono font-bold">Rp {{ number_format($order['total_amount'] ?? 0, 0, ',', '.') }}</b> <span class="text-slate-400 text-[11px]">(Biaya Admin: Rp {{ number_format($order['unique_code'] ?? 0, 0, ',', '.') }})</span></span>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <button type="button" @click="openVerifyModal('{{ $order['order_id'] }}', '{{ addslashes($order['partner_name'] ?? '-') }}', '{{ $order['quantity'] ?? 1 }}', 'Rp {{ number_format($order['total_amount'] ?? 0, 0, ',', '.') }}', '{{ route('admin.review_cards.verify_order', $order['order_id']) }}')" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold shadow-sm transition-all active:scale-95 cursor-pointer">
                        <i class="fa-solid fa-check"></i>
                        <span>Verifikasi &amp; Aktifkan</span>
                    </button>

                    <button type="button" @click="openCancelModal('{{ $order['order_id'] }}', '{{ addslashes($order['partner_name'] ?? '-') }}', '{{ $order['quantity'] ?? 1 }}', 'Rp {{ number_format($order['total_amount'] ?? 0, 0, ',', '.') }}', '{{ route('admin.review_cards.cancel_order', $order['order_id']) }}')" class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-red-50 text-slate-600 hover:text-red-600 border border-slate-200 rounded-lg text-xs font-medium transition-colors cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                        <span>Batalkan</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.review_cards.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor serial, nama usaha, atau URL slug..." class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>

            <div class="sm:w-48">
                <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white">
                    <option value="">Semua Status</option>
                    <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Terjual</option>
                    <option value="unsold" {{ request('status') === 'unsold' ? 'selected' : '' }}>Belum Terjual</option>
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
                            @if($card->is_sold)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i class="fa-solid fa-lock text-[10px] text-emerald-600"></i>
                                Terjual
                            </span>
                            @elseif($card->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                Aktif (Toko)
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
                                <!-- Detail & Template Cetak -->
                                <a href="{{ route('admin.review_cards.show', $card->id) }}" class="p-1.5 text-blue-600 hover:text-blue-800 rounded-lg hover:bg-blue-50 transition-colors" title="Lihat Desain & Cetak Kartu">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>

                                @if($card->is_sold)
                                <!-- Terkunci Permanen karena Sudah Terjual -->
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-slate-100 text-slate-400 text-xs font-medium cursor-not-allowed select-none" title="Kartu sudah berstatus Terjual & terkunci permanen">
                                    <i class="fa-solid fa-lock text-[10px]"></i>
                                    <span>Terkunci</span>
                                </span>
                                @else
                                <!-- Tandai Terjual & Kunci -->
                                <button type="button" @click="openSoldModal('{{ $card->serial_number }}', '{{ addslashes($card->business_name ?? $card->customer_name ?? '') }}', '{{ route('admin.review_cards.mark_sold', $card->id) }}')" class="p-1.5 text-slate-400 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors" title="Tandai Terjual (Kunci Permanen)">
                                    <i class="fa-solid fa-cart-shopping text-xs"></i>
                                </button>

                                <!-- Quick Toggle Status -->
                                <form action="{{ route('admin.review_cards.toggle_status', $card->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-amber-600 rounded-lg hover:bg-slate-100 transition-colors" title="Ubah Status Aktif/Nonaktif">
                                        <i class="fa-solid fa-power-off text-xs"></i>
                                    </button>
                                </form>

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
                                @endif
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

    <!-- Modal Konfirmasi Tandai Terjual & Kunci Permanen -->
    <div x-show="soldModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(15, 23, 42, 0.65);">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div @click.away="soldModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transition-all">

                {{-- Header --}}
                <div class="flex items-start justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base leading-tight">Tandai Kartu Terjual</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Konfirmasi penguncian permanen unit fisik</p>
                        </div>
                    </div>
                    <button @click="soldModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                {{-- Detail Kartu --}}
                <div class="mt-4 p-4 bg-slate-50/80 rounded-xl border border-slate-200/60 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Serial Number</span>
                        <span class="font-mono font-bold text-slate-800 bg-white px-2 py-0.5 rounded border border-slate-200" x-text="soldCard.serial_number"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Pemilik / Bisnis</span>
                        <span class="font-semibold text-slate-700 text-right truncate max-w-[200px]" x-text="soldCard.customer_name"></span>
                    </div>
                </div>

                {{-- Warning Box --}}
                <div class="mt-4 p-3.5 bg-amber-50/90 border border-amber-200/80 rounded-xl flex items-start gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-amber-600 text-sm mt-0.5 shrink-0"></i>
                    <div class="text-xs text-amber-900 leading-relaxed">
                        <p class="font-bold text-amber-950 mb-0.5">Peringatan: Kunci Permanen</p>
                        <p>Setelah ditandai <strong>Terjual</strong>, kartu akan berstatus terkunci dan <strong>tidak dapat diedit atau dihapus lagi</strong> demi menjaga validitas komisi &amp; data kepemilikan.</p>
                    </div>
                </div>

                {{-- Form Actions --}}
                <form :action="soldCard.actionUrl" method="POST" class="mt-6 flex items-center justify-end gap-2.5">
                    @csrf
                    <button type="button" @click="soldModal = false" class="px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2.5 text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-95 rounded-xl shadow-sm shadow-emerald-500/20 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-lock text-xs"></i>
                        <span>Ya, Tandai &amp; Kunci</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Verifikasi Pembayaran QRIS -->
    <div x-show="verifyOrderModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(15, 23, 42, 0.65);">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div @click.away="verifyOrderModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transition-all text-left">

                {{-- Header --}}
                <div class="flex items-start justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-shield-check"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base leading-tight">Verifikasi Pembayaran QRIS</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Aktivasi unit stok kartu partner</p>
                        </div>
                    </div>
                    <button @click="verifyOrderModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                {{-- Detail Pesanan --}}
                <div class="mt-4 p-4 bg-slate-50/80 rounded-xl border border-slate-200/60 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">ID Pesanan</span>
                        <span class="font-mono font-bold text-slate-800 bg-white px-2 py-0.5 rounded border border-slate-200" x-text="'#' + selectedOrder.order_id"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Partner</span>
                        <span class="font-semibold text-slate-700 truncate max-w-[200px]" x-text="selectedOrder.partner"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Jumlah Unit</span>
                        <span class="font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200" x-text="selectedOrder.qty + ' Unit Kartu'"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-200/80">
                        <span class="text-slate-500 font-medium">Total Dana Masuk</span>
                        <span class="font-mono font-bold text-emerald-600 text-sm" x-text="selectedOrder.amount"></span>
                    </div>
                </div>

                {{-- Info Box --}}
                <div class="mt-4 p-3.5 bg-emerald-50/90 border border-emerald-200/80 rounded-xl flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-emerald-600 text-sm mt-0.5 shrink-0"></i>
                    <div class="text-xs text-emerald-900 leading-relaxed">
                        <p class="font-bold text-emerald-950 mb-0.5">Konfirmasi Dana</p>
                        <p>Pastikan dana QRIS sebesar <strong x-text="selectedOrder.amount"></strong> sudah masuk ke mutasi rekening/dashboard Scalify Pay. Setelah diverifikasi, unit kartu akan langsung aktif di dashboard partner.</p>
                    </div>
                </div>

                {{-- Form Actions --}}
                <form :action="selectedOrder.actionUrl" method="POST" class="mt-6 flex items-center justify-end gap-2.5">
                    @csrf
                    <button type="button" @click="verifyOrderModal = false" class="px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2.5 text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 active:scale-95 rounded-xl shadow-sm shadow-emerald-500/20 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-check text-xs"></i>
                        <span>Ya, Verifikasi &amp; Aktifkan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Batalkan Pesanan QRIS -->
    <div x-show="cancelOrderModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(15, 23, 42, 0.65);">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div @click.away="cancelOrderModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transition-all text-left">

                {{-- Header --}}
                <div class="flex items-start justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg font-bold shrink-0">
                            <i class="fa-solid fa-trash-can"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base leading-tight">Batalkan Pesanan QRIS</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Penghapusan reservasi stok partner</p>
                        </div>
                    </div>
                    <button @click="cancelOrderModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                {{-- Detail Pesanan --}}
                <div class="mt-4 p-4 bg-slate-50/80 rounded-xl border border-slate-200/60 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">ID Pesanan</span>
                        <span class="font-mono font-bold text-slate-800 bg-white px-2 py-0.5 rounded border border-slate-200" x-text="'#' + selectedOrder.order_id"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Partner</span>
                        <span class="font-semibold text-slate-700 truncate max-w-[200px]" x-text="selectedOrder.partner"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium">Jumlah Unit yang Dihapus</span>
                        <span class="font-bold text-red-700 bg-red-50 px-2 py-0.5 rounded border border-red-200" x-text="selectedOrder.qty + ' Unit Kartu'"></span>
                    </div>
                </div>

                {{-- Warning Box --}}
                <div class="mt-4 p-3.5 bg-red-50/90 border border-red-200/80 rounded-xl flex items-start gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-sm mt-0.5 shrink-0"></i>
                    <div class="text-xs text-red-900 leading-relaxed">
                        <p class="font-bold text-red-950 mb-0.5">Peringatan Pembatalan</p>
                        <p>Pesanan QRIS ini akan dibatalkan permanen. Seluruh nomor serial kartu cadangan yang sudah di-reserve akan dihapus dari sistem.</p>
                    </div>
                </div>

                {{-- Form Actions --}}
                <form :action="selectedOrder.actionUrl" method="POST" class="mt-6 flex items-center justify-end gap-2.5">
                    @csrf
                    <button type="button" @click="cancelOrderModal = false" class="px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors">
                        Kembali
                    </button>
                    <button type="submit" class="px-4 py-2.5 text-xs sm:text-sm font-bold text-white bg-red-600 hover:bg-red-700 active:scale-95 rounded-xl shadow-sm shadow-red-500/20 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-xmark text-xs"></i>
                        <span>Ya, Batalkan Pesanan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
