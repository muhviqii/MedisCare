<x-layouts.app title="Edit Rekam Medis">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-1">Edit Rekam Medis — {{ $medicalRecord->record_code }}</h2>
        <p class="text-xs text-amber-600 mb-4">Perubahan pada rekam medis akan dicatat pada riwayat revisi (audit trail) dan tidak menghapus data sebelumnya.</p>

        <form method="POST" action="{{ route('medical-records.update', $medicalRecord) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Keluhan Utama</label>
                <textarea name="chief_complaint" rows="2" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">{{ old('chief_complaint', $medicalRecord->chief_complaint) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Diagnosis (catatan)</label>
                <textarea name="diagnosis_notes" rows="2" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">{{ old('diagnosis_notes', $medicalRecord->diagnosis_notes) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Dokter</label>
                <textarea name="doctor_notes" rows="3" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">{{ old('doctor_notes', $medicalRecord->doctor_notes) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Rencana Terapi</label>
                <textarea name="treatment_plan" rows="2" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">{{ old('treatment_plan', $medicalRecord->treatment_plan) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Follow-up</label>
                <input type="date" name="follow_up_date" value="{{ old('follow_up_date', $medicalRecord->follow_up_date?->toDateString()) }}"
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>

            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Simpan Perubahan
            </button>
        </form>
    </div>
</x-layouts.app>
