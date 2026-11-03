{{--
    Form portfolio — dipakai oleh create & edit.
    Variabel: $item (Portfolio|null), $categories
--}}
@php
    $item = $item ?? null;
    $isEdit = $item !== null;
    $technologies = old('technologies', $item?->technologies ?? []);
    $technologiesValue = is_array($technologies) ? implode(', ', $technologies) : $technologies;
    $imageUrl = fn (?string $path) => $path ? asset('storage/' . $path) : null;
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

<form id="portfolioForm" method="POST" enctype="multipart/form-data"
    action="{{ $isEdit ? route('portfolio.update', $item) : route('portfolio.store') }}"
    data-slug-locked="{{ $isEdit || old('slug') ? '1' : '0' }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ================= Kolom utama ================= --}}
        <div class="lg:col-span-2 space-y-6">

            <x-admin.card title="Informasi Proyek" icon="fa-solid fa-heading">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="titleInput" required>Judul</x-admin.label>
                        <x-admin.input name="title" id="titleInput" :value="old('title', $item?->title)" required maxlength="200"
                            placeholder="Contoh: Website Company Profile PT Example" />
                        <x-admin.hint for="title" />
                    </div>

                    <div>
                        <x-admin.label for="slugInput">Slug</x-admin.label>
                        <x-admin.input name="slug" id="slugInput" :value="old('slug', $item?->slug)" maxlength="200" placeholder="otomatis-dari-judul" />
                        <x-admin.hint for="slug">Kosongkan untuk dibuat otomatis dari judul.</x-admin.hint>
                    </div>

                    <div>
                        <x-admin.label for="shortDescriptionInput" required>Deskripsi Singkat</x-admin.label>
                        <x-admin.textarea name="short_description" id="shortDescriptionInput" rows="2" required maxlength="255"
                            placeholder="Ringkasan singkat proyek">{{ old('short_description', $item?->short_description) }}</x-admin.textarea>
                        <x-admin.hint for="short_description">Maksimal 255 karakter.</x-admin.hint>
                    </div>
                </div>
            </x-admin.card>

            <x-admin.card title="Gambar" icon="fa-solid fa-image">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-admin.label required>Thumbnail</x-admin.label>
                        <x-admin.image-upload name="thumbnail_image" :current="$imageUrl($item?->thumbnail_image)" max-mb="20" height="h-40" label="thumbnail" />
                        <x-admin.hint for="thumbnail_image">Tampil di kartu daftar portfolio.</x-admin.hint>
                    </div>
                    <div>
                        <x-admin.label>Gambar Utama</x-admin.label>
                        <x-admin.image-upload name="featured_image" :current="$imageUrl($item?->featured_image)" remove-name="remove_featured_image" max-mb="20" height="h-40" label="gambar utama" />
                        <x-admin.hint for="featured_image">Tampil di halaman detail portfolio.</x-admin.hint>
                    </div>
                </div>
            </x-admin.card>

            <x-admin.card title="Deskripsi Lengkap" icon="fa-solid fa-align-left">
                <x-admin.rich-editor name="full_description" :value="old('full_description', $item?->full_description)"
                    :upload-url="route('portfolio.upload-image')" placeholder="Tulis deskripsi lengkap proyek di sini..." />
                <x-admin.hint for="full_description" />
            </x-admin.card>

            <x-admin.card title="Studi Kasus" icon="fa-solid fa-lightbulb">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="challengeInput">Tantangan</x-admin.label>
                        <x-admin.textarea name="challenge" id="challengeInput" rows="3"
                            placeholder="Masalah atau tantangan yang dihadapi">{{ old('challenge', $item?->challenge) }}</x-admin.textarea>
                    </div>
                    <div>
                        <x-admin.label for="solutionInput">Solusi</x-admin.label>
                        <x-admin.textarea name="solution" id="solutionInput" rows="3"
                            placeholder="Bagaimana masalah diselesaikan">{{ old('solution', $item?->solution) }}</x-admin.textarea>
                    </div>
                    <div>
                        <x-admin.label for="resultInput">Hasil</x-admin.label>
                        <x-admin.textarea name="result" id="resultInput" rows="3"
                            placeholder="Hasil yang dicapai dari proyek ini">{{ old('result', $item?->result) }}</x-admin.textarea>
                    </div>
                </div>
            </x-admin.card>
        </div>

        {{-- ================= Sidebar ================= --}}
        <div class="space-y-6 lg:sticky lg:top-0">

            <x-admin.card title="Publikasi" icon="fa-solid fa-paper-plane">
                <div class="space-y-4">
                    <x-admin.toggle name="is_active" label="Aktif" description="Tampil di halaman portfolio publik"
                        :checked="old('is_active', $item?->is_active ?? true)" />
                    <x-admin.toggle name="is_featured" label="Portfolio Unggulan" description="Ditampilkan di bagian highlight"
                        :checked="old('is_featured', $item?->is_featured)" />
                </div>

                <div class="mt-5 pt-5 border-t border-slate-200 space-y-2">
                    <x-admin.button type="submit" class="w-full" icon="fa-solid fa-floppy-disk">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Portfolio' }}
                    </x-admin.button>
                    <x-admin.button variant="secondary" class="w-full" :href="route('portfolio.index')">Batal</x-admin.button>
                </div>
            </x-admin.card>

            <x-admin.card title="Detail Proyek" icon="fa-solid fa-circle-info">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="categoryInput" required>Kategori</x-admin.label>
                        <x-admin.select name="category_id" id="categoryInput" required placeholder="Pilih kategori"
                            :options="$categories->pluck('name', 'id')" :selected="old('category_id', $item?->category_id)" />
                        <x-admin.hint for="category_id" />
                    </div>

                    <div>
                        <x-admin.label for="clientNameInput">Nama Klien</x-admin.label>
                        <x-admin.input name="client_name" id="clientNameInput" :value="old('client_name', $item?->client_name)" maxlength="100" placeholder="PT Example Indonesia" />
                        <x-admin.hint for="client_name" />
                    </div>

                    <div>
                        <x-admin.label for="projectTypeInput">Jenis Proyek</x-admin.label>
                        <x-admin.input name="project_type" id="projectTypeInput" :value="old('project_type', $item?->project_type)" maxlength="100" placeholder="Website E-Commerce" />
                        <x-admin.hint for="project_type" />
                    </div>

                    <div>
                        <x-admin.label for="technologiesInput">Teknologi</x-admin.label>
                        <x-admin.input name="technologies" id="technologiesInput" :value="$technologiesValue" placeholder="Laravel, Vue.js, MySQL" />
                        <x-admin.hint for="technologies">Pisahkan dengan koma.</x-admin.hint>
                    </div>

                    <div>
                        <x-admin.label for="completionDateInput">Tanggal Selesai</x-admin.label>
                        <x-admin.input type="date" name="completion_date" id="completionDateInput"
                            :value="old('completion_date', $item?->completion_date?->format('Y-m-d'))" />
                        <x-admin.hint for="completion_date" />
                    </div>
                </div>
            </x-admin.card>

            <x-admin.card title="Tautan" icon="fa-solid fa-link">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="projectUrlInput">URL Proyek</x-admin.label>
                        <x-admin.input type="url" name="project_url" id="projectUrlInput" :value="old('project_url', $item?->project_url)" placeholder="https://example.com" />
                        <x-admin.hint for="project_url" />
                    </div>
                    <div>
                        <x-admin.label for="githubUrlInput">URL GitHub</x-admin.label>
                        <x-admin.input type="url" name="github_url" id="githubUrlInput" :value="old('github_url', $item?->github_url)" placeholder="https://github.com/username/repo" />
                        <x-admin.hint for="github_url" />
                    </div>
                </div>
            </x-admin.card>
        </div>
    </div>
</form>

{{-- Slug otomatis dari judul (hanya saat membuat baru; slug lama tidak diubah agar URL tidak rusak) --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('portfolioForm');
        const title = form.querySelector('#titleInput');
        const slug = form.querySelector('#slugInput');
        let locked = form.dataset.slugLocked === '1';

        slug.addEventListener('input', () => { locked = slug.value !== ''; });
        title.addEventListener('input', () => {
            if (locked) return;
            slug.value = title.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        });
    });
</script>
