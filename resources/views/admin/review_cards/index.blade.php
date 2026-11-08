@extends('layouts.admin.app')

@section('content')
<div x-data="{
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
    },
    toast(msg, type = 'success') {
        window.toast(type, msg); // toast standar admin (layouts/admin/toast)
    },
    copyText(text) {
        navigator.clipboard.writeText(text).then(() => {
            this.toast('Link scan berhasil disalin!');
        });
    }
}">

    {{-- Page Header --}}
    <x-admin.page-header title="Google Review Cards" subtitle="Kelola unit fisik stiker & kartu QR tap review untuk pelanggan Scalify.">
        <x-admin.button type="button" variant="secondary" icon="fa-solid fa-layer-group" @click="batchModal = true">
            Generate Batch (Cetak)
        </x-admin.button>
        <x-admin.button variant="secondary" icon="fa-solid fa-chart-line" :href="route('admin.review_cards.analytics')">
            Analitik
        </x-admin.button>
        <x-admin.button icon="fa-solid fa-plus" :href="route('admin.review_cards.create')">
            Tambah Kartu
        </x-admin.button>
    </x-admin.page-header>

    {{-- 4 Quick Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0 text-sm">
                <i class="fa-solid fa-qrcode"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Kartu</p>
                <p class="text-lg font-bold text-slate-900 mt-0.5">{{ number_format($stats->total ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0 text-sm">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-emerald-700 uppercase tracking-wider">Terjual</p>
                <p class="text-lg font-bold text-emerald-600 mt-0.5">{{ number_format($stats->sold ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center shrink-0 text-sm">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-amber-700 uppercase tracking-wider">Belum Terjual</p>
                <p class="text-lg font-bold text-amber-600 mt-0.5">{{ number_format($stats->unsold ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center shrink-0 text-sm">
                <i class="fa-solid fa-chart-simple"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-purple-700 uppercase tracking-wider">Total Scan Review</p>
                <p class="text-lg font-bold text-purple-600 mt-0.5">{{ number_format($stats->total_scans ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Pesanan QRIS Partner Menunggu Verifikasi --}}
    @if(!empty($pendingOrders))
    <div class="bg-amber-50/70 border border-amber-200 rounded-2xl p-5 mb-6 shadow-xs overflow-hidden relative">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-sm shrink-0">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Menunggu Verifikasi Pembayaran QRIS ({{ count($pendingOrders) }} Pesanan)</h2>
                    <p class="text-xs text-slate-500">Partner telah melakukan transfer QRIS. Klik verifikasi jika dana sudah masuk untuk menyerahkan kuota kartu.</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800 border border-amber-200/80 w-fit">
                Perlu Tindakan
            </span>
        </div>

        <div class="space-y-2.5">
            @foreach($pendingOrders as $order)
            <div class="bg-white rounded-xl p-3.5 border border-slate-200/80 flex flex-col md:flex-row md:items-center justify-between gap-3 shadow-xs">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-sm text-slate-900 font-mono">#{{ $order['order_id'] ?? '' }}</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200/70">
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
                    <x-admin.button type="button" size="sm" icon="fa-solid fa-check" @click="openVerifyModal('{{ $order['order_id'] }}', '{{ addslashes($order['partner_name'] ?? '-') }}', '{{ $order['quantity'] ?? 1 }}', 'Rp {{ number_format($order['total_amount'] ?? 0, 0, ',', '.') }}', '{{ route('admin.review_cards.verify_order', $order['order_id']) }}')">
                        Verifikasi & Aktifkan
                    </x-admin.button>

                    <x-admin.button type="button" variant="secondary" size="sm" icon="fa-solid fa-xmark" @click="openCancelModal('{{ $order['order_id'] }}', '{{ addslashes($order['partner_name'] ?? '-') }}', '{{ $order['quantity'] ?? 1 }}', 'Rp {{ number_format($order['total_amount'] ?? 0, 0, ',', '.') }}', '{{ route('admin.review_cards.cancel_order', $order['order_id']) }}')">
                        Batalkan
                    </x-admin.button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Main Table Card --}}
    <x-admin.card :padding="false">
        {{-- Toolbar Filter & Pencarian --}}
        <form method="GET" action="{{ route('admin.review_cards.index') }}" class="flex flex-col sm:flex-row gap-2.5 p-4 border-b border-slate-200">
            <div class="relative flex-1 sm:max-w-sm">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                <x-admin.input name="q" :value="request('q') ?? request('search')" placeholder="Cari serial, nama usaha, atau slug..." class="pl-9" />
            </div>

            <div class="sm:w-48">
                <x-admin.select name="status" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Terjual</option>
                    <option value="unsold" {{ request('status') === 'unsold' ? 'selected' : '' }}>Belum Terjual</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending (Gudang)</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif (Toko)</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </x-admin.select>
            </div>

            <div class="flex gap-2">
                <x-admin.button type="submit" variant="secondary">Filter</x-admin.button>
                @if(request('q') || request('search') || request('status'))
                <x-admin.button variant="secondary" icon="fa-solid fa-xmark" :href="route('admin.review_cards.index')">Reset</x-admin.button>
                @endif
            </div>
        </form>

        {{-- Table List --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3 w-12">#</th>
                        <th class="px-4 py-3">Serial & PIN</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Bisnis & Google Review</th>
                        <th class="px-4 py-3">URL Scan (QR / NFC)</th>
                        <th class="px-4 py-3 text-center">Scan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($cards as $card)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-4 py-3 text-slate-400">{{ $cards->firstItem() + $loop->index }}</td>

                        {{-- Serial & PIN --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-mono font-bold text-slate-900 text-xs tracking-wide">
                                {{ $card->serial_number }}
                            </div>
                            <div class="text-[11px] text-slate-400 mt-0.5">
                                PIN: <span class="font-mono text-slate-700 font-semibold">{{ $card->activation_code }}</span>
                            </div>
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($card->is_sold)
                            <x-admin.badge color="green">
                                <i class="fa-solid fa-lock text-[10px]"></i> Terjual
                            </x-admin.badge>
                            @elseif($card->status === 'active')
                            <x-admin.badge color="blue">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> Aktif
                            </x-admin.badge>
                            @elseif($card->status === 'pending')
                            <x-admin.badge color="yellow">
                                <i class="fa-solid fa-clock text-[10px]"></i> Belum Aktif
                            </x-admin.badge>
                            @else
                            <x-admin.badge color="slate">
                                <i class="fa-solid fa-circle-xmark text-[10px]"></i> Nonaktif
                            </x-admin.badge>
                            @endif
                        </td>

                        {{-- Bisnis & Google Review --}}
                        <td class="px-4 py-3 max-w-xs">
                            @if($card->business_name)
                            <span class="font-medium text-slate-900 block truncate" title="{{ $card->business_name }}">
                                {{ $card->business_name }}
                            </span>
                            @if($card->google_review_url)
                            <a href="{{ $card->google_review_url }}" target="_blank" rel="noopener noreferrer" class="text-xs text-blue-600 hover:underline inline-flex items-center gap-1 mt-0.5 truncate max-w-xs">
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                <span>Lihat Review Maps</span>
                            </a>
                            @endif
                            @else
                            <span class="text-slate-400 text-xs italic">Belum diklaim</span>
                            @endif
                        </td>

                        {{-- URL Scan --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php $scanUrl = url('/r/' . $card->slug); @endphp
                            <div class="flex items-center gap-1.5">
                                <a href="{{ $scanUrl }}" target="_blank" class="font-mono text-xs text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200/70 hover:bg-blue-100 transition">
                                    /r/{{ $card->slug }}
                                </a>
                                <button type="button" @click="copyText('{{ $scanUrl }}')" class="text-slate-400 hover:text-slate-600 p-1" title="Salin URL Scan">
                                    <i class="fa-regular fa-copy text-xs"></i>
                                </button>
                            </div>
                        </td>

                        {{-- Counter Scan --}}
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-700">
                                {{ number_format($card->total_scans) }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-3 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                {{-- Lihat Desain & Template Cetak --}}
                                <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-eye" :href="route('admin.review_cards.show', $card->id)" title="Desain & Cetak" />

                                @if($card->is_sold)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-400 text-xs font-medium cursor-not-allowed select-none" title="Kartu sudah terjual & terkunci">
                                    <i class="fa-solid fa-lock text-[10px]"></i> Terkunci
                                </span>
                                @else
                                {{-- Tandai Terjual & Kunci --}}
                                <x-admin.button type="button" variant="secondary" size="sm" icon="fa-solid fa-cart-shopping" @click="openSoldModal('{{ $card->serial_number }}', '{{ addslashes($card->business_name ?? $card->owner_name ?? '') }}', '{{ route('admin.review_cards.mark_sold', $card->id) }}')" title="Tandai Terjual" />

                                {{-- Quick Toggle Status --}}
                                <form action="{{ route('admin.review_cards.toggle_status', $card->id) }}" method="POST" class="inline">
                                    @csrf
                                    <x-admin.button type="submit" variant="secondary" size="sm" icon="fa-solid fa-power-off" title="Ubah Status Aktif/Nonaktif" />
                                </form>

                                {{-- Edit --}}
                                <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-pen" :href="route('admin.review_cards.edit', $card->id)" title="Edit Kartu" />

                                {{-- Delete --}}
                                <form action="{{ route('admin.review_cards.destroy', $card->id) }}" method="POST" class="inline" data-confirm="Apakah Anda yakin ingin menghapus kartu {{ $card->serial_number }}?" data-confirm-danger>
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.button type="submit" variant="danger" size="sm" icon="fa-solid fa-trash-can" title="Hapus" aria-label="Hapus" />
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-qrcode text-xl"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-700">
                                {{ request('q') || request('search') || request('status') ? 'Tidak ada kartu yang cocok dengan filter.' : 'Belum ada Review Card yang terdaftar.' }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">
                                {{ request('q') || request('search') || request('status') ? 'Coba ganti kata kunci pencarian atau reset filter.' : 'Gunakan tombol Generate Batch untuk membuat unit siap cetak massal.' }}
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        {{-- HP: kartu --}}
        <div class="md:hidden divide-y divide-slate-100">
            @forelse($cards as $card)
            @php $scanUrl = url('/r/' . $card->slug); @endphp
            <div class="p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-mono text-xs font-bold text-slate-900">{{ $card->serial_number }}</p>
                        <p class="text-[11px] text-slate-400">PIN <span class="font-mono font-semibold text-slate-700">{{ $card->activation_code }}</span> · {{ number_format($card->total_scans) }} scan</p>
                    </div>
                    @if($card->is_sold)
                    <x-admin.badge color="green">Terjual</x-admin.badge>
                    @elseif($card->status === 'active')
                    <x-admin.badge color="blue">Aktif</x-admin.badge>
                    @elseif($card->status === 'pending')
                    <x-admin.badge color="yellow">Belum Aktif</x-admin.badge>
                    @else
                    <x-admin.badge color="slate">Nonaktif</x-admin.badge>
                    @endif
                </div>
                <p class="mt-2 text-sm {{ $card->business_name ? 'font-medium text-slate-900' : 'italic text-slate-400' }} truncate">{{ $card->business_name ?: 'Belum diklaim' }}</p>
                <button type="button" @click="copyText('{{ $scanUrl }}')" class="mt-1 font-mono text-xs text-blue-700"><i class="fa-regular fa-copy mr-1"></i>/r/{{ $card->slug }}</button>
                <div class="mt-3 grid {{ $card->is_sold ? 'grid-cols-1' : 'grid-cols-3' }} gap-2">
                    <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-eye" class="w-full justify-center" :href="route('admin.review_cards.show', $card->id)">Desain</x-admin.button>
                    @unless($card->is_sold)
                    <x-admin.button type="button" variant="secondary" size="sm" icon="fa-solid fa-cart-shopping" class="w-full justify-center" @click="openSoldModal('{{ $card->serial_number }}', '{{ addslashes($card->business_name ?? $card->owner_name ?? '') }}', '{{ route('admin.review_cards.mark_sold', $card->id) }}')">Terjual</x-admin.button>
                    <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-pen" class="w-full justify-center" :href="route('admin.review_cards.edit', $card->id)">Edit</x-admin.button>
                    @endunless
                </div>
            </div>
            @empty
            <div class="px-4 py-12 text-center text-sm text-slate-500">
                {{ request('q') || request('search') || request('status') ? 'Tidak ada kartu yang cocok dengan filter.' : 'Belum ada Review Card yang terdaftar.' }}
            </div>
            @endforelse
        </div>

        @if($cards->hasPages())
        <div class="px-4 py-3 border-t border-slate-200">
            {{ $cards->links('pagination::tailwind') }}
        </div>
        @endif
    </x-admin.card>

    {{-- Modal Generate Batch Cetak Massal --}}
    <div x-show="batchModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="batchModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div class="min-h-full p-4 flex items-center justify-center">
            <div x-show="batchModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.away="batchModal = false"
                class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-6 z-10">

                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-layer-group text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Generate Batch Cetak</h3>
                            <p class="text-xs text-slate-400">Buat serial kartu massal siap cetak.</p>
                        </div>
                    </div>
                    <button type="button" @click="batchModal = false" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <form action="{{ route('admin.review_cards.batch_generate') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-admin.label for="batchQty" required>Jumlah Unit Kartu/Stiker</x-admin.label>
                        <x-admin.input type="number" name="quantity" id="batchQty" min="1" max="100" value="10" required />
                        <x-admin.hint for="quantity">Maksimal 100 unit per sekali generate.</x-admin.hint>
                    </div>

                    <div>
                        <x-admin.label for="batchPrefix">Prefix Serial Number</x-admin.label>
                        <x-admin.input name="prefix" id="batchPrefix" value="SCL" class="font-mono uppercase" />
                        <x-admin.hint for="prefix">Format: SCL-YYMM-XXXX</x-admin.hint>
                    </div>

                    <div>
                        <x-admin.label for="batchNotes">Catatan Batch (Opsional)</x-admin.label>
                        <x-admin.input name="notes" id="batchNotes" placeholder="Contoh: Batch Cetak Vendor A 100 Pcs" />
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                        <x-admin.button type="button" variant="secondary" @click="batchModal = false">Batal</x-admin.button>
                        <x-admin.button type="submit" icon="fa-solid fa-bolt">Generate Sekarang</x-admin.button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Tandai Terjual & Kunci Permanen --}}
    <div x-show="soldModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="soldModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div class="min-h-full p-4 flex items-center justify-center">
            <div x-show="soldModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.away="soldModal = false"
                class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-6 z-10">

                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="fa-solid fa-cart-shopping text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Tandai Kartu Terjual</h3>
                            <p class="text-xs text-slate-400">Konfirmasi penguncian permanen unit fisik.</p>
                        </div>
                    </div>
                    <button type="button" @click="soldModal = false" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 space-y-2 mb-4 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Serial Number:</span>
                        <span class="font-mono font-bold text-slate-900" x-text="soldCard.serial_number"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Pemilik / Bisnis:</span>
                        <span class="font-semibold text-slate-700 truncate max-w-[200px]" x-text="soldCard.customer_name"></span>
                    </div>
                </div>

                <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 leading-relaxed mb-4">
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-amber-600 mt-0.5"></i>
                        <div>
                            <p class="font-bold text-amber-900">Peringatan Kunci Permanen</p>
                            <p class="mt-0.5 text-amber-700">Setelah ditandai <b>Terjual</b>, kartu akan berstatus terkunci dan tidak dapat diedit atau dihapus lagi demi menjaga integritas data.</p>
                        </div>
                    </div>
                </div>

                <form :action="soldCard.actionUrl" method="POST" class="flex items-center justify-end gap-2 pt-2">
                    @csrf
                    <x-admin.button type="button" variant="secondary" @click="soldModal = false">Batal</x-admin.button>
                    <x-admin.button type="submit" icon="fa-solid fa-lock">Ya, Tandai & Kunci</x-admin.button>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Verifikasi Pembayaran QRIS --}}
    <div x-show="verifyOrderModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="verifyOrderModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div class="min-h-full p-4 flex items-center justify-center">
            <div x-show="verifyOrderModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.away="verifyOrderModal = false"
                class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-6 z-10">

                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="fa-solid fa-shield-check text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Verifikasi Pembayaran QRIS</h3>
                            <p class="text-xs text-slate-400">Aktivasi unit stok kartu partner.</p>
                        </div>
                    </div>
                    <button type="button" @click="verifyOrderModal = false" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 space-y-2 mb-4 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">ID Pesanan:</span>
                        <span class="font-mono font-bold text-slate-900" x-text="'#' + selectedOrder.order_id"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Partner:</span>
                        <span class="font-semibold text-slate-700 truncate max-w-[200px]" x-text="selectedOrder.partner"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Jumlah Unit:</span>
                        <span class="font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200" x-text="selectedOrder.qty + ' Unit Kartu'"></span>
                    </div>
                    <div class="flex items-center justify-between pt-1 border-t border-slate-200">
                        <span class="text-slate-500">Total Dana Masuk:</span>
                        <span class="font-mono font-bold text-emerald-600 text-sm" x-text="selectedOrder.amount"></span>
                    </div>
                </div>

                <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 leading-relaxed mb-4">
                    <p class="font-bold text-emerald-950 mb-0.5">Konfirmasi Dana</p>
                    <p class="text-emerald-700">Pastikan dana QRIS sebesar <strong x-text="selectedOrder.amount"></strong> sudah masuk ke mutasi rekening/dashboard Scalify Pay. Unit kartu akan langsung aktif di dashboard partner.</p>
                </div>

                <form :action="selectedOrder.actionUrl" method="POST" class="flex items-center justify-end gap-2 pt-2">
                    @csrf
                    <x-admin.button type="button" variant="secondary" @click="verifyOrderModal = false">Batal</x-admin.button>
                    <x-admin.button type="submit" icon="fa-solid fa-check">Ya, Verifikasi & Aktifkan</x-admin.button>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Batalkan Pesanan QRIS --}}
    <div x-show="cancelOrderModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div x-show="cancelOrderModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div class="min-h-full p-4 flex items-center justify-center">
            <div x-show="cancelOrderModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.away="cancelOrderModal = false"
                class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-6 z-10">

                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Batalkan Pesanan QRIS</h3>
                            <p class="text-xs text-slate-400">Penghapusan reservasi stok partner.</p>
                        </div>
                    </div>
                    <button type="button" @click="cancelOrderModal = false" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 space-y-2 mb-4 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">ID Pesanan:</span>
                        <span class="font-mono font-bold text-slate-900" x-text="'#' + selectedOrder.order_id"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Partner:</span>
                        <span class="font-semibold text-slate-700 truncate max-w-[200px]" x-text="selectedOrder.partner"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Jumlah Unit Dihapus:</span>
                        <span class="font-bold text-red-700 bg-red-50 px-2 py-0.5 rounded border border-red-200" x-text="selectedOrder.qty + ' Unit Kartu'"></span>
                    </div>
                </div>

                <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-800 leading-relaxed mb-4">
                    <p class="font-bold text-rose-950 mb-0.5">Peringatan Pembatalan</p>
                    <p class="text-rose-700">Pesanan QRIS ini akan dibatalkan secara permanen. Seluruh nomor serial kartu cadangan yang sudah di-reserve akan dihapus dari sistem.</p>
                </div>

                <form :action="selectedOrder.actionUrl" method="POST" class="flex items-center justify-end gap-2 pt-2">
                    @csrf
                    <x-admin.button type="button" variant="secondary" @click="cancelOrderModal = false">Kembali</x-admin.button>
                    <x-admin.button type="submit" variant="danger" icon="fa-solid fa-xmark">Ya, Batalkan Pesanan</x-admin.button>
                </form>
            </div>
        </div>
    </div>


</div>
@endsection
