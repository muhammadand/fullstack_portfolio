@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8" x-data="travelScheduleManager()">

    <!-- Header -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <img src="{{ asset('images/travel/rivian_logo.jpg') }}" alt="Rivian Travel" class="w-9 h-9 rounded-xl object-cover border border-slate-200 shadow-xs shrink-0">
                <span>Jadwal & Kuota Keberangkatan</span>
            </h1>
            <p class="text-slate-500 text-sm mt-1">Atur jam keberangkatan shuttle Xenia Ciamis - Bandung dan kuota minimal kursi.</p>
        </div>
        <div class="flex items-center gap-2.5 w-full md:w-auto">
            <button type="button" @click="openCreateModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm flex items-center justify-center gap-2 w-full sm:w-auto cursor-pointer">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Jadwal Baru</span>
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg mb-6 text-sm flex items-center gap-3 shadow-xs" role="alert">
        <i class="fa-solid fa-circle-check text-emerald-500"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg mb-6 text-sm flex items-center gap-3 shadow-xs" role="alert">
        <i class="fa-solid fa-circle-exclamation text-red-500"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Filter Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.travel_schedules.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <select name="route_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white text-slate-700">
                    <option value="">Semua Rute Perjalanan</option>
                    @foreach($routes as $rt)
                    <option value="{{ $rt->id }}" {{ ($routeId ?? '') == $rt->id ? 'selected' : '' }}>
                        {{ $rt->origin }} ➔ {{ $rt->destination }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:w-44">
                <input type="date" name="date" value="{{ $date ?? '' }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white text-slate-700">
            </div>

            <div class="sm:w-44">
                <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white text-slate-700">
                    <option value="">Semua Status</option>
                    <option value="confirmed" {{ ($status ?? '') === 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
                    <option value="waiting_quota" {{ ($status ?? '') === 'waiting_quota' ? 'selected' : '' }}>Menunggu Kuota</option>
                    <option value="departed" {{ ($status ?? '') === 'departed' ? 'selected' : '' }}>Sudah Berangkat</option>
                    <option value="completed" {{ ($status ?? '') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ ($status ?? '') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition-colors shadow-sm">
                Filter
            </button>

            @if($routeId || $date || $status)
            <a href="{{ route('admin.travel_schedules.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition-colors text-center">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Table of Schedules -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Rute Perjalanan</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jam Berangkat</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Min. Kuota</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Status</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Booking Masuk</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm">
                    @forelse($schedules as $s)
                    @php
                        $r = $s->route;
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-5 py-3.5">
                            <span class="font-semibold text-slate-800 text-xs flex items-center gap-1.5">
                                <span>{{ $r ? $r->origin : 'Ciamis' }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px] text-slate-400"></i>
                                <span>{{ $r ? $r->destination : 'Bandung' }}</span>
                            </span>
                        </td>
                        <td class="px-5 py-3.5 font-medium text-slate-800 text-xs">
                            {{ $s->departure_date ? \Carbon\Carbon::parse($s->departure_date)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-5 py-3.5 font-mono font-bold text-blue-600 text-xs">
                            {{ \Carbon\Carbon::parse($s->departure_time)->format('H:i') }} WIB
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2 py-0.5 rounded text-[11px] font-medium {{ $s->service_type === 'premium_sopir' ? 'bg-purple-50 text-purple-700 border border-purple-200/80' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                {{ $s->service_type === 'premium_sopir' ? 'Premium Sopir' : 'Reguler' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-center font-medium text-xs text-slate-700">
                            {{ $s->min_quota }} Kursi
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($s->status === 'confirmed')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Terkonfirmasi
                            </span>
                            @elseif($s->status === 'waiting_quota')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200/80">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Menunggu Kuota
                            </span>
                            @elseif($s->status === 'departed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                Berangkat
                            </span>
                            @elseif($s->status === 'completed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                Selesai
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700">
                                Batal
                            </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-center font-bold text-xs text-slate-800">
                            {{ $s->bookings_count }}
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button type="button" @click="openEditModal({{ json_encode($s) }})" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors cursor-pointer" title="Edit Jadwal">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                <form action="{{ route('admin.travel_schedules.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal keberangkatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer" title="Hapus Jadwal">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-slate-500">
                            Belum ada jadwal keberangkatan yang sesuai filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $schedules->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Create / Edit Schedule (Soft & Clean) -->
    <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
        <div @click.away="modalOpen = false" class="bg-white rounded-2xl max-w-md w-full shadow-xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-bold text-base text-slate-800" x-text="isEdit ? 'Edit Jadwal Keberangkatan' : 'Tambah Jadwal Baru'"></h3>
                <button type="button" @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form :action="formAction" method="POST" class="p-6 space-y-4">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Pilih Rute</label>
                    <select name="route_id" x-model="formData.route_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white text-slate-800">
                        <option value="">-- Pilih Rute --</option>
                        @foreach($routes as $rt)
                        <option value="{{ $rt->id }}">{{ $rt->origin }} ➔ {{ $rt->destination }} (Rp {{ number_format($rt->base_price, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Tanggal</label>
                        <input type="date" name="departure_date" x-model="formData.departure_date" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Jam Berangkat</label>
                        <input type="time" name="departure_time" x-model="formData.departure_time" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-slate-800">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Layanan</label>
                        <select name="service_type" x-model="formData.service_type" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white text-slate-800">
                            <option value="reguler">Reguler</option>
                            <option value="premium_sopir">Premium Sopir</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Min. Kuota Kursi</label>
                        <input type="number" name="min_quota" x-model="formData.min_quota" required min="1" max="20" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-slate-800">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Status Jadwal</label>
                    <select name="status" x-model="formData.status" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white text-slate-800">
                        <option value="confirmed">Terkonfirmasi (Siap Booking)</option>
                        <option value="waiting_quota">Menunggu Kuota</option>
                        <option value="departed">Sudah Berangkat</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-200">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                        <span x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Jadwal'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function travelScheduleManager() {
        return {
            modalOpen: false,
            isEdit: false,
            formAction: '{{ route('admin.travel_schedules.store') }}',
            formData: {
                route_id: '{{ $routes->first()->id ?? '' }}',
                departure_date: new Date().toISOString().split('T')[0],
                departure_time: '06:00',
                service_type: 'reguler',
                min_quota: 4,
                status: 'confirmed'
            },
            openCreateModal() {
                this.isEdit = false;
                this.formAction = '{{ route('admin.travel_schedules.store') }}';
                this.formData = {
                    route_id: '{{ $routes->first()->id ?? '' }}',
                    departure_date: new Date().toISOString().split('T')[0],
                    departure_time: '06:00',
                    service_type: 'reguler',
                    min_quota: 4,
                    status: 'confirmed'
                };
                this.modalOpen = true;
            },
            openEditModal(schedule) {
                this.isEdit = true;
                this.formAction = '{{ url('admin/travel-schedules') }}/' + schedule.id;
                var depDate = schedule.departure_date ? schedule.departure_date.split('T')[0] : '';
                var depTime = schedule.departure_time ? schedule.departure_time.substring(0, 5) : '06:00';
                this.formData = {
                    route_id: schedule.route_id,
                    departure_date: depDate,
                    departure_time: depTime,
                    service_type: schedule.service_type || 'reguler',
                    min_quota: schedule.min_quota || 4,
                    status: schedule.status || 'confirmed'
                };
                this.modalOpen = true;
            }
        };
    }
</script>
@endsection
