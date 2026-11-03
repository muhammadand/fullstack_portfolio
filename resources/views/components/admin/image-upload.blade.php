{{--
    Upload gambar dengan preview.
    Pemakaian: <x-admin.image-upload name="thumbnail_image" :current="$url" />
    Props:
      current     URL gambar yang sudah tersimpan (opsional, untuk halaman edit)
      remove-name nama input hidden yang dikirim bernilai 1 jika gambar dihapus (opsional;
                  tanpa ini gambar hanya bisa diganti, tidak bisa dihapus)
      height      kelas tinggi area (default h-40)
      max-mb      batas ukuran file di sisi browser (default 2)
      label       teks di area upload
--}}
@props(['name', 'current' => null, 'removeName' => null, 'height' => 'h-40', 'maxMb' => 2, 'label' => 'gambar'])

<div data-image-upload data-current="{{ $current }}" data-removable="{{ $removeName ? '1' : '0' }}" data-max-mb="{{ $maxMb }}">
    @if ($removeName)
    <input type="hidden" name="{{ $removeName }}" value="0" data-remove-input>
    @endif

    <div data-preview @class(['relative', 'hidden' => !$current])>
        <img data-preview-img src="{{ $current }}" alt="Preview {{ $label }}" class="w-full {{ $height }} object-cover rounded-lg border border-slate-200">
        <div class="absolute top-2 right-2 flex gap-1.5">
            <label for="{{ $name }}Input" class="h-8 px-2.5 inline-flex items-center gap-1.5 rounded-lg bg-white/90 text-xs font-medium text-slate-700 shadow-sm hover:bg-white cursor-pointer transition-colors">
                <i class="fa-solid fa-arrows-rotate"></i> Ganti
            </label>
            <button type="button" data-remove class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-white/90 text-red-600 shadow-sm hover:bg-white transition-colors" title="Hapus gambar">
                <i class="fa-solid fa-trash-can text-sm"></i>
            </button>
        </div>
    </div>

    <label for="{{ $name }}Input" data-dropzone @class([
        'flex flex-col items-center justify-center w-full rounded-lg border-2 border-dashed border-slate-300 cursor-pointer text-center hover:border-blue-400 hover:bg-blue-50/40 transition-colors',
        $height,
        'hidden' => $current,
    ])>
        <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400 mb-2"></i>
        <span class="text-sm text-slate-600"><span class="font-medium text-blue-600">Klik untuk upload</span> {{ $label }}</span>
        <span class="text-xs text-slate-500 mt-0.5">PNG, JPG atau JPEG — maks. {{ $maxMb }}MB</span>
    </label>

    <input type="file" id="{{ $name }}Input" name="{{ $name }}" accept="image/png,image/jpeg" class="hidden" data-file>
</div>

@once
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-image-upload]').forEach((box) => {
            const file = box.querySelector('[data-file]');
            const img = box.querySelector('[data-preview-img]');
            const preview = box.querySelector('[data-preview]');
            const dropzone = box.querySelector('[data-dropzone]');
            const removeButton = box.querySelector('[data-remove]');
            const removeInput = box.querySelector('[data-remove-input]');
            const current = box.dataset.current;
            const removable = box.dataset.removable === '1';
            const maxBytes = Number(box.dataset.maxMb) * 1024 * 1024;

            // src = gambar yang sedang ditampilkan ('' = tidak ada)
            function render(src) {
                const hasImage = Boolean(src);
                preview.classList.toggle('hidden', !hasImage);
                dropzone.classList.toggle('hidden', hasImage);
                if (hasImage) img.src = src; else img.removeAttribute('src');
                // gambar lama yang wajib ada tidak boleh dihapus, hanya diganti
                removeButton.classList.toggle('hidden', hasImage && src === current && !removable);
            }

            file.addEventListener('change', () => {
                const picked = file.files[0];
                if (!picked) return;
                if (picked.size > maxBytes) {
                    alert('Ukuran gambar maksimal ' + box.dataset.maxMb + 'MB.');
                    file.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = (e) => render(e.target.result);
                reader.readAsDataURL(picked);
                if (removeInput) removeInput.value = '0';
            });

            removeButton.addEventListener('click', () => {
                const showingNewFile = file.files.length > 0;
                file.value = '';

                if (showingNewFile && current) return render(current);   // batal ganti -> kembali ke gambar lama
                if (removeInput) removeInput.value = current ? '1' : '0';
                render('');
            });

            render(current);
        });
    });
</script>
@endonce
