<x-layouts.app title="Edit Dokter">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Edit Dokter — {{ $doctor->doctor_code }}</h2>
        <form method="POST" action="{{ route('doctors.update', $doctor) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            @include('doctors._form')
            <button type="submit" class="w-full md:w-auto px-6 bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Simpan Perubahan
            </button>
        </form>
    </div>
</x-layouts.app>
