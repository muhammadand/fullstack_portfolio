{{--
    Editor teks (Quill) dengan upload gambar ke server + toolbar ukuran/posisi gambar.
    Pemakaian: <x-admin.rich-editor name="content" :value="old('content', $x->content)" :upload-url="route('x.upload-image')" />

    - Isi editor otomatis disalin ke <input type="hidden" name="..."> saat form di-submit.
    - Instance Quill tersedia di elemen wrapper: document.querySelector('[data-rich-editor]').quill
      (baca setelah event DOMContentLoaded).
    - Tidak ada sintaks Blade di dalam JS; URL & CSRF dibaca dari atribut/input form.
--}}
@props(['name', 'value' => '', 'uploadUrl', 'placeholder' => 'Mulai menulis di sini...'])

<div {{ $attributes->class('rich-editor') }} data-rich-editor data-upload-url="{{ $uploadUrl }}" data-placeholder="{{ $placeholder }}">
    <div data-editor>{!! $value !!}</div>
    <input type="hidden" name="{{ $name }}" data-editor-input>
    <input type="file" accept="image/*" class="hidden" data-editor-file>
</div>

@once
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // ---------- Toolbar ukuran/posisi gambar (satu untuk semua editor) ----------
        const imgToolbar = document.createElement('div');
        imgToolbar.className = 'hidden fixed z-[9999] items-center gap-1 flex-wrap max-w-xs rounded-lg bg-slate-900 p-1.5 shadow-xl';
        imgToolbar.innerHTML = `
            <span class="px-1 text-[10px] font-semibold tracking-wider text-slate-400">UKURAN</span>
            <button type="button" class="img-ctrl-btn" data-action="width" data-value="25%">25%</button>
            <button type="button" class="img-ctrl-btn" data-action="width" data-value="50%">50%</button>
            <button type="button" class="img-ctrl-btn" data-action="width" data-value="75%">75%</button>
            <button type="button" class="img-ctrl-btn" data-action="width" data-value="100%">Full</button>
            <span class="mx-1 h-5 w-px bg-slate-700"></span>
            <span class="px-1 text-[10px] font-semibold tracking-wider text-slate-400">POSISI</span>
            <button type="button" class="img-ctrl-btn" data-action="align" data-value="left" title="Rata kiri"><i class="fa-solid fa-align-left"></i></button>
            <button type="button" class="img-ctrl-btn" data-action="align" data-value="center" title="Tengah"><i class="fa-solid fa-align-center"></i></button>
            <button type="button" class="img-ctrl-btn" data-action="align" data-value="right" title="Rata kanan"><i class="fa-solid fa-align-right"></i></button>
            <button type="button" class="img-ctrl-btn" data-action="align" data-value="none" title="Block"><i class="fa-solid fa-square"></i></button>
            <span class="mx-1 h-5 w-px bg-slate-700"></span>
            <button type="button" class="img-ctrl-btn text-red-400" data-action="delete" title="Hapus gambar"><i class="fa-solid fa-trash-can"></i></button>`;
        document.body.appendChild(imgToolbar);

        const alignStyles = {
            left: { float: 'left', margin: '0 16px 8px 0', display: '' },
            right: { float: 'right', margin: '0 0 8px 16px', display: '' },
            center: { float: '', margin: '0 auto', display: 'block' },
            none: { float: '', margin: '8px 0', display: 'block' },
        };
        let selectedImg = null;

        function showImgToolbar(img) {
            selectedImg = img;
            imgToolbar.classList.remove('hidden');
            imgToolbar.classList.add('flex');
            const rect = img.getBoundingClientRect();
            const top = rect.top - imgToolbar.offsetHeight - 8;
            imgToolbar.style.top = (top < 8 ? rect.bottom + 8 : top) + 'px';
            imgToolbar.style.left = Math.max(8, rect.left) + 'px';
        }

        function hideImgToolbar() {
            imgToolbar.classList.add('hidden');
            imgToolbar.classList.remove('flex');
            selectedImg?.classList.remove('is-selected');
            selectedImg = null;
        }

        imgToolbar.addEventListener('click', (e) => {
            const btn = e.target.closest('.img-ctrl-btn');
            if (!btn || !selectedImg) return;
            e.stopPropagation();

            const { action, value } = btn.dataset;
            if (action === 'delete') {
                selectedImg.remove();
                hideImgToolbar();
                return;
            }
            if (action === 'width') Object.assign(selectedImg.style, { width: value, maxWidth: '100%', height: 'auto' });
            if (action === 'align') Object.assign(selectedImg.style, alignStyles[value]);

            imgToolbar.querySelectorAll(`[data-action="${action}"]`).forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
            showImgToolbar(selectedImg);
        });
        document.addEventListener('click', (e) => {
            if (!imgToolbar.contains(e.target)) hideImgToolbar();
        });
        document.addEventListener('scroll', hideImgToolbar, true);

        // ---------- Inisialisasi setiap editor ----------
        document.querySelectorAll('[data-rich-editor]').forEach((wrapper) => {
            const form = wrapper.closest('form');
            const input = wrapper.querySelector('[data-editor-input]');
            const fileInput = wrapper.querySelector('[data-editor-file]');

            function uploadImage() {
                fileInput.onchange = async () => {
                    const file = fileInput.files[0];
                    fileInput.value = '';
                    if (!file) return;

                    const body = new FormData();
                    body.append('image', file);
                    body.append('_token', form.querySelector('input[name="_token"]').value);

                    try {
                        const res = await fetch(wrapper.dataset.uploadUrl, { method: 'POST', body });
                        const data = await res.json();
                        if (!data.url) throw new Error(data.message || 'Upload gagal');

                        const range = quill.getSelection(true);
                        quill.insertEmbed(range.index, 'image', data.url, 'user');
                        quill.setSelection(range.index + 1, 0, 'silent');
                    } catch (err) {
                        alert('Gagal upload gambar: ' + err.message);
                    }
                };
                fileInput.click();
            }

            function insertLink(value) {
                if (!value) return quill.format('link', false, 'user');
                const range = quill.getSelection();
                if (!range || range.length === 0) return alert('Pilih teks terlebih dahulu.');
                const url = prompt('Masukkan URL:', quill.getFormat(range).link || 'https://');
                if (url !== null) quill.format('link', url.trim() || false, 'user');
            }

            const quill = new Quill(wrapper.querySelector('[data-editor]'), {
                theme: 'snow',
                placeholder: wrapper.dataset.placeholder,
                modules: {
                    toolbar: {
                        container: [
                            [{ header: [1, 2, 3, 4, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ color: [] }, { background: [] }],
                            [{ align: [] }],
                            [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
                            ['blockquote', 'code-block'],
                            ['link', 'image', 'video'],
                            ['clean'],
                        ],
                        handlers: { image: uploadImage, link: insertLink },
                    },
                },
            });

            quill.root.addEventListener('click', (e) => {
                if (e.target.tagName !== 'IMG') return;
                e.stopPropagation();
                quill.root.querySelectorAll('img.is-selected').forEach((img) => img.classList.remove('is-selected'));
                e.target.classList.add('is-selected');
                showImgToolbar(e.target);
            });

            form?.addEventListener('submit', () => {
                input.value = quill.root.innerHTML;
            });

            wrapper.quill = quill;
        });
    });
