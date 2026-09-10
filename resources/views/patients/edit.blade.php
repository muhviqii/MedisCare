<x-layouts.app title="Edit Pasien">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Edit Data Pasien — {{ $patient->medical_record_number }}</h2>
        <form method="POST" action="{{ route('patients.update', $patient) }}" class="space-y-4">
            @csrf
            @method('PUT')
            @include('patients._form')
            <button type="submit" class="w-full md:w-auto px-6 bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Simpan Perubahan
            </button>
        </form>
    </div>
</x-layouts.app>
