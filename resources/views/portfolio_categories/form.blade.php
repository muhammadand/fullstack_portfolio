@php
    $item = $item ?? null;
    $isEdit = $item !== null;
@endphp

@if ($errors->any())
<x-admin.alert type="error">
    <p class="font-medium mb-1">Periksa kembali isian berikut:</p>
    <ul class="list-disc list-inside space-y-0.5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</x-admin.alert>
@endif

<form id="categoryForm" method="POST"
    action="{{ $isEdit ? route('portfolio-categories.update', $item->id) : route('portfolio-categories.store') }}"
    data-slug-locked="{{ $isEdit || old('slug') ? '1' : '0' }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ================= Kolom utama ================= --}}
        <div class="lg:col-span-2 space-y-6">
            <x-admin.card title="Informasi Kategori" icon="fa-solid fa-folder-tree">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="nameInput" required>Nama Kategori</x-admin.label>
                        <x-admin.input name="name" id="nameInput" :value="old('name', $item?->name)" required maxlength="100"
                            placeholder="Contoh: Web Development, Mobile Apps" />
                        <x-admin.hint for="name" />
                    </div>

                    <div>
                        <x-admin.label for="slugInput" required>Slug</x-admin.label>
                        <x-admin.input name="slug" id="slugInput" :value="old('slug', $item?->slug)" required maxlength="100"
                            placeholder="otomatis-dari-nama" />
                        <x-admin.hint for="slug">URL unik untuk kategori ini (dibuat otomatis dari nama).</x-admin.hint>
                    </div>

                    <div>
                        <x-admin.label for="descriptionInput">Deskripsi</x-admin.label>
                        <x-admin.textarea name="description" id="descriptionInput" rows="3"
                            placeholder="Deskripsi singkat mengenai kategori portfolio ini...">{{ old('description', $item?->description) }}</x-admin.textarea>
                        <x-admin.hint for="description" />
                    </div>
                </div>
            </x-admin.card>
        </div>

        {{-- ================= Sidebar ================= --}}
        <div class="space-y-6 lg:sticky lg:top-0">
            <x-admin.card title="Pengaturan" icon="fa-solid fa-sliders">
                <div class="space-y-4">
                    <x-admin.toggle name="is_active" label="Status Aktif" description="Kategori tampil di pilihan publik"
                        :checked="old('is_active', $item?->is_active ?? true)" />

                    <div>
                        <x-admin.label for="displayOrderInput">Urutan Tampilan</x-admin.label>
                        <x-admin.input type="number" name="display_order" id="displayOrderInput"
                            :value="old('display_order', $item?->display_order ?? 0)" min="0" placeholder="0" />
                        <x-admin.hint for="display_order">Nomor urut prioritas tampil (semakin kecil semakin awal).</x-admin.hint>
                    </div>
                </div>

                <div class="mt-5 pt-5 border-t border-slate-200 space-y-2">
                    <x-admin.button type="submit" class="w-full" icon="fa-solid fa-floppy-disk">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Kategori' }}
                    </x-admin.button>
                    <x-admin.button variant="secondary" class="w-full" :href="route('portfolio-categories.index')">
                        Batal
                    </x-admin.button>
                </div>
            </x-admin.card>
        </div>

    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('categoryForm');
        if (!form) return;
        const name = form.querySelector('#nameInput');
        const slug = form.querySelector('#slugInput');
        let locked = form.dataset.slugLocked === '1';

        slug.addEventListener('input', () => { locked = slug.value !== ''; });
        name.addEventListener('input', () => {
            if (locked) return;
            slug.value = name.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        });
    });
</script>
