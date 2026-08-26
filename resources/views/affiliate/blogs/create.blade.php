<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tulis Artikel Baru - Partner Dashboard</title>
    <x-affiliate.pwa-meta />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-input {
            width: 100%;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            color: white;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(249, 115, 22, 0.5);
            /* Orange focus */
            box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.2);
        }

        /* File Input Styling */
        input[type="file"]::file-selector-button {
            border: none;
            background: rgba(249, 115, 22, 0.1);
            color: #f97316;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            margin-right: 1rem;
            transition: all 0.2s;
        }

        input[type="file"]::file-selector-button:hover {
            background: rgba(249, 115, 22, 0.2);
        }

    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative">

    <!-- Background Decoration -->
    <div class="fixed top-0 left-0 w-full h-64 bg-orange-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('affiliate.blogs.index') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <p class="text-xs text-orange-400 font-medium tracking-wider uppercase">Tulis</p>
                <h1 class="text-xl font-bold text-white">Artikel Baru</h1>
            </div>
        </div>

        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-xl mb-6 text-sm font-medium">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="glass-panel rounded-2xl p-5 mb-8">
            <form action="{{ route('affiliate.blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Judul -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5 ml-1">Judul Artikel <span class="text-red-400">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-input" placeholder="Contoh: 5 Alasan Bisnis Kamu Butuh Website (Kosongkan untuk AI)" maxlength="150">
                    <p class="text-[10px] text-slate-500 mt-1.5 ml-1">Usahakan judul menarik. Kosongkan jika ingin AI otomatis mencari judul tren/hype.</p>
                </div>

                <!-- Kategori (Target Jualan) -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5 ml-1">Topik Kategori / Target Promosi <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <select name="business_category_id" required class="form-input appearance-none">
                            <option value="" disabled selected>Pilih Kategori Bisnis...</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('business_category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                    <p class="text-[10px] text-orange-400 mt-1.5 ml-1 flex items-start gap-1">
                        <i class="fa-solid fa-lightbulb mt-0.5"></i>
                        <span>Penting: Sistem akan menyisipkan <b>Link Landing Page (Proposal)</b> sesuai kategori ini secara otomatis di akhir artikelmu!</span>
                    </p>
                </div>

                <!-- Gambar -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5 ml-1">Gambar Utama</label>
                    <input type="file" name="featured_image" accept="image/*" class="form-input">
                    <p class="text-[10px] text-slate-500 mt-1.5 ml-1">Format: JPG, PNG, WEBP. Maks: 2MB. (Opsional)</p>
                </div>

                <!-- Isi Artikel -->
                <div>
                    <div class="flex items-center justify-between mb-1.5 ml-1 mr-1">
                        <label class="block text-xs font-bold text-slate-300">Isi Artikel <span class="text-red-400">*</span></label>
                        <button type="button" id="btnGenerateAi" class="text-[10px] bg-purple-500/20 text-purple-400 hover:bg-purple-500/40 px-2 py-1 rounded border border-purple-500/30 transition-colors font-bold flex items-center gap-1 active:scale-95 shadow-sm shadow-purple-500/10">
                            <i class="fa-solid fa-wand-magic-sparkles"></i> Auto Generate (AI)
                        </button>
                    </div>
                    <div class="glass-panel overflow-hidden rounded-xl" style="background: rgba(0,0,0,0.2);">
                        <div id="quillEditor" class="min-h-[250px] text-sm text-white"></div>
                    </div>
                    <input type="hidden" name="content" id="contentInput" required>
                    <input type="hidden" name="meta_title" id="metaTitleInput">
                    <input type="hidden" name="meta_description" id="metaDescInput">
                    <p class="text-[10px] text-slate-500 mt-1.5 ml-1">Tulis secara santai. Anda bisa menggunakan pemformatan teks di atas.</p>
                </div>

                <div class="pt-2">
                    <button type="submit" id="submitBtn" class="w-full bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-orange-500/25 transition-transform active:scale-[0.98]">
                        <i class="fa-solid fa-paper-plane mr-1.5"></i> Kirim untuk di-Review
                    </button>
                    <p class="text-[10px] text-center text-slate-400 mt-3">Kamu akan mendapat Notifikasi dan +10 Poin Emas setelah tulisanmu diterbitkan.</p>
                </div>
            </form>
        </div>

    </div>

    <!-- QuillJS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        // Inisialisasi Quill Editor dengan toolbar yang lebih sederhana dan mobile-friendly
        var quill = new Quill('#quillEditor', {
            theme: 'snow'
            , placeholder: 'Tulis ceritamu di sini... (Minimal 3-4 paragraf)\n\nContoh:\nDi era digital saat ini, punya website bukan lagi sekadar gengsi...'
            , modules: {
                toolbar: [
                    [{
                        'header': [2, 3, false]
                    }]
                    , ['bold', 'italic', 'underline']
                    , [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }]
                    , ['link', 'blockquote']
                    , ['clean'] // Tombol untuk menghapus format
                ]
            }
        });

        // Fitur Auto Generate AI
        document.getElementById('btnGenerateAi').addEventListener('click', async function() {
            const title = document.querySelector('input[name="title"]').value;
            const categoryId = document.querySelector('select[name="business_category_id"]').value;

            if (!categoryId) {
                alert('Silakan pilih Topik Kategori terlebih dahulu sebelum generate AI!');
                return;
            }

            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Menyusun...';
            btn.disabled = true;

            try {
                const response = await fetch('{{ route("affiliate.blogs.generate_ai") }}', {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                    , body: JSON.stringify({
                        title: title
                        , business_category_id: categoryId
                    })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    // Update field judul jika AI memberikan judul
                    if (data.title && data.title !== "") {
                        document.querySelector('input[name="title"]').value = data.title;
                    }

                    // Update meta SEO hidden inputs
                    if (data.meta_title) document.getElementById('metaTitleInput').value = data.meta_title;
                    if (data.meta_description) document.getElementById('metaDescInput').value = data.meta_description;

                    // Paste konten HTML dari AI ke Editor
                    quill.clipboard.dangerouslyPasteHTML(data.html);
                } else {
                    alert(data.message || 'Gagal menghasilkan artikel.');
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan jaringan.');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            // Validasi manual judul
            const titleInput = document.querySelector('input[name="title"]');
            if (titleInput.value.trim() === '') {
                e.preventDefault();
                alert('Judul Artikel tidak boleh kosong saat dikirim! Klik tombol AI atau isi secara manual.');
                return false;
            }

            // Pindahkan isi Quill ke input tersembunyi
            const contentInput = document.getElementById('contentInput');
            const htmlContent = quill.root.innerHTML;

            // Validasi jika editor kosong (hanya berisi <p><br></p>)
            if (quill.getText().trim().length === 0) {
                e.preventDefault();
                alert('Isi artikel tidak boleh kosong! Silakan tulis sesuatu atau gunakan tombol AI.');
                return false;
            }

            contentInput.value = htmlContent;

            // Efek loading tombol
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-1.5"></i> Mengirim...';
            btn.classList.add('opacity-70');
        });

    </script>

    <style>
        /* Custom Styling untuk QuillJS di tema Gelap (Dark Mode) */
        .ql-toolbar.ql-snow {
            border: none !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 0.75rem 0.75rem 0 0;
            padding: 8px !important;
        }

        .ql-container.ql-snow {
            border: none !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 0.875rem !important;
        }

        /* Warna Ikon Toolbar */
        .ql-snow .ql-stroke {
            stroke: #cbd5e1 !important;
            /* text-slate-300 */
        }

        .ql-snow .ql-fill,
        .ql-snow .ql-stroke.ql-fill {
            fill: #cbd5e1 !important;
        }

        /* Warna saat ikon di-hover/aktif */
        .ql-snow.ql-toolbar button:hover .ql-stroke,
        .ql-snow .ql-toolbar button:hover .ql-stroke,
        .ql-snow.ql-toolbar button.ql-active .ql-stroke,
        .ql-snow .ql-toolbar button.ql-active .ql-stroke {
            stroke: #f97316 !important;
            /* text-orange-500 */
        }

        .ql-snow.ql-toolbar button:hover .ql-fill,
        .ql-snow .ql-toolbar button:hover .ql-fill,
        .ql-snow.ql-toolbar button.ql-active .ql-fill,
        .ql-snow .ql-toolbar button.ql-active .ql-fill {
            fill: #f97316 !important;
        }

        /* Picker Text (Header) */
        .ql-snow .ql-picker {
            color: #cbd5e1 !important;
        }

        .ql-snow .ql-picker-options {
            background-color: #1e293b !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        .ql-snow .ql-picker-item:hover,
        .ql-snow .ql-picker-item.ql-selected {
            color: #f97316 !important;
        }

        /* Konten Editor */
        .ql-editor {
            color: #f8fafc;
            padding: 1rem !important;
        }

        .ql-editor.ql-blank::before {
            color: rgba(255, 255, 255, 0.4) !important;
            font-style: normal !important;
        }

        /* Styling teks di dalam editor agar nyaman dibaca */
        .ql-editor p {
            margin-bottom: 1em;
            line-height: 1.6;
        }

        .ql-editor h2,
        .ql-editor h3 {
            color: #fff;
            font-weight: 700;
            margin-top: 1.5em;
            margin-bottom: 0.5em;
        }

        .ql-editor a {
            color: #38bdf8;
            text-decoration: underline;
        }

        .ql-editor blockquote {
            border-left: 3px solid #f97316;
            padding-left: 10px;
            color: #94a3b8;
            font-style: italic;
        }

    </style>
</body>
</html>
