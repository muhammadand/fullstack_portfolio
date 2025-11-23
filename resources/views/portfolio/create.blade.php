@extends('layouts.admin.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            {{-- Header --}}
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('portfolio.index') }}" class="p-1.5 hover:bg-gray-200 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Tambah Portfolio Baru</h1>
                        <p class="text-sm text-gray-600">Showcase karya terbaik Anda</p>
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

            <form action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data" id="portfolioForm">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    {{-- Main Content --}}
                    <div class="lg:col-span-2 space-y-4">
                        {{-- Title & Slug --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Portfolio <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="titleInput" value="{{ old('title') }}" required
                                placeholder="Masukkan judul portfolio..."
                                class="w-full text-xl font-semibold border-0 border-b-2 border-gray-200 px-0 py-2 focus:border-blue-500 focus:ring-0 placeholder-gray-400 mb-3">
                            
                            <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                            <input type="text" name="slug" id="slugInput" value="{{ old('slug') }}"
                                placeholder="otomatis-dari-judul"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Kosongkan untuk generate otomatis dari judul</p>
                        </div>

                        {{-- Images --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Gambar Portfolio</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                {{-- Thumbnail --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail</label>
                                    <div class="relative">
                                        <div id="thumbnailPreview" class="hidden mb-3">
                                            <img id="thumbnailImg" class="w-full h-32 object-cover rounded-lg" alt="Thumbnail">
                                            <button type="button" id="removeThumbnail"
                                                class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <label for="thumbnailInput" id="thumbnailUploadArea"
                                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all">
                                            <svg class="w-8 h-8 mb-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-xs text-gray-600">Upload Thumbnail</p>
                                        </label>
                                        <input type="file" name="thumbnail_image" id="thumbnailInput" accept="image/*" class="hidden">
                                    </div>
                                </div>

                                {{-- Featured Image --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                                    <div class="relative">
                                        <div id="featuredPreview" class="hidden mb-3">
                                            <img id="featuredImg" class="w-full h-32 object-cover rounded-lg" alt="Featured">
                                            <button type="button" id="removeFeatured"
                                                class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <label for="featuredInput" id="featuredUploadArea"
                                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all">
                                            <svg class="w-8 h-8 mb-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-xs text-gray-600">Upload Featured</p>
                                        </label>
                                        <input type="file" name="featured_image" id="featuredInput" accept="image/*" class="hidden">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Singkat <span class="text-red-500">*</span>
                            </label>
                            <textarea name="short_description" rows="2" required
                                placeholder="Ringkasan singkat portfolio (maks 160 karakter)"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('short_description') }}</textarea>
                        </div>

                        {{-- Full Description WYSIWYG --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div id="quillEditor" class="bg-white" style="min-height: 300px;">
                                {!! old('full_description') !!}
                            </div>
                            <input type="hidden" name="full_description" id="descriptionInput">
                        </div>

                        {{-- Challenge, Solution, Result --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Detail Proyek</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tantangan</label>
                                    <textarea name="challenge" rows="2" placeholder="Masalah atau tantangan yang dihadapi..."
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('challenge') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Solusi</label>
                                    <textarea name="solution" rows="2" placeholder="Bagaimana Anda menyelesaikan masalah..."
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('solution') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Hasil</label>
                                    <textarea name="result" rows="2" placeholder="Hasil yang dicapai dari proyek ini..."
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('result') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar --}}
                    <div class="lg:col-span-1 space-y-4">
                        {{-- Settings --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 lg:sticky lg:top-4">
                            <h3 class="text-base font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Client & Project Type --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Klien</label>
                                    <input type="text" name="client_name" value="{{ old('client_name') }}"
                                        placeholder="PT. Example Indonesia"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Proyek</label>
                                    <input type="text" name="project_type" value="{{ old('project_type') }}"
                                        placeholder="Website E-Commerce"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                {{-- Technologies --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Teknologi</label>
                                    <input type="text" name="technologies" value="{{ old('technologies') }}"
                                        placeholder="Laravel, Vue.js, MySQL"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <p class="mt-1 text-xs text-gray-500">Pisahkan dengan koma</p>
                                </div>

                                {{-- URLs --}}
                                <div class="pt-3 border-t border-gray-200 space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">URL Proyek</label>
                                        <input type="url" name="project_url" value="{{ old('project_url') }}"
                                            placeholder="https://example.com"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">URL Github</label>
                                        <input type="url" name="github_url" value="{{ old('github_url') }}"
                                            placeholder="https://github.com/username/repo"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai</label>
                                        <input type="date" name="completion_date" value="{{ old('completion_date') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>

                                {{-- Toggles --}}
                                <div class="pt-3 border-t border-gray-200 space-y-2">
                                    <label class="flex items-center justify-between cursor-pointer">
                                        <span class="text-sm font-medium text-gray-700">Featured</span>
                                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                            class="w-9 h-5 bg-gray-200 rounded-full">
                                    </label>

                                    <label class="flex items-center justify-between cursor-pointer">
                                        <span class="text-sm font-medium text-gray-700">Aktif</span>
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}
                                            class="w-9 h-5 bg-gray-200 rounded-full">
                                    </label>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-4 space-y-2">
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white font-medium py-2.5 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors">
                                    <span class="flex items-center justify-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Simpan Portfolio
                                    </span>
                                </button>
                                <a href="{{ route('portfolio.index') }}"
                                    class="w-full bg-white text-gray-700 font-medium py-2.5 px-4 rounded-lg border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors text-sm flex items-center justify-center">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        // Initialize Quill Editor
        const quill = new Quill('#quillEditor', {
            theme: 'snow',
            placeholder: 'Tulis deskripsi lengkap portfolio Anda...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['blockquote', 'code-block'],
                    ['link'],
                    [{ 'align': [] }],
                    ['clean']
                ]
            }
        });

        // Auto-generate slug from title
        document.getElementById('titleInput').addEventListener('input', (e) => {
            const title = e.target.value;
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            document.getElementById('slugInput').value = slug;
        });

        // Image Preview - Thumbnail
        const thumbnailInput = document.getElementById('thumbnailInput');
        const thumbnailPreview = document.getElementById('thumbnailPreview');
        const thumbnailImg = document.getElementById('thumbnailImg');
        const thumbnailUploadArea = document.getElementById('thumbnailUploadArea');

        thumbnailInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.size <= 2097152) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    thumbnailImg.src = e.target.result;
                    thumbnailPreview.classList.remove('hidden');
                    thumbnailUploadArea.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else if (file) {
                alert('Ukuran file maksimal 2MB');
                thumbnailInput.value = '';
            }
        });

        document.getElementById('removeThumbnail').addEventListener('click', () => {
            thumbnailInput.value = '';
            thumbnailPreview.classList.add('hidden');
            thumbnailUploadArea.classList.remove('hidden');
        });

        // Image Preview - Featured
        const featuredInput = document.getElementById('featuredInput');
        const featuredPreview = document.getElementById('featuredPreview');
        const featuredImg = document.getElementById('featuredImg');
        const featuredUploadArea = document.getElementById('featuredUploadArea');

        featuredInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.size <= 2097152) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    featuredImg.src = e.target.result;
                    featuredPreview.classList.remove('hidden');
                    featuredUploadArea.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else if (file) {
                alert('Ukuran file maksimal 2MB');
                featuredInput.value = '';
            }
        });

        document.getElementById('removeFeatured').addEventListener('click', () => {
            featuredInput.value = '';
            featuredPreview.classList.add('hidden');
            featuredUploadArea.classList.remove('hidden');
        });

        // Form Submit
        document.getElementById('portfolioForm').addEventListener('submit', () => {
            document.getElementById('descriptionInput').value = quill.root.innerHTML;
        });
    </script>

    <style>
        .ql-container { font-size: 15px; }
        .ql-editor { min-height: 300px; padding: 16px; }
        .ql-editor.ql-blank::before { color: #9ca3af; font-style: normal; }
        
        /* Toggle Switch Styling */
        input[type="checkbox"] { position: relative; width: 2.25rem; height: 1.25rem; appearance: none; background: #e5e7eb; border-radius: 9999px; cursor: pointer; transition: all 0.2s; }
        input[type="checkbox"]:checked { background: #2563eb; }
        input[type="checkbox"]::after { content: ''; position: absolute; top: 2px; left: 2px; width: 1rem; height: 1rem; background: white; border-radius: 50%; transition: all 0.2s; }
        input[type="checkbox"]:checked::after { transform: translateX(1rem); }
    </style>
@endsection