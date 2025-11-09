<div class="space-y-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
        <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}"
               class="w-full border-2 border-gray-200 bg-white/90 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5 transition"
               placeholder="Masukkan nama kategori" required>
        @error('name')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $item->slug ?? '') }}"
               class="w-full border-2 border-gray-200 bg-white/90 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5 transition"
               placeholder="Slug otomatis dari nama kategori">
        @error('slug')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
        <textarea name="description" rows="4"
                  class="w-full border-2 border-gray-200 bg-white/90 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5 transition"
                  placeholder="Tulis deskripsi kategori...">{{ old('description', $item->description ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampilan</label>
            <input type="number" name="display_order" value="{{ old('display_order', $item->display_order ?? 0) }}"
                   class="w-full border-2 border-gray-200 bg-white/90 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5 transition"
                   placeholder="0">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status Aktif</label>
            <select name="is_active"
                    class="w-full border-2 border-gray-200 bg-white/90 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5 transition">
                <option value="1" {{ old('is_active', $item->is_active ?? true) ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', $item->is_active ?? true) ? '' : 'selected' }}>Tidak Aktif</option>
            </select>
        </div>
    </div>
</div>
