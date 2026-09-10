<x-layouts.app title="Buat Resep">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm p-5" x-data="{ items: [{medication_id:'',dosage:'',frequency:'',duration:'',quantity:1,instructions:''}] }">
        <h2 class="font-semibold text-slate-800 mb-1">Buat Resep</h2>
        <p class="text-xs text-slate-500 mb-4">Pasien: {{ $medicalRecord->patient->full_name }}</p>

        @error('items') <p class="text-red-600 text-xs mb-3 bg-red-50 rounded-lg p-3">{{ $message }}</p> @enderror

        <form method="POST" action="{{ route('prescriptions.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="medical_record_id" value="{{ $medicalRecord->id }}">

            <template x-for="(item, index) in items" :key="index">
                <div class="border border-slate-200 rounded-xl p-3 space-y-2">
                    <select :name="`items[${index}][medication_id]`" required class="w-full rounded-xl border-slate-300 text-sm py-2.5 px-3">
                        <option value="">-- Pilih Obat --</option>
                        @foreach ($medications as $medication)
                            <option value="{{ $medication->id }}">{{ $medication->name }} (stok: {{ $medication->stock }})</option>
                        @endforeach
                    </select>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" :name="`items[${index}][dosage]`" placeholder="Dosis (mis. 500mg)" required class="rounded-xl border-slate-300 text-sm py-2.5 px-3">
                        <input type="text" :name="`items[${index}][frequency]`" placeholder="Frekuensi (mis. 3x1)" required class="rounded-xl border-slate-300 text-sm py-2.5 px-3">
                        <input type="text" :name="`items[${index}][duration]`" placeholder="Durasi (mis. 5 hari)" class="rounded-xl border-slate-300 text-sm py-2.5 px-3">
                        <input type="number" :name="`items[${index}][quantity]`" x-model="item.quantity" min="1" placeholder="Jumlah" required class="rounded-xl border-slate-300 text-sm py-2.5 px-3">
                    </div>
                    <input type="text" :name="`items[${index}][instructions]`" placeholder="Instruksi tambahan" class="w-full rounded-xl border-slate-300 text-sm py-2.5 px-3">
                    <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1" class="text-xs text-red-600">Hapus obat ini</button>
                </div>
            </template>

            <button type="button" @click="items.push({medication_id:'',dosage:'',frequency:'',duration:'',quantity:1,instructions:''})"
                    class="text-sm text-teal-700">+ Tambah Obat Lain</button>

            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Simpan Resep
            </button>
        </form>
    </div>
</x-layouts.app>
