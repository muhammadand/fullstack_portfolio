{{--
    Form Dokumentasi — dipakai oleh create & edit.
    Variabel: $documentation (Documentation|null)
--}}
@php
    $documentation = $documentation ?? null;
    $isEdit = $documentation !== null;
    $imageUrl = $documentation?->images ? asset('images/' . $documentation->images) : null;
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

<form id="documentationForm" method="POST" enctype="multipart/form-data"
    action="{{ $isEdit ? route('documentation.update', $documentation->slug) : route('documentation.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ================= Kolom utama ================= --}}
        <div class="lg:col-span-2 space-y-6">

            <x-admin.card title="Informasi Dokumentasi" icon="fa-solid fa-camera">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="titleInput" required>Judul / Nama Dokumentasi</x-admin.label>
                        <x-admin.input name="title" id="titleInput" :value="old('title', $documentation?->title)" required maxlength="200"
                            placeholder="Contoh: Workshop Digital Marketing Scalify" />
                        <x-admin.hint for="title">Judul singkat atau nama kegiatan dokumentasi.</x-admin.hint>
                    </div>

                    @if ($isEdit)
                    <div>
                        <x-admin.label for="slugInput">Slug URL</x-admin.label>
                        <x-admin.input name="slug_display" id="slugInput" :value="$documentation->slug" disabled class="bg-slate-50 cursor-not-allowed font-mono text-xs" />
                        <x-admin.hint for="slug">Slug dibuat otomatis dan digunakan sebagai pengenal unik.</x-admin.hint>
                    </div>
                    @endif
                </div>
            </x-admin.card>

            <x-admin.card title="Foto Dokumentasi" icon="fa-regular fa-image">
                <div>
                    <x-admin.label>File Foto</x-admin.label>
                    <x-admin.image-upload name="images" :current="$imageUrl" remove-name="remove_images" max-mb="10" height="h-64" label="foto dokumentasi" />
                    <x-admin.hint for="images">Format: PNG, JPG, JPEG (maks. 10MB).</x-admin.hint>
                </div>
            </x-admin.card>

        </div>

        {{-- ================= Sidebar ================= --}}
        <div class="space-y-6 lg:sticky lg:top-0">

            <x-admin.card title="Publikasi" icon="fa-solid fa-paper-plane">
                <div class="space-y-2">
                    <x-admin.button type="submit" class="w-full" icon="fa-solid fa-floppy-disk">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Foto' }}
                    </x-admin.button>
                    <x-admin.button variant="secondary" class="w-full" :href="route('documentation.index')">
                        Batal
                    </x-admin.button>
                </div>

                @if ($isEdit)
                <dl class="mt-5 pt-5 border-t border-slate-200 space-y-2 text-xs">
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">Dibuat</dt>
                        <dd class="text-slate-700 font-medium">{{ $documentation->created_at?->format('d M Y, H:i') ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">Diperbarui</dt>
                        <dd class="text-slate-700 font-medium">{{ $documentation->updated_at?->format('d M Y, H:i') ?? '-' }}</dd>
                    </div>
                    @if ($documentation->slug)
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">ID / Slug</dt>
                        <dd class="text-slate-700 font-mono truncate max-w-[150px]" title="{{ $documentation->slug }}">{{ $documentation->slug }}</dd>
                    </div>
                    @endif
                </dl>
                @endif
            </x-admin.card>

        </div>

    </div>
</form>

