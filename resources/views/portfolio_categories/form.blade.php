<div class="space-y-4">
    <div>
        <label class="block text-[13px] font-medium tracking-wide text-slate-700 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-[13px] focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-colors" placeholder="Masukkan nama kategori" required>
        @error('name')
        <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-[13px] font-medium tracking-wide text-slate-700 mb-1.5">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $item->slug ?? '') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-[13px] focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-colors" placeholder="Slug otomatis dari nama kategori">
        @error('slug')
        <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-[13px] font-medium tracking-wide text-slate-700 mb-1.5">Deskripsi</label>
        <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-[13px] focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-colors resize-none" placeholder="Tulis deskripsi kategori...">{{ old('description', $item->description ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[13px] font-medium tracking-wide text-slate-700 mb-1.5">Urutan Tampilan</label>
            <input type="number" name="display_order" value="{{ old('display_order', $item->display_order ?? 0) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-[13px] focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-colors" placeholder="0">
        </div>

        <div>
            <label class="block text-[13px] font-medium tracking-wide text-slate-700 mb-1.5">Status Aktif</label>
            <select name="is_active" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-[13px] focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-colors">
                <option value="1" {{ old('is_active', $item->is_active ?? true) ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', $item->is_active ?? true) ? '' : 'selected' }}>Tidak Aktif</option>
            </select>
        </div>
    </div>
</div>
