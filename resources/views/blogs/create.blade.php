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
                            <div id="quillEditor" class="bg-white" style="min-height: 400px;">
                                {!! old('content') !!}
                            </div>
                            <input type="hidden" name="content" id="contentInput">
                            <input type="file" id="quillImageFile" accept="image/*" class="hidden">
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

    {{-- Floating Image Control Toolbar --}}
    <div id="imgToolbar" style="display:none; position:absolute; z-index:9999; background:#1e293b; border-radius:10px; padding:6px 8px; box-shadow:0 8px 30px rgba(0,0,0,0.35); gap:4px; align-items:center; flex-wrap:wrap; max-width:320px;">
        <span style="color:#94a3b8; font-size:10px; font-weight:600; padding:0 4px; letter-spacing:.05em;">UKURAN</span>
        <button class="img-ctrl-btn" data-action="width" data-value="25%" title="25%">25%</button>
        <button class="img-ctrl-btn" data-action="width" data-value="50%" title="50%">50%</button>
        <button class="img-ctrl-btn" data-action="width" data-value="75%" title="75%">75%</button>
        <button class="img-ctrl-btn" data-action="width" data-value="100%" title="100%">Full</button>
        <div style="width:1px; height:20px; background:#334155; margin:0 4px;"></div>
        <span style="color:#94a3b8; font-size:10px; font-weight:600; padding:0 4px; letter-spacing:.05em;">POSISI</span>
        <button class="img-ctrl-btn" data-action="align" data-value="left" title="Float Kiri">&#x2B1B;&#x25FB;</button>
        <button class="img-ctrl-btn" data-action="align" data-value="center" title="Tengah">&#x25FB;&#x2B1B;&#x25FB;</button>
        <button class="img-ctrl-btn" data-action="align" data-value="right" title="Float Kanan">&#x25FB;&#x2B1B;</button>
        <button class="img-ctrl-btn" data-action="align" data-value="none" title="Block">Block</button>
        <div style="width:1px; height:20px; background:#334155; margin:0 4px;"></div>
        <button class="img-ctrl-btn" data-action="delete" style="color:#f87171; font-size:16px; padding:2px 6px;" title="Hapus">&#x2715;</button>
    </div>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        // ═══ 1. IMAGE UPLOAD ke server ══════════════════════════════════════════
        function imageUploadHandler() {
            const fileInput = document.getElementById('quillImageFile');
            fileInput.click();
            fileInput.onchange = () => {
                const file = fileInput.files[0];
                if (!file) return;
                const formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');
                fetch('{{ route("blogs.upload-image") }}', { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        if (data.url) {
                            const range = quill.getSelection(true);
                            quill.insertEmbed(range.index, 'image', data.url, 'user');
                            quill.setSelection(range.index + 1, 0, 'silent');
                        } else { alert('Gagal upload: ' + (data.message || 'Error')); }
                    })
                    .catch(err => alert('Error: ' + err.message));
                fileInput.value = '';
            };
        }

        // ═══ 2. LINK HANDLER (custom prompt) ═══════════════════════════════
        function linkHandler(value) {
            if (value) {
                const range = quill.getSelection();
                if (!range || range.length === 0) { alert('Pilih teks terlebih dahulu!'); return; }
                const existing = quill.getFormat(range).link || '';
                const url = prompt('Masukkan URL link:', existing || 'https://');
                if (url !== null && url.trim() !== '') quill.format('link', url.trim(), 'user');
                else if (url !== null) quill.format('link', false, 'user');
            } else { quill.format('link', false, 'user'); }
        }

        // ═══ 3. INISIALISASI QUILL ═════════════════════════════════════════
        const quill = new Quill('#quillEditor', {
            theme: 'snow',
            placeholder: 'Mulai menulis cerita Anda di sini...',
            modules: {
                toolbar: {
                    container: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }, { 'font': [] }, { 'size': ['small', false, 'large', 'huge'] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
                        ['blockquote', 'code-block'],
                        ['link', 'image', 'video'],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        ['clean']
                    ],
                    handlers: { 'image': imageUploadHandler, 'link': linkHandler }
                }
            }
        });

        // ═══ 4. FLOATING IMAGE TOOLBAR ══════════════════════════════════════
        let selectedImg = null;
        const imgToolbar = document.getElementById('imgToolbar');

        function showImgToolbar(img) {
            selectedImg = img;
            const editorRect = document.querySelector('.ql-editor').getBoundingClientRect();
            const imgRect = img.getBoundingClientRect();
            const top = imgRect.top + window.scrollY - imgToolbar.offsetHeight - 10;
            imgToolbar.style.top = (top < 0 ? imgRect.bottom + window.scrollY + 8 : top) + 'px';
            imgToolbar.style.left = Math.max(editorRect.left, imgRect.left + window.scrollX) + 'px';
            imgToolbar.style.display = 'flex';
        }

        function hideImgToolbar() {
            imgToolbar.style.display = 'none';
            if (selectedImg) { selectedImg.style.outline = ''; selectedImg = null; }
        }

        function bindImageClicks() {
            quill.root.querySelectorAll('img').forEach(img => {
                if (!img.dataset.bound) {
                    img.dataset.bound = '1';
                    img.addEventListener('click', (e) => {
                        e.stopPropagation();
                        quill.root.querySelectorAll('img').forEach(i => i.style.outline = '');
                        img.style.outline = '3px solid #9333ea';
                        img.style.borderRadius = '8px';
                        showImgToolbar(img);
                    });
                }
            });
        }

        quill.on('text-change', bindImageClicks);
        bindImageClicks();
        document.addEventListener('click', (e) => { if (!imgToolbar.contains(e.target) && e.target !== selectedImg) hideImgToolbar(); });

        imgToolbar.querySelectorAll('.img-ctrl-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                if (!selectedImg) return;
                const action = btn.dataset.action;
                const value = btn.dataset.value;
                if (action === 'width') { selectedImg.style.width = value; selectedImg.style.maxWidth = '100%'; selectedImg.style.height = 'auto'; }
                if (action === 'align') {
                    selectedImg.style.float = ''; selectedImg.style.display = ''; selectedImg.style.margin = ''; selectedImg.style.marginLeft = ''; selectedImg.style.marginRight = '';
                    if (value === 'left')        { selectedImg.style.float = 'left'; selectedImg.style.margin = '0 16px 8px 0'; }
                    else if (value === 'right')  { selectedImg.style.float = 'right'; selectedImg.style.margin = '0 0 8px 16px'; }
                    else if (value === 'center') { selectedImg.style.display = 'block'; selectedImg.style.marginLeft = 'auto'; selectedImg.style.marginRight = 'auto'; }
                    else                         { selectedImg.style.display = 'block'; selectedImg.style.margin = '8px 0'; }
                    showImgToolbar(selectedImg);
                }
                if (action === 'delete') { selectedImg.parentNode.removeChild(selectedImg); hideImgToolbar(); }
                if (action !== 'delete') {
                    imgToolbar.querySelectorAll(`[data-action="${action}"]`).forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                }
            });
        });

        // ═══ 5. WORD COUNT ══════════════════════════════════════════════════
        let statsTimeout;
        quill.on('text-change', () => {
            clearTimeout(statsTimeout);
            statsTimeout = setTimeout(() => {
                const text = quill.getText().trim();
                const words = text ? text.split(/\s+/).length : 0;
                const mins = Math.ceil(words / 200);
                document.getElementById('wordCount').textContent = words + ' kata';
                document.getElementById('readingTime').textContent = mins + ' menit baca';
                document.getElementById('readingTimeInput').value = mins;
            }, 300);
        });

        // ═══ 6. FEATURED IMAGE PREVIEW ═════════════════════════════════════
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const imageUploadArea = document.getElementById('imageUploadArea');

        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.size <= 2097152) {
                const reader = new FileReader();
                reader.onload = (e) => { previewImg.src = e.target.result; imagePreview.classList.remove('hidden'); imageUploadArea.classList.add('hidden'); };
                reader.readAsDataURL(file);
            } else if (file) { alert('Ukuran file maksimal 2MB'); imageInput.value = ''; }
        });
        document.getElementById('removeImage').addEventListener('click', () => { imageInput.value = ''; imagePreview.classList.add('hidden'); imageUploadArea.classList.remove('hidden'); });

        // ═══ 7. FORM SUBMIT ══════════════════════════════════════════════════
        document.getElementById('blogForm').addEventListener('submit', () => {
            document.getElementById('contentInput').value = quill.root.innerHTML;
        });

        // Auto-fill meta title placeholder
        document.getElementById('titleInput').addEventListener('input', (e) => {
            const metaTitleInput = document.querySelector('input[name="meta_title"]');
            if (!metaTitleInput.value) metaTitleInput.placeholder = e.target.value || 'Otomatis dari judul jika kosong';
        });
    </script>

    <style>
        /* ─── Quill Core ─────────────────────────────────────────────────── */
        .ql-toolbar   { border-radius: 8px 8px 0 0; background: #f8fafc; border-color: #e2e8f0 !important; }
        .ql-container { border-radius: 0 0 8px 8px; font-size: 15px; border-color: #e2e8f0 !important; }
        .ql-editor    { min-height: 400px; padding: 20px; line-height: 1.7; }
        .ql-editor.ql-blank::before { color: #9ca3af; font-style: normal; }
        .ql-tooltip   { z-index: 9000 !important; }
        .ql-editor img { max-width: 100%; border-radius: 8px; cursor: pointer; }

        /* ─── Image Toolbar Buttons ───────────────────────────────────── */
        .img-ctrl-btn { background: #334155; color: #e2e8f0; border: 1px solid #475569; border-radius: 6px; padding: 3px 8px; font-size: 11px; font-weight: 600; cursor: pointer; transition: background .15s, color .15s; line-height: 1.6; }
        .img-ctrl-btn:hover  { background: #9333ea; color: white; border-color: #9333ea; }
        .img-ctrl-btn.active { background: #7e22ce; color: white; border-color: #6b21a8; }

        /* ─── Toggle Switch ──────────────────────────────────────────── */
        input[type="checkbox"] { position: relative; width: 2.25rem; height: 1.25rem; appearance: none; background: #e5e7eb; border-radius: 9999px; cursor: pointer; transition: all .2s; }
        input[type="checkbox"]:checked { background: #9333ea; }
        input[type="checkbox"]::after  { content: ''; position: absolute; top: 2px; left: 2px; width: 1rem; height: 1rem; background: white; border-radius: 50%; transition: all .2s; }
        input[type="checkbox"]:checked::after { transform: translateX(1rem); }
    </style>
@endsection