<x-layouts.app title="Tambah Poli">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Tambah Poli Baru</h2>
        <form method="POST" action="{{ route('polyclinics.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Poli <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kode <span class="text-red-500">*</span></label>
                <input type="text" name="code" required placeholder="POLI-XXX" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                @error('code') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Spesialisasi</label>
                <select name="specialty_id" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <option value="">-- Pilih --</option>
                    @foreach ($specialties as $specialty)
                        <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi</label>
                <input type="text" name="location" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">Simpan</button>
        </form>
    </div>
</x-layouts.app>
