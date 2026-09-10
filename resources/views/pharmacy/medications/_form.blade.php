<div class="grid md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Obat <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $medication->name ?? '') }}" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
        <input type="text" name="category" value="{{ old('category', $medication->category ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Satuan <span class="text-red-500">*</span></label>
        <input type="text" name="unit" value="{{ old('unit', $medication->unit ?? '') }}" placeholder="tablet, botol, strip" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
        <input type="number" name="price" value="{{ old('price', $medication->price ?? 0) }}" min="0" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Stok <span class="text-red-500">*</span></label>
        <input type="number" name="stock" value="{{ old('stock', $medication->stock ?? 0) }}" min="0" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Dosis Standar</label>
        <input type="text" name="dosage" value="{{ old('dosage', $medication->dosage ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1">Aturan Penggunaan</label>
        <textarea name="usage_instructions" rows="2" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">{{ old('usage_instructions', $medication->usage_instructions ?? '') }}</textarea>
    </div>
    @isset($medication)
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
            <select name="is_active" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                <option value="1" @selected($medication->is_active)>Aktif</option>
                <option value="0" @selected(!$medication->is_active)>Nonaktif</option>
            </select>
        </div>
    @endisset
</div>
