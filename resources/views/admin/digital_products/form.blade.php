{{--
    Form Produk Digital (Lynk.id) — dipakai oleh create & edit.
    Variabel: $digitalProduct (DigitalProduct|null)
--}}
@php
    $digitalProduct = $digitalProduct ?? null;
    $isEdit = $digitalProduct !== null;
    $thumbnailUrl = $digitalProduct?->thumbnail ? asset('storage/' . $digitalProduct->thumbnail) : null;
@endphp

@if ($errors->any())
<x-admin.alert type="error">
    <p class="font-medium mb-1">Periksa kembali data yang diisi:</p>
    <ul class="list-disc list-inside space-y-0.5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</x-admin.alert>
@endif

<form id="digitalProductForm" method="POST" enctype="multipart/form-data"
    action="{{ $isEdit ? route('admin.digital_products.update', $digitalProduct->id) : route('admin.digital_products.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ================= Kolom utama ================= --}}
        <div class="lg:col-span-2 space-y-6">

            <x-admin.card title="Informasi Produk Digital" icon="fa-solid fa-cubes-stacked">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="nameInput" required>Nama Produk Digital</x-admin.label>
                        <x-admin.input name="name" id="nameInput" :value="old('name', $digitalProduct?->name)" required maxlength="255"
                            placeholder="Contoh: PAKET 3 Source Code Laravel E-Commerce Terbaik" />
                        <x-admin.hint for="name">Nama produk digital yang jelas dan menarik untuk katalog partner.</x-admin.hint>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-admin.label for="lynkSlugInput" required>Kode Produk Lynk.id (lynk_slug)</x-admin.label>
                            <x-admin.input name="lynk_slug" id="lynkSlugInput" :value="old('lynk_slug', $digitalProduct?->lynk_slug)" required maxlength="255"
                                placeholder="Contoh: 1mk10gqm4olk" class="font-mono text-xs" />
                            <x-admin.hint for="lynk_slug">Kode unik di akhir URL produk Lynk.id (misal: lynk.id/a/1035009226/<b>kode</b>).</x-admin.hint>
                        </div>

                        <div>
                            <x-admin.label for="categoryInput">Kategori Produk</x-admin.label>
                            <x-admin.input name="category" id="categoryInput" list="category_list" :value="old('category', $digitalProduct?->category ?? 'Source Code')"
                                placeholder="Pilih atau ketik kategori..." />
                            <datalist id="category_list">
                                <option value="Source Code">
                                <option value="Skripsi & Algoritma">
                                <option value="Template Website">
                                <option value="Trading & Finansial">
                                <option value="E-Book & Panduan">
                            </datalist>
                            <x-admin.hint for="category">Kelompok kategori produk.</x-admin.hint>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-admin.label for="priceInput" required>Harga Jual (Rp)</x-admin.label>
                            <x-admin.input type="number" name="price" id="priceInput" min="0" :value="old('price', $digitalProduct ? (int)$digitalProduct->price : 150000)" required
                                placeholder="150000" />
                            <x-admin.hint for="price">Harga patokan jual di Lynk.id.</x-admin.hint>
                        </div>

                        <div>
                            <x-admin.label for="demoUrlInput">Link Live Demo (Opsional)</x-admin.label>
                            <x-admin.input type="url" name="demo_url" id="demoUrlInput" :value="old('demo_url', $digitalProduct?->demo_url)"
                                placeholder="https://demo.example.com" />
                            <x-admin.hint for="demo_url">Tautan live preview / demo aplikasi jika ada.</x-admin.hint>
                        </div>
                    </div>
                </div>
            </x-admin.card>

            <x-admin.card title="Gambar & Cover" icon="fa-regular fa-image">
                <div>
                    <x-admin.label>Cover / Thumbnail Produk</x-admin.label>
                    <x-admin.image-upload name="thumbnail" :current="$thumbnailUrl" remove-name="remove_thumbnail" max-mb="3" height="h-56" label="cover thumbnail" />
                    <x-admin.hint for="thumbnail">Format: JPG, PNG, JPEG, WEBP (maks. 3MB). Tampil pada kartu katalog partner.</x-admin.hint>
                </div>
            </x-admin.card>

            <x-admin.card title="Deskripsi & Konten" icon="fa-solid fa-align-left">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="shortDescInput">Deskripsi Singkat</x-admin.label>
                        <x-admin.textarea name="short_description" id="shortDescInput" rows="2" maxlength="500"
                            placeholder="Deskripsi ringkas produk untuk pesan share WhatsApp / preview kartu...">{{ old('short_description', $digitalProduct?->short_description) }}</x-admin.textarea>
                        <x-admin.hint for="short_description">Maksimal 500 karakter.</x-admin.hint>
                    </div>

                    <div>
                        <x-admin.label for="descInput">Deskripsi Lengkap</x-admin.label>
                        <x-admin.textarea name="description" id="descInput" rows="6"
                            placeholder="Detail spesifikasi fitur, teknologi yang digunakan, kelengkapan file, atau panduan instalasi...">{{ old('description', $digitalProduct?->description) }}</x-admin.textarea>
                        <x-admin.hint for="description">Rincian lengkap yang membantu partner menjelaskan produk kepada calon pembeli.</x-admin.hint>
                    </div>
                </div>
            </x-admin.card>

        </div>

        {{-- ================= Sidebar ================= --}}
        <div class="space-y-6 lg:sticky lg:top-0">

            <x-admin.card title="Publikasi & Status" icon="fa-solid fa-sliders">
                <div class="space-y-4">
                    <x-admin.toggle name="is_active" label="Status Aktif" description="Tampil di katalog produk Affiliate"
                        :checked="old('is_active', $digitalProduct?->is_active ?? true)" />

                    <div>
                        <x-admin.label for="displayOrderInput">Urutan Tampilan</x-admin.label>
                        <x-admin.input type="number" name="display_order" id="displayOrderInput"
                            :value="old('display_order', $digitalProduct?->display_order ?? 0)" min="0" placeholder="0" />
                        <x-admin.hint for="display_order">Nomor urut tampil (semakin kecil semakin awal).</x-admin.hint>
                    </div>

                    @if ($isEdit)
                    <div>
                        <x-admin.label for="slugInput" required>Slug URL Sistem</x-admin.label>
                        <x-admin.input name="slug" id="slugInput" :value="old('slug', $digitalProduct->slug)" required maxlength="255" class="font-mono text-xs" />
                        <x-admin.hint for="slug">Slug pengenal unik URL sistem internal.</x-admin.hint>
                    </div>
                    @endif
                </div>

                <div class="mt-5 pt-5 border-t border-slate-200 space-y-2">
                    <x-admin.button type="submit" class="w-full" icon="fa-solid fa-floppy-disk">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Produk' }}
                    </x-admin.button>
                    <x-admin.button variant="secondary" class="w-full" :href="route('admin.digital_products.index')">
                        Batal
                    </x-admin.button>
                </div>

                @if ($isEdit)
                <dl class="mt-5 pt-5 border-t border-slate-200 space-y-2 text-xs">
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">ID Produk</dt>
                        <dd class="text-slate-700 font-mono font-medium">#{{ $digitalProduct->id }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">Dibuat</dt>
                        <dd class="text-slate-700 font-medium">{{ $digitalProduct->created_at?->format('d M Y, H:i') ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">Diperbarui</dt>
                        <dd class="text-slate-700 font-medium">{{ $digitalProduct->updated_at?->format('d M Y, H:i') ?? '-' }}</dd>
                    </div>
                </dl>
                @endif
            </x-admin.card>

        </div>

    </div>
</form>

