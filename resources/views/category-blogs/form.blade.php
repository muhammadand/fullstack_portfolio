@php
    $category = $category ?? null;
    $isEdit = $category !== null;
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

<form id="categoryBlogForm" method="POST"
    action="{{ $isEdit ? route('blog-categories.update', $category->id) : route('blog-categories.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ================= Kolom utama ================= --}}
        <div class="lg:col-span-2 space-y-6">
            <x-admin.card title="Informasi Kategori" icon="fa-solid fa-folder-tree">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="nameInput" required>Nama Kategori</x-admin.label>
                        <x-admin.input name="name" id="nameInput" :value="old('name', $category?->name)" required maxlength="255"
                            placeholder="Contoh: Tips Bisnis, Teknologi, Tutorial" />
                        <x-admin.hint for="name" />
                    </div>

                    <div>
                        <x-admin.label for="descriptionInput">Deskripsi</x-admin.label>
                        <x-admin.textarea name="description" id="descriptionInput" rows="3"
                            placeholder="Deskripsi singkat mengenai kategori artikel blog ini...">{{ old('description', $category?->description) }}</x-admin.textarea>
                        <x-admin.hint for="description" />
                    </div>

                    <div>
                        <x-admin.label for="metaDescriptionInput">Meta Deskripsi</x-admin.label>
                        <x-admin.textarea name="meta_description" id="metaDescriptionInput" rows="2" maxlength="255"
                            placeholder="Ringkasan SEO untuk kategori ini (opsional)">{{ old('meta_description', $category?->meta_description) }}</x-admin.textarea>
                        <x-admin.hint for="meta_description">Maksimal 255 karakter.</x-admin.hint>
                    </div>
                </div>
            </x-admin.card>
        </div>

        {{-- ================= Sidebar ================= --}}
        <div class="space-y-6 lg:sticky lg:top-0">
            <x-admin.card title="Pengaturan" icon="fa-solid fa-sliders">
                <div class="space-y-4">
                    <x-admin.toggle name="is_active" label="Status Aktif" description="Kategori tampil di blog publik"
                        :checked="old('is_active', $category?->is_active ?? true)" />

                    <div>
                        <x-admin.label for="displayOrderInput">Urutan Tampilan</x-admin.label>
                        <x-admin.input type="number" name="display_order" id="displayOrderInput"
                            :value="old('display_order', $category?->display_order ?? 0)" min="0" placeholder="0" />
                        <x-admin.hint for="display_order">Nomor urut prioritas tampil (semakin kecil semakin awal).</x-admin.hint>
                    </div>
                </div>

                <div class="mt-5 pt-5 border-t border-slate-200 space-y-2">
                    <x-admin.button type="submit" class="w-full" icon="fa-solid fa-floppy-disk">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Kategori' }}
                    </x-admin.button>
                    <x-admin.button variant="secondary" class="w-full" :href="route('blog-categories.index')">
                        Batal
                    </x-admin.button>
                </div>

                @if ($isEdit && $category->created_at)
                <dl class="mt-5 pt-5 border-t border-slate-200 space-y-1.5 text-xs">
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Dibuat</dt><dd class="text-slate-700">{{ \Carbon\Carbon::parse($category->created_at)->format('d M Y, H:i') }}</dd></div>
                    @if ($category->slug)
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Slug</dt><dd class="text-slate-700 truncate" title="{{ $category->slug }}">{{ $category->slug }}</dd></div>
                    @endif
                </dl>
                @endif
            </x-admin.card>
        </div>

    </div>
</form>

