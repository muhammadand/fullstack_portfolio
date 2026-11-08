{{-- Filter produk digital: pola sama dengan <x-admin.filter-bar> (HP: cari + panel lipat; desktop: sebaris). --}}
@php $activeFilters = (int) ($category !== '') + (int) ($brand !== '') + (int) ($status !== ''); @endphp
<div class="admin-filter p-3 lg:p-4 border-b border-slate-200" x-data="{ open: false }">
    <div class="flex flex-wrap lg:flex-nowrap items-center gap-2">
        <div class="relative flex-1 min-w-0 order-1">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
            <input type="search" wire:model.live.debounce.400ms="search" enterkeyhint="search"
                   placeholder="{{ $isDigiflazz ? 'Cari nama produk atau SKU...' : 'Cari nama, kategori, kode Lynk...' }}"
                   class="w-full h-10 lg:h-9 rounded-lg border border-slate-300 bg-white pl-8 pr-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:border-blue-500 focus:ring-blue-500/20">
        </div>

        <button type="button" @click="open = !open" :aria-expanded="open" aria-label="Filter"
                class="lg:hidden order-2 relative h-10 w-10 shrink-0 rounded-lg border flex items-center justify-center {{ $activeFilters ? 'border-blue-300 bg-blue-50 text-blue-600' : 'border-slate-300 bg-white text-slate-600' }}">
            <i class="fa-solid fa-sliders text-sm"></i>
            @if($activeFilters)
            <span class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 rounded-full bg-blue-600 text-white text-[10px] font-bold leading-[18px] text-center">{{ $activeFilters }}</span>
            @endif
        </button>

        <div :class="open && '!grid'"
             class="max-lg:hidden order-4 lg:order-2 w-full lg:w-auto grid-cols-2 gap-2 lg:flex lg:items-center lg:shrink-0 [&>*]:min-w-0 [&_select]:h-10 lg:[&_select]:h-9 [&_select]:py-0">
            <x-admin.select name="category" wire:model.live="category" placeholder="Semua Kategori" :options="$this->categories" :class="$isDigiflazz ? 'lg:w-44' : 'col-span-2 lg:w-44'" />
            @if($isDigiflazz)
            <x-admin.select name="brand" wire:model.live="brand" placeholder="Semua Brand" :options="$this->brands" class="lg:w-44" />
            <x-admin.select name="status" wire:model.live="status" placeholder="Semua Status" class="col-span-2 lg:w-44"
                :options="['active' => 'Aktif (dijual)', 'inactive' => 'Belum diaktifkan', 'unavailable' => 'Gangguan supplier', 'missing' => 'Hilang dari katalog']" />
            @endif
        </div>

        @if($search !== '' || $activeFilters)
        <button type="button" wire:click="resetFilters" class="order-3 h-10 lg:h-9 px-3 shrink-0 rounded-lg border border-slate-300 bg-white text-sm text-slate-600 flex items-center gap-1.5" aria-label="Reset filter">
            <i class="fa-solid fa-xmark text-xs"></i><span class="hidden lg:inline">Reset</span>
        </button>
        @endif
    </div>
</div>
