---
name: interactive-confirmation-modals
description: Pattern and templates for implementing custom interactive confirmation modals (Alpine.js + Tailwind CSS) in Laravel Blade views instead of native browser alerts/confirms.
category: frontend
---

# Interactive Confirmation Modals

Standard pattern for creating polished, high-end confirmation modals across the codebase.

## Alpine.js Pattern

### 1. State Definition in `x-data`
```html
<div x-data="{
    confirmModal: false,
    selectedItem: { id: '', name: '', actionUrl: '' },
    openConfirmModal(id, name, url) {
        this.selectedItem = { id: id, name: name, actionUrl: url };
        this.confirmModal = true;
    }
}">
```

### 2. Trigger Button (Zero `confirm()`)
```html
<button type="button" 
        @click="openConfirmModal('{{ $item->id }}', '{{ addslashes($item->name) }}', '{{ route('items.delete', $item->id) }}')" 
        class="inline-flex items-center gap-1.5 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-semibold shadow-sm transition-all active:scale-95 cursor-pointer">
    <i class="fa-solid fa-trash"></i>
    <span>Hapus</span>
</button>
```

### 3. Modal Template
```html
<div x-show="confirmModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(15, 23, 42, 0.65);">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div @click.away="confirmModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transition-all text-left">
            
            <!-- Header -->
            <div class="flex items-start justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base leading-tight">Konfirmasi Tindakan</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Tindakan ini memerlukan verifikasi Anda</p>
                    </div>
                </div>
                <button @click="confirmModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- Details -->
            <div class="mt-4 p-4 bg-slate-50/80 rounded-xl border border-slate-200/60 space-y-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">Item</span>
                    <span class="font-mono font-bold text-slate-800" x-text="selectedItem.name"></span>
                </div>
            </div>

            <!-- Actions -->
            <form :action="selectedItem.actionUrl" method="POST" class="mt-6 flex items-center justify-end gap-2.5">
                @csrf
                <button type="button" @click="confirmModal = false" class="px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2.5 text-xs sm:text-sm font-bold text-white bg-red-600 hover:bg-red-700 active:scale-95 rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Ya, Lanjutkan</span>
                </button>
            </form>
        </div>
    </div>
</div>
```
