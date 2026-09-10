<x-layouts.app title="Tambah Pasien">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Tambah Pasien Baru</h2>
        <form method="POST" action="{{ route('patients.store') }}" class="space-y-4">
            @csrf
            @include('patients._form')
            <button type="submit" class="w-full md:w-auto px-6 bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Simpan Pasien
            </button>
        </form>
    </div>
</x-layouts.app>
