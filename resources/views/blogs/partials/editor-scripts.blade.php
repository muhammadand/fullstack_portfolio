{{--
    Script khusus form blog: statistik kata, tombol draft, placeholder meta title, dan generate AI.
    Editor & upload gambar ditangani komponen <x-admin.rich-editor> dan <x-admin.image-upload>.
    Sengaja tanpa sintaks Blade di dalam <script>: URL & CSRF dibaca dari atribut/input form.
--}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('blogForm');
        const csrfToken = form.querySelector('input[name="_token"]').value;
        const $ = (selector) => form.querySelector(selector);
        const quill = form.querySelector('[data-rich-editor]').quill;

        // ---------- Statistik kata ----------
        let statsTimer;

        function updateStats() {
            const text = quill.getText().trim();
            const words = text ? text.split(/\s+/).length : 0;
            const minutes = Math.ceil(words / 200);
            document.getElementById('wordCount').textContent = words + ' kata';
            document.getElementById('readingTime').textContent = minutes + ' menit baca';
            $('#readingTimeInput').value = words ? minutes : '';
        }
        quill.on('text-change', () => {
            clearTimeout(statsTimer);
            statsTimer = setTimeout(updateStats, 300);
        });
        updateStats();

        // ---------- Submit ----------
        document.getElementById('btnSaveDraft').addEventListener('click', () => {
            $('#isPublishedInput').checked = false;
            form.requestSubmit(); // requestSubmit memicu event submit -> konten editor ikut tersimpan
        });

        $('#titleInput').addEventListener('input', (e) => {
            $('#metaTitleInput').placeholder = e.target.value || 'Otomatis dari judul jika kosong';
        });

        // ---------- Generate AI ----------
        const aiButton = document.getElementById('btnGenerateAi');
        aiButton.addEventListener('click', async () => {
            const category = $('#categoryInput');
            if (!category.value) {
                alert('Pilih kategori terlebih dahulu agar AI tahu topik yang dibahas.');
                category.focus();
                return;
            }

            const originalHtml = aiButton.innerHTML;
            aiButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Generating...';
            aiButton.disabled = true;

            try {
                const res = await fetch(form.dataset.aiUrl, {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': csrfToken
                    }
                    , body: JSON.stringify({
                        title: $('#titleInput').value
                        , category_id: category.value
                    })
                , });
                const data = await res.json();
                if (data.status !== 'success') throw new Error(data.message || 'Terjadi kesalahan saat generate AI');

                const fill = {
                    '#titleInput': data.title
                    , '#metaTitleInput': data.meta_title
                    , '#metaDescriptionInput': data.meta_description
                    , '#excerptInput': data.excerpt
                    , '#tagsInput': data.tags
                };
                Object.entries(fill).forEach(([selector, value]) => {
                    if (value) $(selector).value = value;
                });

                const author = $('#authorInput');
                if (!author.value && author.options.length > 1) author.value = author.options[1].value;

                if (data.html) quill.clipboard.dangerouslyPasteHTML(data.html);
            } catch (err) {
                alert(err.message || 'Koneksi gagal saat generate AI');
            } finally {
                aiButton.innerHTML = originalHtml;
                aiButton.disabled = false;
            }
        });
    });

</script>
