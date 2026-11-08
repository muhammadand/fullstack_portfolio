@extends('layouts.admin.app')

@section('content')
<div class="" x-data="travelBookingManager()">

    <x-admin.page-header title="Pesanan Travel & Shuttle" subtitle="Tiket shuttle Ciamis - Bandung, sewa mobil (charter), dan verifikasi pembayaran.">
        <x-admin.button variant="secondary" icon="fa-solid fa-arrow-up-right-from-square" :href="route('travell.index')" target="_blank">Buka Web Travel</x-admin.button>
    </x-admin.page-header>

    <!-- Dashboard Stats Grid (Soft & Clean) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 lg:gap-4 mb-5 lg:mb-6">
        <x-admin.stat label="Total Pesanan" :value="$stats->total ?? 0" icon="fa-solid fa-receipt" tone="blue" />
        <x-admin.stat label="Sedang Diproses" :value="$stats->pending ?? 0" icon="fa-solid fa-hourglass-half" tone="amber" />
        <x-admin.stat label="Terkonfirmasi" :value="$stats->confirmed ?? 0" icon="fa-solid fa-circle-check" tone="emerald" />
        <x-admin.stat label="Omzet Lunas" :value="$stats->total_revenue ?? 0" rupiah icon="fa-solid fa-wallet" tone="indigo" />
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-5 lg:mb-6">
        <x-admin.filter-bar :action="route('admin.travel_bookings.index')" :value="$search ?? ''" placeholder="Cari kode booking, nama, no. HP..." :bordered="false"
            :active="(int) filled($status ?? null) + (int) filled($type ?? null) + (int) filled($date ?? null)" :reset="route('admin.travel_bookings.index')">
            <x-admin.select name="status" class="lg:w-44">
                <option value="">Semua Status</option>
                <option value="pending" @selected(($status ?? '') === 'pending')>Diproses</option>
                <option value="confirmed" @selected(($status ?? '') === 'confirmed')>Terkonfirmasi</option>
                <option value="completed" @selected(($status ?? '') === 'completed')>Selesai</option>
                <option value="cancelled" @selected(($status ?? '') === 'cancelled')>Dibatalkan</option>
            </x-admin.select>
            <x-admin.select name="type" class="lg:w-44">
                <option value="">Semua Layanan</option>
                <option value="reguler" @selected(($type ?? '') === 'reguler')>Shuttle Reguler</option>
                <option value="charter" @selected(($type ?? '') === 'charter')>Charter</option>
            </x-admin.select>
            <x-admin.input name="date" type="date" :value="$date ?? ''" class="col-span-2 lg:w-40" />
        </x-admin.filter-bar>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode & Waktu</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Rute & Titik Jemput</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jadwal & Kursi</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Tagihan</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm">
                    @forelse($bookings as $b)
                    @php
                    $isCharter = $b->booking_type === 'charter';
                    $sched = $b->schedule;
                    $origin = $sched ? ($sched->route->origin ?? 'Ciamis') : 'Ciamis';
                    $dest = $sched ? ($sched->route->destination ?? 'Bandung') : ($b->destination_note ?? 'Bandung');
                    $depTime = $sched ? \Carbon\Carbon::parse($sched->departure_time)->format('H:i') . ' WIB' : '08:00 WIB';
                    $depDate = $isCharter
                    ? ($b->charter_date ? \Carbon\Carbon::parse($b->charter_date)->format('d M Y') : '-')
                    : ($sched && $sched->departure_date ? \Carbon\Carbon::parse($sched->departure_date)->format('d M Y') : '-');

                    $seatList = $b->details ? $b->details->where('item_type', 'seat')->pluck('seat_number')->filter()->implode(', ') : null;
                    if (empty(trim((string)$seatList))) {
                    $seatList = $isCharter ? 'Sewa 1 Unit Mobil' : ($b->total_passengers ? $b->total_passengers . ' Kursi' : '1 Unit');
                    }

                    $cleanPhone = preg_replace('/[^0-9]/', '', $b->customer->phone ?? '');
                    if (str_starts_with($cleanPhone, '0')) {
                    $waPhone = '62' . substr($cleanPhone, 1);
                    } else {
                    $waPhone = $cleanPhone;
                    }
                    $waText = "Halo Kak {$b->customer->name}, kami dari tim Rivian Travel terkait pemesanan tiket shuttle {$b->booking_code} ({$origin} - {$dest}). Apakah ada informasi titik penjemputan yang ingin dipastikan?";
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- Kode & Waktu -->
                        <td class="px-5 py-4 align-top">
                            <div class="font-mono font-bold text-slate-800 text-xs">#{{ $b->booking_code }}</div>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="px-1.5 py-0.5 rounded text-[10px] font-medium {{ $isCharter ? 'bg-purple-50 text-purple-700 border border-purple-200/80' : 'bg-blue-50 text-blue-700 border border-blue-200/80' }}">
                                    {{ $isCharter ? 'Charter' : 'Shuttle' }}
                                </span>
                                <span class="text-xs text-slate-400">
                                    {{ $b->created_at ? $b->created_at->diffForHumans() : '-' }}
                                </span>
                            </div>
                        </td>

                        <!-- Pelanggan -->
                        <td class="px-5 py-4 align-top">
                            <div class="font-bold text-slate-800 text-sm">{{ $b->customer->name ?? 'Tamu' }}</div>
                            <div class="text-xs text-slate-500 font-mono mt-0.5">{{ $b->customer->phone ?? '-' }}</div>
                            @if(!empty($cleanPhone))
                            <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode($waText) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-emerald-600 hover:text-emerald-700 font-medium mt-1">
                                <i class="fab fa-whatsapp"></i>
                                <span>Chat WA</span>
                            </a>
                            @endif
                        </td>

                        <!-- Rute & Titik Jemput -->
                        <td class="px-5 py-4 align-top">
                            <div class="font-semibold text-slate-800 text-xs flex items-center gap-1.5">
                                <span>{{ $origin }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px] text-slate-400"></i>
                                <span>{{ $dest }}</span>
                            </div>
                            <div class="text-xs text-slate-500 mt-1 line-clamp-1" title="{{ $b->pickup_address }}">
                                <span class="text-slate-400">Jemput:</span> {{ Str::limit($b->pickup_address ?? 'Pool Kantor', 32) }}
                            </div>
                            <div class="text-xs text-slate-500 mt-0.5 line-clamp-1" title="{{ $b->dropoff_address }}">
                                <span class="text-slate-400">Antar:</span> {{ Str::limit($b->dropoff_address ?? 'Pool Tujuan', 32) }}
                            </div>
                        </td>

                        <!-- Jadwal & Kursi -->
                        <td class="px-5 py-4 align-top">
                            <div class="font-medium text-slate-800 text-xs">{{ $depDate }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $depTime }}</div>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $seatList }}
                            </span>
                        </td>

                        <!-- Total Biaya & Bayar -->
                        <td class="px-5 py-4 align-top">
                            <div class="font-bold text-slate-800 text-sm font-mono">Rp {{ number_format($b->total_amount ?? 0, 0, ',', '.') }}</div>
                            <div class="mt-1">
                                @if($b->payment_status === 'paid')
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Lunas
                                </span>
                                @elseif($b->payment_status === 'refunded')
                                <span class="inline-flex items-center text-xs font-medium text-purple-600">
                                    Refund
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-600">
                                    <i class="fa-solid fa-clock text-[10px]"></i> Belum Bayar
                                </span>
                                @endif
                            </div>
                        </td>

                        <!-- Status Pesanan (Soft Pills) -->
                        <td class="px-5 py-4 align-top">
                            @if($b->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200/80">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Diproses
                            </span>
                            @elseif($b->status === 'confirmed')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Terkonfirmasi
                            </span>
                            @elseif($b->status === 'completed')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200/80">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                Selesai
                            </span>
                            @elseif($b->status === 'cancelled')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200/80">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Batal
                            </span>
                            @endif
                        </td>

                        <!-- Aksi (Subtle & Soft) -->
                        <td class="px-5 py-4 align-top text-right">
                            <div class="flex items-center justify-end gap-1">
                                @if($b->payment_status !== 'paid' || $b->status === 'pending')
                                <form action="{{ route('admin.travel_bookings.verify_payment', $b->id) }}" method="POST" data-confirm="Verifikasi pembayaran pesanan #{{ $b->booking_code }}?">
                                    @csrf
                                    <button type="submit" class="p-1.5 text-emerald-600 hover:text-emerald-800 hover:bg-emerald-50 rounded-lg transition-colors" title="Verifikasi Lunas & Konfirmasi">
                                        <i class="fa-solid fa-check text-sm"></i>
                                    </button>
                                </form>
                                @endif

                                <button type="button" @click="openEditModal({{ json_encode($b) }})" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail & Ubah Status">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>

                                <form action="{{ route('admin.travel_bookings.destroy', $b->id) }}" method="POST" data-confirm="Hapus pesanan #{{ $b->booking_code }}?" data-confirm-danger>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-slate-500">
                            Belum ada data pesanan travel yang sesuai filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- HP: kartu --}}
        <div class="md:hidden divide-y divide-slate-100">
            @forelse($bookings as $b)
            @php
                $isCharter = $b->booking_type === 'charter';
                $sched = $b->schedule;
                $origin = $sched ? ($sched->route->origin ?? 'Ciamis') : 'Ciamis';
                $dest = $sched ? ($sched->route->destination ?? 'Bandung') : ($b->destination_note ?? 'Bandung');
                $depDate = $isCharter
                    ? ($b->charter_date ? \Carbon\Carbon::parse($b->charter_date)->format('d M Y') : '-')
                    : ($sched && $sched->departure_date ? \Carbon\Carbon::parse($sched->departure_date)->format('d M Y') : '-');
                $depTime = $sched ? \Carbon\Carbon::parse($sched->departure_time)->format('H:i') . ' WIB' : '';
                $phone = preg_replace('/[^0-9]/', '', $b->customer->phone ?? '');
                $wa = str_starts_with($phone, '0') ? '62' . substr($phone, 1) : $phone;
                $statusMap = ['pending' => ['Diproses', 'yellow'], 'confirmed' => ['Terkonfirmasi', 'green'], 'completed' => ['Selesai', 'blue'], 'cancelled' => ['Batal', 'red']];
                [$stLabel, $stColor] = $statusMap[$b->status] ?? [ucfirst((string) $b->status), 'slate'];
            @endphp
            <div class="p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-mono text-xs font-bold text-slate-800">#{{ $b->booking_code }} <span class="font-sans font-medium text-slate-400">· {{ $isCharter ? 'Charter' : 'Shuttle' }}</span></p>
                        <p class="mt-0.5 font-semibold text-slate-900 truncate">{{ $b->customer->name ?? 'Tamu' }}</p>
                    </div>
                    <x-admin.badge :color="$stColor">{{ $stLabel }}</x-admin.badge>
                </div>
                <p class="mt-2 text-sm font-medium text-slate-800">{{ $origin }} <i class="fa-solid fa-arrow-right text-[10px] text-slate-400 mx-1"></i> {{ $dest }}</p>
                <p class="text-xs text-slate-500">{{ $depDate }} {{ $depTime }} · {{ $b->total_passengers ?: 1 }} penumpang</p>
                <div class="mt-2 flex items-center justify-between text-xs">
                    <span class="{{ $b->payment_status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }} font-medium">{{ $b->payment_status === 'paid' ? 'Lunas' : ($b->payment_status === 'refunded' ? 'Refund' : 'Belum Bayar') }}</span>
                    <span class="font-mono font-bold text-slate-900">Rp {{ number_format($b->total_amount ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="mt-3 grid grid-cols-3 gap-2">
                    @if($b->payment_status !== 'paid' || $b->status === 'pending')
                    <form action="{{ route('admin.travel_bookings.verify_payment', $b->id) }}" method="POST" data-confirm="Verifikasi pembayaran pesanan #{{ $b->booking_code }}?">
                        @csrf
                        <button type="submit" class="w-full py-2 rounded-lg bg-emerald-600 text-white text-xs font-semibold"><i class="fa-solid fa-check mr-1"></i>Lunas</button>
                    </form>
                    @endif
                    @if($wa)
                    <a href="https://wa.me/{{ $wa }}" target="_blank" class="py-2 rounded-lg border border-emerald-200 text-emerald-700 text-xs font-semibold text-center"><i class="fab fa-whatsapp mr-1"></i>WA</a>
                    @endif
                    <button type="button" @click="openEditModal({{ json_encode($b) }})" class="py-2 rounded-lg border border-slate-200 text-slate-700 text-xs font-semibold"><i class="fa-solid fa-pen-to-square mr-1"></i>Detail</button>
                </div>
            </div>
            @empty
            <div class="px-4 py-10 text-center text-sm text-slate-500">Belum ada data pesanan travel yang sesuai filter.</div>
            @endforelse
        </div>

        @if($bookings->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Detail & Update Status (Clean Admin Modal) -->
    <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
        <div @click.away="modalOpen = false" class="bg-white rounded-2xl max-w-lg w-full shadow-xl border border-slate-200 overflow-hidden">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-base text-slate-800">Detail & Update Status Pesanan</h3>
                    <p class="text-xs text-slate-500 font-mono mt-0.5" x-text="'Kode Booking: #' + activeBooking.booking_code"></p>
                </div>
                <button type="button" @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body Form -->
            <form :action="'{{ url('admin/travel-bookings') }}/' + activeBooking.id + '/status'" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <!-- Info Grid -->
                <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-200 text-xs space-y-2">
                    <div class="flex justify-between items-center pb-2 border-b border-slate-200/80">
                        <span class="text-slate-500">Pemesan:</span>
                        <span class="font-semibold text-slate-800" x-text="(activeBooking.customer ? activeBooking.customer.name : '-') + ' (' + (activeBooking.customer ? activeBooking.customer.phone : '-') + ')'"></span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-slate-200/80">
                        <span class="text-slate-500">Layanan:</span>
                        <span class="font-semibold text-slate-800 uppercase" x-text="activeBooking.booking_type || 'Shuttle'"></span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-slate-200/80">
                        <span class="text-slate-500">Total Tagihan:</span>
                        <span class="font-bold text-emerald-600 font-mono text-sm" x-text="'Rp ' + (new Intl.NumberFormat('id-ID').format(activeBooking.total_amount || 0))"></span>
                    </div>
                    <div>
                        <span class="text-slate-500 block mb-0.5">Titik Penjemputan:</span>
                        <span class="text-slate-700 block" x-text="activeBooking.pickup_address || '-'"></span>
                    </div>
                    <div>
                        <span class="text-slate-500 block mb-0.5">Titik Pengantaran:</span>
                        <span class="text-slate-700 block" x-text="activeBooking.dropoff_address || '-'"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <!-- Status Pesanan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Status Pesanan</label>
                        <select name="status" x-model="activeBooking.status" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white text-slate-700">
                            <option value="pending">Diproses (Pending)</option>
                            <option value="confirmed">Terkonfirmasi (Siap Berangkat)</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Status Pembayaran -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Status Pembayaran</label>
                        <select name="payment_status" x-model="activeBooking.payment_status" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white text-slate-700">
                            <option value="unpaid">Menunggu Pembayaran</option>
                            <option value="paid">Lunas (Paid)</option>
                            <option value="refunded">Pengembalian (Refund)</option>
                            <option value="cancelled">Batal</option>
                        </select>
                    </div>
                </div>

                <!-- Catatan Driver / Admin -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Catatan Sopir / Penjemputan</label>
                    <textarea name="notes" x-model="activeBooking.notes" rows="2" placeholder="Contoh: Driver Pak Asep (HP: 0812...), Penjemputan jam 05:45..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-slate-700"></textarea>
                </div>

                <!-- Footer Buttons -->
                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-200">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function travelBookingManager() {
        return {
            modalOpen: false
            , activeBooking: {}
            , openEditModal(booking) {
                this.activeBooking = Object.assign({}, booking);
                this.modalOpen = true;
            }
        };
    }

</script>
@endsection