</script>
<style>
    .rich-editor .ql-toolbar.ql-snow {
        border-color: #e2e8f0;
        border-radius: 0.5rem 0.5rem 0 0;
        background: #f8fafc;
        font-family: inherit;
    }

    .rich-editor .ql-container.ql-snow {
        border-color: #e2e8f0;
        border-radius: 0 0 0.5rem 0.5rem;
        font-family: inherit;
        font-size: 0.9375rem;
    }

    .rich-editor .ql-editor {
        min-height: 420px;
        padding: 1.25rem;
        line-height: 1.75;
        color: #0f172a;
    }

    .rich-editor .ql-editor.ql-blank::before {
        color: #94a3b8;
        font-style: normal;
    }

    .rich-editor .ql-editor img {
        max-width: 100%;
        border-radius: 0.5rem;
        cursor: pointer;
    }

    .rich-editor .ql-editor img.is-selected {
        outline: 3px solid #2563eb;
        outline-offset: 2px;
    }

    .rich-editor .ql-snow .ql-tooltip {
        z-index: 9000;
    }

    .img-ctrl-btn {
        border-radius: 0.375rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.6875rem;
        font-weight: 600;
        color: #e2e8f0;
        background: #1e293b;
        transition: background-color .15s;
    }

    .img-ctrl-btn:hover,
    .img-ctrl-btn.active {
        background: #2563eb;
        color: #fff;
    }
</style>
@endonce
