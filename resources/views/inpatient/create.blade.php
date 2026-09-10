<x-layouts.app title="Rawat Inap Baru">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Pendaftaran Rawat Inap</h2>
        <form method="POST" action="{{ route('inpatient.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ID Pasien <span class="text-red-500">*</span></label>
                <input type="number" name="patient_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                <p class="text-xs text-slate-400 mt-1">Cari No. RM di <a href="{{ route('patients.index') }}" class="text-teal-700">Daftar Pasien</a>.</p>
                @error('patient_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">ID Dokter Penanggung Jawab <span class="text-red-500">*</span></label>
                <input type="number" name="doctor_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                @error('doctor_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Bed Tersedia <span class="text-red-500">*</span></label>
                <select name="bed_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <option value="">-- Pilih Bed --</option>
                    @foreach ($availableBeds as $bed)
                        <option value="{{ $bed->id }}">{{ $bed->room->building }} / {{ $bed->room->room_number }} — Bed {{ $bed->bed_number }} ({{ strtoupper(str_replace('_',' ',$bed->room->room_class)) }})</option>
                    @endforeach
                </select>
                @error('bed_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Masuk <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="admission_date" value="{{ now()->format('Y-m-d\TH:i') }}" required
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Diagnosis Awal</label>
                <textarea name="diagnosis" rows="2" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4"></textarea>
            </div>
            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Daftarkan Rawat Inap
            </button>
        </form>
    </div>
</x-layouts.app>
