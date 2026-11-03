<div>
    @include('livewire.admin.digital-products.header')

    @if($isDigiflazz)
    @include('livewire.admin.digital-products.stats')
    @endif

    <x-admin.card :padding="false">
        @include('livewire.admin.digital-products.filters')

        <div class="overflow-x-auto" wire:loading.class="opacity-60" wire:target="search,category,brand,status,provider,gotoPage,previousPage,nextPage">
            @include($isDigiflazz ? 'livewire.admin.digital-products.table-digiflazz' : 'livewire.admin.digital-products.table-lynk')
        </div>

        @if ($products->hasPages())
        <div class="px-4 py-3 border-t border-slate-200">
            {{ $products->links() }}
        </div>
        @endif
    </x-admin.card>

    @if($isDigiflazz)
    @include('livewire.admin.digital-products.sync-logs')
    @include('livewire.admin.digital-products.modal-detail')
    @include('livewire.admin.digital-products.modal-edit')
    @include('livewire.admin.digital-products.modal-pricing')
    @endif
</div>
