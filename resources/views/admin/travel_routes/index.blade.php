@extends('layouts.admin.app')

@section('content')
<div class="" x-data="travelRouteManager()">

    <x-admin.page-header title="Rute Perjalanan Travel" subtitle="Kelola kota asal, tujuan, dan tarif dasar tiket shuttle.">
        <x-admin.button icon="fa-solid fa-plus" @click="openCreateModal()">Tambah Rute</x-admin.button>
    </x-admin.page-header>

    <!-- Table of Routes -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kota Asal (Origin)</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kota Tujuan (Destination)</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tarif Dasar / Kursi</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Jadwal Aktif</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm">
                    @forelse($routes as $index => $r)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-5 py-3.5 font-medium text-slate-400 text-xs">
                            {{ $routes->firstItem() + $index }}
                        </td>
                        <td class="px-5 py-3.5 font-semibold text-slate-800">
                            {{ $r->origin }}
                        </td>
                        <td class="px-5 py-3.5 font-semibold text-slate-800">
                            {{ $r->destination }}
                        </td>
                        <td class="px-5 py-3.5 font-mono font-bold text-emerald-600">
                            Rp {{ number_format($r->base_price, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <a href="{{ route('admin.travel_schedules.index', ['route_id' => $r->id]) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors">
                                <i class="far fa-calendar-alt text-[11px]"></i>
                                <span>{{ $r->schedules_count }} Jadwal</span>
                            </a>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button type="button" @click="openEditModal({{ json_encode($r) }})" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors cursor-pointer" title="Edit Rute">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                <form action="{{ route('admin.travel_routes.destroy', $r->id) }}" method="POST" data-confirm="Hapus rute {{ $r->origin }} - {{ $r->destination }}?" data-confirm-danger>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer" title="Hapus Rute">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                            Belum ada rute perjalanan travel.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($routes->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $routes->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Create / Edit Route (Soft & Clean) -->
    <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
        <div @click.away="modalOpen = false" class="bg-white rounded-2xl max-w-md w-full shadow-xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-bold text-base text-slate-800" x-text="isEdit ? 'Edit Rute Perjalanan' : 'Tambah Rute Baru'"></h3>
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
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Kota Asal (Origin)</label>
                    <input type="text" name="origin" x-model="formData.origin" required placeholder="Contoh: Ciamis" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Kota Tujuan (Destination)</label>
                    <input type="text" name="destination" x-model="formData.destination" required placeholder="Contoh: Bandung" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-slate-800">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wider">Tarif Dasar per Kursi (Rp)</label>
                    <input type="number" name="base_price" x-model="formData.base_price" required min="0" step="1000" placeholder="190000" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-slate-800">
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-200">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                        <span x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Rute'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function travelRouteManager() {
        return {
            modalOpen: false
            , isEdit: false
            , formAction: '{{ route('
            admin.travel_routes.store ') }}'
            , formData: {
                origin: ''
                , destination: ''
                , base_price: 190000
            }
            , openCreateModal() {
                this.isEdit = false;
                this.formAction = '{{ route('
                admin.travel_routes.store ') }}';
                this.formData = {
                    origin: ''
                    , destination: ''
                    , base_price: 190000
                };
                this.modalOpen = true;
            }
            , openEditModal(route) {
                this.isEdit = true;
                this.formAction = '{{ url('
                admin / travel - routes ') }}/' + route.id;
                this.formData = {
                    origin: route.origin
                    , destination: route.destination
                    , base_price: route.base_price
                };
                this.modalOpen = true;
            }
        };
    }

</script>
@endsection
