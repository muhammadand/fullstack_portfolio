@extends('layouts.admin.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            {{-- Header --}}
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('blogs.index') }}" class="p-1.5 hover:bg-gray-200 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Buat Blog Baru</h1>
                        <p class="text-sm text-gray-600">Tulis dan publikasikan artikel Anda</p>
                    </div>
                </div>
            </div>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-sm text-red-800 font-medium mb-1">Terdapat beberapa kesalahan:</h3>
                            <ul class="list-disc list-inside text-sm text-red-700 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    {{-- Main Content --}}
                    <div class="lg:col-span-2 space-y-4">
                        {{-- Title --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Blog <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="titleInput" value="{{ old('title') }}" required
                                placeholder="Masukkan judul blog yang menarik..."
                                class="w-full text-xl font-semibold border-0 border-b-2 border-gray-200 px-0 py-2 focus:border-purple-500 focus:ring-0 placeholder-gray-400">
                        </div>

                        {{-- Featured Image --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Unggulan</label>
                            <div class="relative">
                                <div id="imagePreview" class="hidden mb-3">
                                    <img id="previewImg" class="w-full h-48 object-cover rounded-lg" alt="Preview">
                                    <button type="button" id="removeImage"
                                        class="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-full hover:bg-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <label for="imageInput" id="imageUploadArea"
                                    class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 hover:bg-purple-50 transition-all">
                                    <svg class="w-10 h-10 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm text-gray-600"><span class="font-medium">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG atau JPEG (MAX. 2MB)</p>
                                </label>
                                <input type="file" name="featured_image" id="imageInput" accept="image/*" class="hidden">
                            </div>
                        </div>

                        {{-- Content Editor --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Konten Blog <span class="text-red-500">*</span>
                            </label>
                            <div id="quillEditor" class="bg-white" style="min-height: 300px;">
                                {!! old('content') !!}
                            </div>
                            <input type="hidden" name="content" id="contentInput">
                            <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span id="wordCount">0 kata</span>
                                <span class="mx-1">•</span>
                                <span id="readingTime">0 menit baca</span>
                            </div>
                        </div>

                        {{-- Excerpt --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt (Opsional)</label>
                            <textarea name="excerpt" id="excerptInput" rows="2"
                                placeholder="Ringkasan singkat artikel (otomatis diambil dari konten jika kosong)"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none">{{ old('excerpt') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Maksimal 160 karakter untuk hasil optimal</p>
                        </div>
                    </div>

                    {{-- Sidebar --}}
                    <div class="lg:col-span-1 space-y-4">
                        {{-- Publish Settings --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 lg:sticky lg:top-4">
                            <h3 class="text-base font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Pengaturan
                            </h3>

                            <div class="space-y-3">
                                {{-- Category --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <select name="category_id" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Author --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Penulis <span class="text-red-500">*</span>
                                    </label>
                                    <select name="author_id" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="">Pilih Penulis</option>
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                                {{ $author->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Tags --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tags</label>
                                    <input type="text" name="tags[]"
                                        value="{{ old('tags') ? implode(',', old('tags')) : '' }}"
                                        placeholder="Laravel, Tutorial, Web"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <p class="mt-1 text-xs text-gray-500">Pisahkan dengan koma</p>
                                </div>

                                {{-- SEO Fields --}}
                                <div class="pt-3 border-t border-gray-200 space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Meta Title</label>
                                        <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                                            placeholder="Otomatis dari judul jika kosong"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Meta Description</label>
                                        <textarea name="meta_description" rows="2" placeholder="Otomatis dari excerpt jika kosong"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none">{{ old('meta_description') }}</textarea>
                                    </div>
                                </div>

                                {{-- Toggles --}}
                                <div class="pt-3 border-t border-gray-200 space-y-2">
                                    <label class="flex items-center justify-between cursor-pointer">
                                        <span class="text-sm font-medium text-gray-700">Featured</span>
                                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                            class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600">
                                    </label>

                                    <label class="flex items-center justify-between cursor-pointer">
                                        <span class="text-sm font-medium text-gray-700">Publikasikan</span>
                                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                                            class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600">
                                    </label>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-4 space-y-2">
                                <button type="submit"
                                    class="w-full bg-purple-600 text-white font-medium py-2.5 px-4 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-300 transition-colors">
                                    <span class="flex items-center justify-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Publikasikan Blog
                                    </span>
                                </button>
                                <button type="button"
                                    onclick="document.querySelector('input[name=is_published]').checked = false; document.getElementById('blogForm').submit();"
                                    class="w-full bg-white text-gray-700 font-medium py-2.5 px-4 rounded-lg border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors text-sm">
                                    Simpan sebagai Draft
                                </button>
                            </div>
                        </div>


                    </div>
                </div>

                <input type="hidden" name="reading_time" id="readingTimeInput">
            </form>
        </div>
    </div>

    {{-- Link Modal --}}
    <div id="linkModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-lg p-5 w-full max-w-md shadow-xl">
            <h3 class="text-lg font-bold text-gray-900 mb-3">Tambah Link</h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Teks Link</label>
                    <input type="text" id="linkText" placeholder="Contoh: Kunjungi website kami"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">URL</label>
                    <input type="text" id="linkHref" placeholder="https://example.com"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>
            <div class="flex gap-2 mt-4">
                <button id="linkCancel"
                    class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors text-sm">
                    Batal
                </button>
                <button id="linkInsert"
                    class="flex-1 px-4 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors text-sm">
                    Tambah Link
                </button>
            </div>
        </div>
    </div>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        // Initialize Quill Editor
        const quill = new Quill('#quillEditor', {
            theme: 'snow',
            placeholder: 'Mulai menulis cerita Anda di sini...',
            modules: {
                toolbar: {
                    container: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        ['blockquote', 'code-block'],
                        ['link', 'image'],
                        [{ 'align': [] }],
                        ['clean']
                    ],
                    handlers: {
                        'link': () => document.getElementById('linkModal').classList.remove('hidden')
                    }
                }
            }
        });

        // Word Count & Reading Time (Debounced)
        let statsTimeout;
        function updateStats() {
            clearTimeout(statsTimeout);
            statsTimeout = setTimeout(() => {
                const text = quill.getText().trim();
                const words = text ? text.split(/\s+/).length : 0;
                const readingTime = Math.ceil(words / 200);

                document.getElementById('wordCount').textContent = words + ' kata';
                document.getElementById('readingTime').textContent = readingTime + ' menit baca';
                document.getElementById('readingTimeInput').value = readingTime;
            }, 300);
        }

        quill.on('text-change', updateStats);
        updateStats();

        // Image Preview (Optimized)
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const imageUploadArea = document.getElementById('imageUploadArea');

        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.size <= 2097152) { // 2MB check
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    imageUploadArea.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else if (file) {
                alert('Ukuran file maksimal 2MB');
                imageInput.value = '';
            }
        });

        document.getElementById('removeImage').addEventListener('click', () => {
            imageInput.value = '';
            imagePreview.classList.add('hidden');
            imageUploadArea.classList.remove('hidden');
        });

        // Link Modal (Optimized)
        const linkModal = document.getElementById('linkModal');
        const linkText = document.getElementById('linkText');
        const linkHref = document.getElementById('linkHref');

        document.getElementById('linkCancel').addEventListener('click', () => {
            linkModal.classList.add('hidden');
            linkText.value = '';
            linkHref.value = '';
        });

        document.getElementById('linkInsert').addEventListener('click', () => {
            if (linkText.value && linkHref.value) {
                const range = quill.getSelection(true);
                if (range) {
                    quill.deleteText(range.index, range.length);
                    quill.insertText(range.index, linkText.value, { link: linkHref.value });
                }
            }
            linkModal.classList.add('hidden');
            linkText.value = '';
            linkHref.value = '';
        });

        // Form Submit
        document.getElementById('blogForm').addEventListener('submit', () => {
            document.getElementById('contentInput').value = quill.root.innerHTML;
        });

        // Auto-fill meta title
        document.getElementById('titleInput').addEventListener('input', (e) => {
            const metaTitleInput = document.querySelector('input[name="meta_title"]');
            if (!metaTitleInput.value) {
                metaTitleInput.placeholder = e.target.value || 'Otomatis dari judul jika kosong';
            }
        });
    </script>

    <style>
        .ql-container { font-size: 15px; }
        .ql-editor { min-height: 300px; padding: 16px; }
        .ql-editor.ql-blank::before { color: #9ca3af; font-style: normal; }
        
        /* Toggle Switch Styling */
        input[type="checkbox"] { position: relative; width: 2.25rem; height: 1.25rem; appearance: none; background: #e5e7eb; border-radius: 9999px; cursor: pointer; transition: all 0.2s; }
        input[type="checkbox"]:checked { background: #9333ea; }
        input[type="checkbox"]::after { content: ''; position: absolute; top: 2px; left: 2px; width: 1rem; height: 1rem; background: white; border-radius: 50%; transition: all 0.2s; }
        input[type="checkbox"]:checked::after { transform: translateX(1rem); }
    </style>
@endsection