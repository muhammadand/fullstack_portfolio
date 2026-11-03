<div>
    <x-admin.page-header
        title="Produk Digital"
        :subtitle="$isDigiflazz ? 'Katalog hasil sinkronisasi Digiflazz. Produk baru belum dijual sampai diaktifkan.' : 'Kelola katalog produk digital Lynk.id yang dapat dipromosikan oleh Affiliate.'">
        @if($isDigiflazz)
        <x-admin.button wire:click="sync" wire:loading.attr="disabled" wire:target="sync" icon="fa-solid fa-rotate">
            <span wire:loading.remove wire:target="sync">Sync Produk</span>
            <span wire:loading wire:target="sync">Menyinkronkan...</span>
        </x-admin.button>
        @else
        <x-admin.button icon="fa-solid fa-plus" :href="route('admin.digital_products.create')">
            Tambah Produk Lynk.id
        </x-admin.button>
        @endif
    </x-admin.page-header>

    @if(session('success'))
    <x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
    @endif

    @if($notice)
    <x-admin.alert type="success">{{ $notice }}</x-admin.alert>
    @endif

    @if($error)
    <x-admin.alert type="error">{{ $error }}</x-admin.alert>
    @endif

    {{-- Tab sumber produk --}}
    <div class="flex gap-1 mb-4 border-b border-slate-200">
        @foreach(['digiflazz' => 'Digiflazz', 'lynk' => 'Lynk.id'] as $key => $label)
        <button type="button" wire:click="$set('provider', '{{ $key }}')"
            class="px-4 py-2 text-sm font-medium -mb-px border-b-2 transition-colors {{ $provider === $key ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            {{ $label }}
        </button>
        @endforeach
    </div>

    @if($isDigiflazz)
    {{-- Ringkasan --}}
    @php
    $stats = $this->stats;
    $cards = [
        ['label' => 'Total Produk', 'value' => number_format($stats['total'], 0, ',', '.'), 'icon' => 'fa-cubes-stacked', 'color' => 'text-blue-600 bg-blue-50'],
        ['label' => 'Aktif (Dijual)', 'value' => number_format($stats['active'], 0, ',', '.'), 'icon' => 'fa-circle-check', 'color' => 'text-emerald-600 bg-emerald-50'],
        ['label' => 'Belum Diaktifkan', 'value' => number_format($stats['inactive'], 0, ',', '.'), 'icon' => 'fa-hourglass-half', 'color' => 'text-amber-600 bg-amber-50'],
        ['label' => 'Hilang dari Katalog', 'value' => number_format($stats['missing'], 0, ',', '.'), 'icon' => 'fa-triangle-exclamation', 'color' => 'text-red-600 bg-red-50'],
        ['label' => 'Sync Terakhir', 'value' => $stats['last_synced_at']?->diffForHumans() ?? 'Belum pernah', 'icon' => 'fa-clock', 'color' => 'text-slate-600 bg-slate-100'],
    ];
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-4">
        @foreach($cards as $card)
        <x-admin.card>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $card['color'] }}">
                    <i class="fa-solid {{ $card['icon'] }}"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-xs text-slate-500">{{ $card['label'] }}</p>
                    <p class="text-base font-bold text-slate-900 truncate">{{ $card['value'] }}</p>
                </div>
            </div>
        </x-admin.card>
        @endforeach
    </div>

    <x-admin.card title="Level Harga" icon="fa-solid fa-tags" class="mb-4">
        <div class="flex flex-wrap gap-2 text-sm">
            @foreach($this->levels as $level)
            <x-admin.badge :color="$level->is_default ? 'blue' : 'slate'">
                {{ $level->name }}: margin {{ $level->margin_type === 'percent' ? rtrim(rtrim(number_format($level->margin_value, 2, ',', '.'), '0'), ',') . '%' : 'Rp ' . number_format($level->margin_value, 0, ',', '.') }}
            </x-admin.badge>
            @endforeach
        </div>
        <p class="text-xs text-slate-400 mt-2">Harga jual = modal + margin level, kecuali ada override manual per produk.</p>
    </x-admin.card>
    @endif

    <x-admin.card :padding="false">
        {{-- Toolbar --}}
        <div class="flex flex-col lg:flex-row gap-2.5 p-4 border-b border-slate-200">
            <div class="relative flex-1 lg:max-w-sm">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                <x-admin.input name="q" wire:model.live.debounce.400ms="search"
                    :placeholder="$isDigiflazz ? 'Cari nama produk atau SKU...' : 'Cari nama, kategori, kode Lynk...'" class="pl-9" />
            </div>

            <div class="lg:w-44">
                <x-admin.select name="category" wire:model.live="category" placeholder="Semua Kategori"
                    :options="$this->categories->mapWithKeys(fn ($c) => [$c => $c])->all()" />
            </div>

            @if($isDigiflazz)
            <div class="lg:w-48">
                <x-admin.select name="brand" wire:model.live="brand" placeholder="Semua Brand"
                    :options="$this->brands->mapWithKeys(fn ($b) => [$b->id => $b->name . ' (' . $b->category . ')'])->all()" />
            </div>

            <div class="lg:w-44">
                <x-admin.select name="status" wire:model.live="status" placeholder="Semua Status"
                    :options="['active' => 'Aktif (dijual)', 'inactive' => 'Belum diaktifkan', 'unavailable' => 'Gangguan supplier', 'missing' => 'Hilang dari katalog']" />
            </div>
            @endif

            @if($search !== '' || $category !== '' || $brand !== '' || $status !== '')
            <div>
                <x-admin.button wire:click="resetFilters" variant="secondary" icon="fa-solid fa-xmark">Reset</x-admin.button>
            </div>
            @endif
        </div>

        <div class="overflow-x-auto" wire:loading.class="opacity-60" wire:target="search,category,brand,status,provider,gotoPage,previousPage,nextPage">
            @if($isDigiflazz)
            @php $levels = $this->levels; @endphp
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3 text-right">Modal</th>
                        @foreach($levels as $level)
                        <th class="px-4 py-3 text-right">{{ ucfirst($level->code) }}</th>
                        @endforeach
                        <th class="px-4 py-3">Supplier</th>
                        <th class="px-4 py-3">Cut-off</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($products as $product)
                    <tr wire:key="dg-{{ $product->id }}" class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-4 py-3 max-w-xs">
                            <p class="font-medium text-slate-900 truncate" title="{{ $product->name }}">{{ $product->name }}</p>
                            <p class="text-xs text-slate-400 truncate">
                                {{ $product->category }} · {{ $product->brand?->name }}{{ $product->type ? ' · ' . $product->type : '' }}
                            </p>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <code class="px-2 py-0.5 bg-slate-100 border border-slate-200 rounded font-mono text-xs text-slate-700">{{ $product->sku_code }}</code>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-slate-900 font-medium">
                            Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                        </td>
                        @foreach($levels as $level)
                        <td class="px-4 py-3 whitespace-nowrap text-right">Rp {{ number_format($product->priceFor($level), 0, ',', '.') }}</td>
                        @endforeach
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($product->buyer_product_status && $product->seller_product_status)
                            <x-admin.badge color="green">Normal</x-admin.badge>
                            @else
                            <x-admin.badge color="orange">Gangguan</x-admin.badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-xs">
                            @if($product->start_cut_off && $product->end_cut_off)
                            {{ substr($product->start_cut_off, 0, 5) }} - {{ substr($product->end_cut_off, 0, 5) }}
                            @if($product->isInCutOff())
                            <x-admin.badge color="yellow">Sekarang</x-admin.badge>
                            @endif
                            @else
                            <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($product->is_missing)
                            <x-admin.badge color="orange"><i class="fa-solid fa-triangle-exclamation text-[10px]"></i> Hilang</x-admin.badge>
                            @elseif($product->is_active)
                            <x-admin.badge color="green"><i class="fa-solid fa-circle-check text-[10px]"></i> Aktif</x-admin.badge>
                            @else
                            <x-admin.badge color="slate"><i class="fa-solid fa-circle-xmark text-[10px]"></i> Belum aktif</x-admin.badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex justify-end">
                                <x-admin.button wire:click="toggle({{ $product->id }})" wire:loading.attr="disabled" wire:target="toggle({{ $product->id }})"
                                    size="sm" :variant="$product->is_active ? 'secondary' : 'soft'">
                                    {{ $product->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </x-admin.button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ 7 + $levels->count() }}" class="px-4 py-12 text-center">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-boxes-stacked text-xl"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-700">
                                {{ $search !== '' || $category !== '' || $brand !== '' || $status !== '' ? 'Tidak ada produk yang cocok dengan filter.' : 'Katalog masih kosong.' }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">
                                {{ $search !== '' || $category !== '' || $brand !== '' || $status !== '' ? 'Coba ganti kata kunci atau reset filter.' : 'Klik "Sync Produk" untuk mengambil price-list dari Digiflazz.' }}
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @else
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Kode Lynk.id</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($products as $product)
                    <tr wire:key="lynk-{{ $product->id }}" class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-4 py-3 max-w-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200/80 flex items-center justify-center text-amber-600 shrink-0 overflow-hidden">
                                    @if($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                    <i class="fa-solid fa-cube text-base"></i>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('admin.digital_products.edit', $product->id) }}" class="font-medium text-slate-900 hover:text-blue-600 block truncate" title="{{ $product->name }}">{{ $product->name }}</a>
                                    <p class="text-xs text-slate-400 truncate mt-0.5">{{ $product->short_description ?: 'Tidak ada deskripsi singkat' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200/80">{{ $product->category ?: 'General' }}</span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <code class="px-2 py-0.5 bg-amber-50 border border-amber-200/80 rounded font-mono text-xs text-amber-800 font-semibold">{{ $product->lynk_slug }}</code>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap font-bold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($product->is_active)
                            <x-admin.badge color="green"><i class="fa-solid fa-circle-check text-[10px]"></i> Aktif</x-admin.badge>
                            @else
                            <x-admin.badge color="slate"><i class="fa-solid fa-circle-xmark text-[10px]"></i> Nonaktif</x-admin.badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1.5">
                                @if($product->demo_url)
                                <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-arrow-up-right-from-square" :href="$product->demo_url" target="_blank" title="Lihat Live Demo" />
                                @endif
                                <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-pen" :href="route('admin.digital_products.edit', $product->id)">Edit</x-admin.button>
                                <form action="{{ route('admin.digital_products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk digital ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.button type="submit" variant="danger" size="sm" icon="fa-solid fa-trash-can" title="Hapus" aria-label="Hapus" />
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <p class="text-sm font-medium text-slate-700">
                                {{ $search !== '' || $category !== '' ? 'Tidak ada produk Lynk.id yang cocok dengan filter.' : 'Belum ada produk Lynk.id terdaftar.' }}
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @endif
        </div>

        @if ($products->hasPages())
        <div class="px-4 py-3 border-t border-slate-200">
            {{ $products->links() }}
        </div>
        @endif
    </x-admin.card>

    @if($isDigiflazz)
    <x-admin.card title="Riwayat Sinkronisasi" icon="fa-solid fa-clock-rotate-left" :padding="false" class="mt-4">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Diterima</th>
                        <th class="px-4 py-3 text-right">Baru</th>
                        <th class="px-4 py-3 text-right">Diperbarui</th>
                        <th class="px-4 py-3 text-right">Modal Berubah</th>
                        <th class="px-4 py-3 text-right">Hilang</th>
                        <th class="px-4 py-3">Oleh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($this->syncLogs as $log)
                    <tr wire:key="log-{{ $log->id }}">
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->started_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($log->status === 'success')
                            <x-admin.badge color="green">Berhasil</x-admin.badge>
                            @elseif($log->status === 'failed')
                            <x-admin.badge color="orange" title="{{ $log->error_message }}">Gagal</x-admin.badge>
                            @else
                            <x-admin.badge color="blue">Berjalan</x-admin.badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">{{ $log->total_received }}</td>
                        <td class="px-4 py-3 text-right">{{ $log->total_new }}</td>
                        <td class="px-4 py-3 text-right">{{ $log->total_updated }}</td>
                        <td class="px-4 py-3 text-right">{{ $log->total_cost_changed }}</td>
                        <td class="px-4 py-3 text-right">{{ $log->total_missing }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->user?->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-xs text-slate-400">Belum ada riwayat sinkronisasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-admin.card>
    @endif
</div>
