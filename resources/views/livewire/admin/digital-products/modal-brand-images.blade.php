@if($brandImagesOpen)
<x-admin.modal title="Gambar Game" icon="fa-solid fa-image" size="lg">
    <p class="text-sm text-slate-500 mb-4">
        Gambar tampil di landing page top up. Disarankan rasio 3:4 (potret), JPG/PNG/WebP, maksimal 2 MB. Gambar langsung tersimpan setelah dipilih.
    </p>

    <div class="divide-y divide-slate-100">
        @forelse($this->brandList as $b)
        <div wire:key="brand-image-{{ $b->id }}" class="flex items-center gap-4 py-3">
            <div class="w-14 h-[74px] shrink-0 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center">
                @if(isset($brandUploads[$b->id]))
                <img src="{{ $brandUploads[$b->id]->temporaryUrl() }}" alt="" class="w-full h-full object-cover">
                @elseif($b->image)
                <img src="{{ asset('storage/' . $b->image) }}" alt="{{ $b->name }}" class="w-full h-full object-cover">
                @else
                <i class="fa-regular fa-image text-slate-300"></i>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-800 truncate">{{ $b->name }}</p>
                <input type="file" accept="image/png,image/jpeg,image/webp" wire:model="brandUploads.{{ $b->id }}"
                    class="mt-1 block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs file:font-medium hover:file:bg-blue-100">
                <div wire:loading wire:target="brandUploads.{{ $b->id }}" class="text-xs text-blue-600 mt-1">Mengunggah...</div>
                @error('brandUploads.' . $b->id)<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            @if($b->image)
            <button type="button" wire:click="removeBrandImage({{ $b->id }})" wire:confirm="Hapus gambar {{ $b->name }}?"
                class="text-xs text-red-600 hover:text-red-700 font-medium">Hapus</button>
            @endif
        </div>
        @empty
        <p class="text-sm text-slate-400 py-6 text-center">Belum ada brand kategori Games. Jalankan Sync Produk terlebih dahulu.</p>
        @endforelse
    </div>

    <x-slot:footer>
        <x-admin.button wire:click="closeModal" variant="secondary">Tutup</x-admin.button>
    </x-slot:footer>
</x-admin.modal>
@endif
