<x-layouts.app title="Tambah Obat">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Tambah Obat</h2>
        <form method="POST" action="{{ route('medications.store') }}" class="space-y-4">
            @csrf
            @include('pharmacy.medications._form')
            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">Simpan</button>
        </form>
    </div>
</x-layouts.app>
