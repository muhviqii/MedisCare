<x-layouts.app title="Rekam Medis Baru">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-1">Rekam Medis Baru</h2>
        <p class="text-xs text-slate-500 mb-4">Pasien: {{ $patient->full_name }} ({{ $patient->medical_record_number }})</p>

        <form method="POST" action="{{ route('medical-records.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Dokter <span class="text-red-500">*</span></label>
                <select name="doctor_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <option value="">-- Pilih Dokter --</option>
                    @foreach (\App\Models\Doctor::where('status', 'active')->orderBy('name')->get() as $doctor)
                        <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>
                            {{ $doctor->name }} ({{ $doctor->specialty?->name }})
                        </option>
                    @endforeach
                </select>
                @error('doctor_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal & Waktu Pemeriksaan <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="examination_date" value="{{ old('examination_date', now()->format('Y-m-d\TH:i')) }}" required
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Keluhan Utama</label>
                <textarea name="chief_complaint" rows="2" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">{{ old('chief_complaint') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tekanan Darah</label>
                    <input type="text" name="blood_pressure" placeholder="120/80" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Denyut Nadi</label>
                    <input type="number" name="pulse_rate" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Suhu (&deg;C)</label>
                    <input type="number" step="0.1" name="temperature" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Saturasi O2 (%)</label>
                    <input type="number" name="oxygen_saturation" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Berat Badan (kg)</label>
                    <input type="number" step="0.1" name="weight_kg" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tinggi Badan (cm)</label>
                    <input type="number" step="0.1" name="height_cm" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Diagnosis</label>
                <input type="text" name="diagnoses[0][diagnosis_name]" placeholder="Nama diagnosis"
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Dokter</label>
                <textarea name="doctor_notes" rows="3" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">{{ old('doctor_notes') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Rencana Terapi</label>
                <textarea name="treatment_plan" rows="2" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">{{ old('treatment_plan') }}</textarea>
            </div>

            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Simpan Rekam Medis
            </button>
        </form>
    </div>
</x-layouts.app>
