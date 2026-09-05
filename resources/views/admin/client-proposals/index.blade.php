@extends('layouts.admin.app')

@section('content')
<div x-data="clientProposalManager()" class="px-4 lg:px-6 py-6 lg:py-8">
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Client Proposals</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data klien untuk landing page dan proposal penawaran.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
            <!-- Tombol Ubah Harga Serentak -->
            <button @click="openPriceModal()" type="button" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-tags"></i> Ubah Harga Serentak
            </button>

            <!-- Tombol Tambah Klien Baru -->
            <a href="{{ route('admin.client_proposals.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Klien Baru
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian Bar -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6">
        <form action="{{ route('admin.client_proposals.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3">
            <!-- Search Input -->
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama brand, nama klien, no. WhatsApp..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <!-- Filter Kategori -->
            <div class="w-full md:w-64">
                <select name="category_id" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Filter & Reset -->
            <div class="flex items-center gap-2 w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition-colors shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
                @if(request()->filled('search') || request()->filled('category_id'))
                <a href="{{ route('admin.client_proposals.index') }}" class="w-full md:w-auto px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-1.5" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-lg shadow-sm flex items-center justify-between" role="alert">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 mb-6 rounded-r-lg shadow-sm flex items-center justify-between" role="alert">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Selected Items Banner -->
    <div x-show="selectedIds.length > 0" x-transition.opacity style="display: none;" class="bg-amber-50 border border-amber-200 rounded-xl p-3.5 mb-4 flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2 text-sm text-amber-900 font-medium">
            <i class="fa-solid fa-square-check text-amber-600 text-base"></i>
            <span><strong x-text="selectedIds.length"></strong> data proposal dipilih</span>
        </div>
        <div class="flex items-center gap-2">
            <button @click="openPriceModal('selected')" type="button" class="px-3.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-lg transition shadow-sm flex items-center gap-1.5">
                <i class="fa-solid fa-pen-to-square"></i> Ubah Harga Data Terpilih
            </button>
            <button @click="selectedIds = []" type="button" class="px-3 py-1.5 bg-white border border-slate-300 text-slate-600 hover:bg-slate-50 text-xs font-medium rounded-lg transition">
                Batal Pilih
            </button>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="w-12 px-4 py-4 text-center">
                            <input type="checkbox" @change="toggleSelectAll($event)" :checked="isAllSelected()" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500 cursor-pointer">
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Brand & Klien</th>
                        <th class="hidden sm:table-cell px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="hidden md:table-cell px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kontak WA</th>
                        <th class="hidden lg:table-cell px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga Project</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status / Owner</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($proposals as $p)
                    <tr class="hover:bg-slate-50/80 transition-colors" :class="selectedIds.includes('{{ $p->id }}') ? 'bg-blue-50/50' : ''">
                        <td class="w-12 px-4 py-4 text-center">
                            <input type="checkbox" value="{{ $p->id }}" x-model="selectedIds" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500 cursor-pointer">
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                {{ $p->brand_name }}
                            </div>
                            @if($p->client_name && strtolower($p->client_name) !== strtolower($p->brand_name))
                            <div class="text-xs text-slate-500 mt-0.5"><i class="fa-regular fa-user text-[10px] mr-1"></i>{{ $p->client_name }}</div>
                            @endif
                            <div class="text-xs text-blue-600 font-mono mt-1">/proposal/{{ $p->slug }}</div>
                        </td>
                        <td class="hidden sm:table-cell px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $p->category ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $p->category ? $p->category->name : 'Tanpa Kategori' }}
                            </span>
                        </td>
                        <td class="hidden md:table-cell px-6 py-4">
                            <div class="text-sm text-slate-800 font-medium">{{ $p->wa_number }}</div>
                        </td>
                        <td class="hidden lg:table-cell px-6 py-4">
                            <div class="text-sm font-bold text-emerald-600">Rp {{ number_format($p->project_price, 0, ',', '.') }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">+ Domain: Rp {{ number_format($p->domain_price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($p->affiliate_id)
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-medium bg-emerald-100 text-emerald-800 border border-emerald-200" title="Prospek ini sedang di-follow up oleh {{ $p->affiliate->name }}">
                                <i class="fa-solid fa-lock text-emerald-600"></i>
                                <span class="max-w-[100px] truncate">{{ $p->affiliate->name }}</span>
                            </div>
                            @else
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                <i class="fa-solid fa-globe text-slate-400"></i> Global
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <!-- Pop Up Menu Action -->
                            <div x-data="{ open: false }" class="relative inline-block text-left">
                                <button @click="open = !open" @click.away="open = false" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors focus:outline-none">
                                    <i class="fa-solid fa-ellipsis-vertical px-1"></i>
                                </button>

                                <div x-show="open" x-transition.opacity.duration.200ms style="display: none;" class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-xl z-[60] overflow-hidden text-left">
                                    <div class="py-1">
                                        <a href="{{ route('landing.dynamic', $p->slug) }}" target="_blank" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                            <i class="fa-solid fa-eye w-5 text-blue-500"></i> Lihat Landing Page
                                        </a>
                                        <a href="{{ route('proposal.dynamic', $p->slug) }}" target="_blank" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                            <i class="fa-solid fa-file-invoice w-5 text-indigo-500"></i> Lihat Proposal
                                        </a>
                                        <a href="{{ route('admin.client_proposals.edit', $p->id) }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                            <i class="fa-solid fa-pen w-5 text-yellow-500"></i> Edit Data
                                        </a>
                                        <form action="{{ route('admin.client_proposals.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data klien ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                <i class="fa-solid fa-trash w-5"></i> Hapus Data
                                            </button>
                                        </form>

                                        <div class="border-t border-slate-100 my-1"></div>

                                        <div class="px-4 py-3 bg-green-50/50">
                                            <label class="block text-xs font-semibold text-green-800 mb-2"><i class="fa-brands fa-whatsapp mr-1"></i> Kirim WhatsApp:</label>
                                            <div class="relative">
                                                <select onchange="kirimWaLangsung(this, '{{ $p->wa_number }}', '{{ $p->brand_name }}', '{{ route('landing.dynamic', $p->slug) }}', '{{ route('proposal.dynamic', $p->slug) }}')" class="w-full appearance-none pl-3 pr-8 py-2 bg-white border border-green-200 text-green-700 text-xs font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 cursor-pointer shadow-sm transition-all hover:border-green-300">
                                                    <option value="" disabled selected>Pilih Template...</option>
                                                    @php
                                                    $filteredTemplates = $chatTemplates->filter(function($ct) use ($p) {
                                                    return is_null($ct->business_category_id) || $ct->business_category_id == $p->business_category_id;
                                                    });
                                                    @endphp
                                                    @foreach($filteredTemplates as $ct)
                                                    <option value="{{ base64_encode($ct->content) }}">{{ $ct->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-green-600">
                                                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            <div class="max-w-sm mx-auto">
                                <i class="fa-solid fa-folder-open text-slate-300 text-4xl mb-3"></i>
                                <p class="font-medium text-slate-700">Tidak ada data proposal yang ditemukan.</p>
                                <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian atau kategori lain.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($proposals->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $proposals->links() }}
        </div>
        @endif
    </div>

    <!-- MODAL UBAH HARGA SERENTAK (BULK UPDATE PRICE) -->
    <div x-show="showPriceModal" x-transition.opacity.duration.300ms style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showPriceModal = false" class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-200 transform transition-all">

            <!-- Modal Header -->
            <div class="px-6 py-5 bg-gradient-to-r from-amber-500 to-amber-600 text-white flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg leading-tight">Ubah Harga Serentak</h3>
                        <p class="text-amber-100 text-xs">Perbarui harga paket proyek & domain secara massal</p>
                    </div>
                </div>
                <button @click="showPriceModal = false" class="text-white/80 hover:text-white transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Form Ubah Harga -->
            <form action="{{ route('admin.client_proposals.bulk_update_price') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <!-- Pilihan Target Update -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2.5">Pilih Target Proposal:</label>
                    <div class="grid grid-cols-1 gap-2.5">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition" :class="scope === 'all' ? 'border-amber-500 bg-amber-50/50' : ''">
                            <input type="radio" name="scope" value="all" x-model="scope" class="text-amber-600 focus:ring-amber-500">
                            <div>
                                <div class="text-sm font-semibold text-slate-800">Semua Data Proposal</div>
                                <div class="text-xs text-slate-500">Ubah seluruh klien proposal di database</div>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition" :class="scope === 'category' ? 'border-amber-500 bg-amber-50/50' : ''">
                            <input type="radio" name="scope" value="category" x-model="scope" class="text-amber-600 focus:ring-amber-500 mt-1">
                            <div class="flex-1">
                                <div class="text-sm font-semibold text-slate-800">Berdasarkan Kategori Bisnis</div>
                                <div class="text-xs text-slate-500 mb-2">Hanya ubah data pada kategori terpilih</div>
                                <select x-show="scope === 'category'" name="target_category_id" class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:outline-none">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition" :class="scope === 'selected' ? 'border-amber-500 bg-amber-50/50' : ''">
                            <input type="radio" name="scope" value="selected" x-model="scope" class="text-amber-600 focus:ring-amber-500">
                            <div>
                                <div class="text-sm font-semibold text-slate-800">Hanya Data yang Dicentang</div>
                                <div class="text-xs text-slate-500">
                                    <span x-text="selectedIds.length"></span> proposal saat ini dipilih di tabel
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Hidden Selected IDs -->
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="selected_ids[]" :value="id">
                    </template>
                </div>

                <!-- Input Harga Project -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Project Baru (IDR):</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center font-bold text-slate-400 text-sm">Rp</span>
                        <input type="number" name="project_price" placeholder="Contoh: 4500000" class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-300 text-slate-800 text-sm font-semibold rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah Harga Project.</p>
                </div>

                <!-- Input Harga Domain -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Domain & Hosting Baru (IDR):</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center font-bold text-slate-400 text-sm">Rp</span>
                        <input type="number" name="domain_price" placeholder="Contoh: 1200000" class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-300 text-slate-800 text-sm font-semibold rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah Harga Domain.</p>
                </div>

                <!-- Modal Actions -->
                <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2.5">
                    <button @click="showPriceModal = false" type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin memperbarui harga pada data yang dipilih?')" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-lg transition shadow-md flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> Simpan Perubahan Harga
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function clientProposalManager() {
        return {
            showPriceModal: false
            , scope: 'all'
            , selectedIds: []
            , pageIds: @json($proposals - > pluck('id') - > map(fn($id) => (string) $id)),

            openPriceModal(defaultScope = 'all') {
                if (defaultScope === 'selected' && this.selectedIds.length === 0) {
                    alert('Silakan centang minimal satu proposal di tabel terlebih dahulu.');
                    return;
                }
                this.scope = this.selectedIds.length > 0 && defaultScope === 'selected' ? 'selected' : defaultScope;
                this.showPriceModal = true;
            },

            toggleSelectAll(e) {
                if (e.target.checked) {
                    this.pageIds.forEach(id => {
                        if (!this.selectedIds.includes(id)) {
                            this.selectedIds.push(id);
                        }
                    });
                } else {
                    this.selectedIds = this.selectedIds.filter(id => !this.pageIds.includes(id));
                }
            },

            isAllSelected() {
                if (this.pageIds.length === 0) return false;
                return this.pageIds.every(id => this.selectedIds.includes(id));
            }
        };
    }

    function kirimWaLangsung(selectElement, phone, brandName, linkLandingPage, linkProposal) {
        if (!selectElement.value) return;

        if (!phone) {
            alert('Nomor WhatsApp belum diatur untuk klien ini. Silakan edit data klien terlebih dahulu.');
            selectElement.value = "";
            return;
        }

        // Format number to replace leading 0 or +62 with 62
        let formattedPhone = phone.replace(/[^0-9]/g, '');
        if (formattedPhone.startsWith('0')) {
            formattedPhone = '62' + formattedPhone.substring(1);
        }

        // Decode template text
        let text = decodeURIComponent(escape(window.atob(selectElement.value)));

        // Replace placeholders
        if (brandName) {
            text = text.replace(/\{nama_bisnis\}/g, brandName);
        }
        if (linkLandingPage) {
            text = text.replace(/\{link_landing_page\}/g, linkLandingPage);
        }
        if (linkProposal) {
            text = text.replace(/\{link_proposal\}/g, linkProposal);
        }

        // Open WA Link
        const waUrl = `https://api.whatsapp.com/send?phone=${formattedPhone}&text=${encodeURIComponent(text)}`;

        // Deteksi jika dibuka via HP (Mobile) agar langsung buka aplikasi tanpa diblokir browser
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            window.location.href = waUrl;
        } else {
            window.open(waUrl, '_blank');
        }

        // Reset dropdown back to default
        selectElement.value = "";
    }

</script>
@endsection
