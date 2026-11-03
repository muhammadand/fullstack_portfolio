{{--
    Form blog — dipakai oleh create & edit.
    Variabel: $blog (Blog|null), $categories, $authors
--}}
@php
    $blog = $blog ?? null;
    $isEdit = $blog !== null;
    $tags = old('tags', $blog?->tags ?? []);
    $tagsValue = is_array($tags) ? implode(', ', $tags) : $tags;
    $currentImage = $blog?->featured_image ? asset('storage/' . $blog->featured_image) : null;
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

<form id="blogForm" method="POST" enctype="multipart/form-data"
    action="{{ $isEdit ? route('blogs.update', $blog) : route('blogs.store') }}"
    data-ai-url="{{ route('blogs.generate_ai') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <input type="hidden" name="reading_time" id="readingTimeInput" value="{{ old('reading_time', $blog?->reading_time) }}">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ================= Kolom utama ================= --}}
        <div class="lg:col-span-2 space-y-6">

            <x-admin.card title="Informasi Artikel" icon="fa-solid fa-heading">
                <x-slot:actions>
                    <x-admin.button variant="soft" size="sm" icon="fa-solid fa-wand-magic-sparkles" id="btnGenerateAi">
                        Generate dengan AI
                    </x-admin.button>
                </x-slot:actions>

                <div class="space-y-4">
                    <div>
                        <x-admin.label for="titleInput" required>Judul</x-admin.label>
                        <x-admin.input name="title" id="titleInput" :value="old('title', $blog?->title)" required maxlength="200"
                            placeholder="Judul artikel yang menarik" />
                        <x-admin.hint for="title" />
                    </div>

                    <div>
                        <x-admin.label for="excerptInput">Ringkasan</x-admin.label>
                        <x-admin.textarea name="excerpt" id="excerptInput" rows="2" maxlength="255"
                            placeholder="Ringkasan singkat (otomatis diambil dari konten jika kosong)">{{ old('excerpt', $blog?->excerpt) }}</x-admin.textarea>
                        <x-admin.hint for="excerpt">Ideal maksimal 160 karakter.</x-admin.hint>
                    </div>
                </div>
            </x-admin.card>

            <x-admin.card title="Gambar Unggulan" icon="fa-solid fa-image">
                <x-admin.image-upload name="featured_image" :current="$currentImage" remove-name="remove_image" height="h-56" label="gambar unggulan" />
                <x-admin.hint for="featured_image" />
            </x-admin.card>

            <x-admin.card title="Konten" icon="fa-solid fa-align-left">
                <x-slot:actions>
                    <span class="text-xs text-slate-500">
                        <span id="wordCount">0 kata</span> &middot; <span id="readingTime">0 menit baca</span>
                    </span>
                </x-slot:actions>

                <x-admin.rich-editor name="content" :value="old('content', $blog?->content)" :upload-url="route('blogs.upload-image')" placeholder="Mulai menulis artikel di sini..." />
                <x-admin.hint for="content" />
            </x-admin.card>
        </div>

        {{-- ================= Sidebar ================= --}}
        <div class="space-y-6 lg:sticky lg:top-0">

            <x-admin.card title="Publikasi" icon="fa-solid fa-paper-plane">
                <div class="space-y-4">
                    <x-admin.toggle name="is_published" id="isPublishedInput" label="Publikasikan"
                        description="Tampil di halaman blog publik"
                        :checked="old('is_published', $blog?->is_published)" />
                    <x-admin.toggle name="is_featured" label="Artikel Unggulan"
                        description="Ditampilkan di bagian highlight"
                        :checked="old('is_featured', $blog?->is_featured)" />
                </div>

                <div class="mt-5 pt-5 border-t border-slate-200 space-y-2">
                    <x-admin.button type="submit" class="w-full" icon="fa-solid fa-floppy-disk">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Artikel' }}
                    </x-admin.button>
                    <x-admin.button variant="secondary" class="w-full" id="btnSaveDraft">
                        Simpan sebagai Draft
                    </x-admin.button>
                </div>

                @if ($isEdit)
                <dl class="mt-5 pt-5 border-t border-slate-200 space-y-1.5 text-xs">
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Dibuat</dt><dd class="text-slate-700">{{ $blog->created_at?->format('d M Y, H:i') }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Diperbarui</dt><dd class="text-slate-700">{{ $blog->updated_at?->format('d M Y, H:i') }}</dd></div>
                    @if ($blog->slug)
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Slug</dt><dd class="text-slate-700 truncate" title="{{ $blog->slug }}">{{ $blog->slug }}</dd></div>
                    @endif
                </dl>
                @endif
            </x-admin.card>

            <x-admin.card title="Klasifikasi" icon="fa-solid fa-folder-tree">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="categoryInput" required>Kategori</x-admin.label>
                        <x-admin.select name="category_id" id="categoryInput" required placeholder="Pilih kategori"
                            :options="$categories->pluck('name', 'id')" :selected="old('category_id', $blog?->category_id)" />
                        <x-admin.hint for="category_id" />
                    </div>

                    <div>
                        <x-admin.label for="authorInput" required>Penulis</x-admin.label>
                        <x-admin.select name="author_id" id="authorInput" required placeholder="Pilih penulis"
                            :options="$authors->pluck('name', 'id')" :selected="old('author_id', $blog?->author_id)" />
                        <x-admin.hint for="author_id" />
                    </div>

                    <div>
                        <x-admin.label for="tagsInput">Tags</x-admin.label>
                        <x-admin.input name="tags[]" id="tagsInput" :value="$tagsValue" placeholder="Laravel, Tutorial, Web" />
                        <x-admin.hint for="tags">Pisahkan dengan koma.</x-admin.hint>
                    </div>
                </div>
            </x-admin.card>

            <x-admin.card title="SEO" icon="fa-solid fa-magnifying-glass">
                <div class="space-y-4">
                    <div>
                        <x-admin.label for="metaTitleInput">Meta Title</x-admin.label>
                        <x-admin.input name="meta_title" id="metaTitleInput" :value="old('meta_title', $blog?->meta_title)" maxlength="60"
                            placeholder="Otomatis dari judul jika kosong" />
                        <x-admin.hint for="meta_title">Maksimal 60 karakter.</x-admin.hint>
                    </div>
                    <div>
                        <x-admin.label for="metaDescriptionInput">Meta Description</x-admin.label>
                        <x-admin.textarea name="meta_description" id="metaDescriptionInput" rows="3" maxlength="160"
                            placeholder="Otomatis dari ringkasan jika kosong">{{ old('meta_description', $blog?->meta_description) }}</x-admin.textarea>
                        <x-admin.hint for="meta_description">Maksimal 160 karakter.</x-admin.hint>
                    </div>
                </div>
            </x-admin.card>
        </div>
    </div>
</form>

@include('blogs.partials.editor-scripts')
