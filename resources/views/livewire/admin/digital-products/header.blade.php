<x-admin.page-header
    title="Produk Digital"
    :subtitle="$isDigiflazz ? 'Katalog hasil sinkronisasi Digiflazz. Produk baru belum dijual sampai diaktifkan.' : 'Kelola katalog produk digital Lynk.id yang dapat dipromosikan oleh Affiliate.'">
    @if($isDigiflazz)
    <x-admin.button wire:click="openPricing" variant="secondary" icon="fa-solid fa-tags">Pengaturan Harga</x-admin.button>
    <x-admin.button wire:click="clearAll"
        wire:confirm="Hapus SEMUA data katalog Digiflazz (produk, brand, kategori, override harga, riwayat modal, dan riwayat sync)? Produk Lynk.id tidak terpengaruh. Tindakan ini tidak bisa dibatalkan."
        wire:loading.attr="disabled" wire:target="clearAll" variant="danger" icon="fa-solid fa-broom">
        <span wire:loading.remove wire:target="clearAll">Bersihkan Data</span>
        <span wire:loading wire:target="clearAll">Membersihkan...</span>
    </x-admin.button>
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
