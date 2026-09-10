<x-layouts.app title="Permintaan Radiologi">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-1">Permintaan Pemeriksaan Radiologi</h2>
        <p class="text-xs text-slate-500 mb-4">Pasien: {{ $medicalRecord->patient->full_name }}</p>
        <form method="POST" action="{{ route('radiology.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="medical_record_id" value="{{ $medicalRecord->id }}">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Pemeriksaan <span class="text-red-500">*</span></label>
                <input type="text" name="examination_type" placeholder="Rontgen Thorax, USG, CT Scan, dsb" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">Ajukan Permintaan</button>
        </form>
    </div>
</x-layouts.app>
