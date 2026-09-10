<x-layouts.app title="Data Obat">
    <div class="flex items-center justify-between mb-4">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari obat..."
                   class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <button class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-sm">Cari</button>
        </form>
        <a href="{{ route('medications.create') }}" class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-medium">+ Tambah Obat</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-4 py-3">Kode</th>
                    <th class="text-left px-4 py-3">Nama</th>
                    <th class="text-left px-4 py-3">Satuan</th>
                    <th class="text-right px-4 py-3">Harga</th>
                    <th class="text-right px-4 py-3">Stok</th>
                    <th class="text-right px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($medications as $medication)
                    <tr class="hover:bg-slate-50 {{ $medication->stock < 10 ? 'bg-red-50/40' : '' }}">
                        <td class="px-4 py-3 text-slate-500">{{ $medication->code }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $medication->name }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $medication->unit }}</td>
                        <td class="px-4 py-3 text-right">Rp{{ number_format($medication->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right {{ $medication->stock < 10 ? 'text-red-600 font-medium' : '' }}">{{ $medication->stock }}</td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('medications.edit', $medication) }}" class="text-teal-700">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $medications->links() }}</div>
</x-layouts.app>
