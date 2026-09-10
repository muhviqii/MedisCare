<x-layouts.app title="Poliklinik">
    <div class="flex justify-end mb-4">
        @if (auth()->user()->hasRole('super_admin', 'admin_rs'))
            <a href="{{ route('polyclinics.create') }}" class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-medium">+ Tambah Poli</a>
        @endif
    </div>

    <div class="grid md:grid-cols-2 gap-3">
        @foreach ($polyclinics as $polyclinic)
            <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center justify-between">
                <div>
                    <p class="font-medium text-slate-800">{{ $polyclinic->name }}</p>
                    <p class="text-xs text-slate-500">{{ $polyclinic->code }} &middot; {{ $polyclinic->specialty?->name }}</p>
                </div>
                @if (auth()->user()->hasRole('super_admin', 'admin_rs'))
                    <form method="POST" action="{{ route('polyclinics.toggle', $polyclinic) }}">
                        @csrf
                        <button class="text-xs px-2 py-1 rounded-full {{ $polyclinic->is_active ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $polyclinic->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $polyclinics->links() }}</div>
</x-layouts.app>
