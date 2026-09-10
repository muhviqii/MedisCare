<x-layouts.app title="Pengaturan">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Pengaturan Sistem</h2>
        <p class="text-xs text-slate-500 mb-4">
            Nilai di bawah ini bersumber dari file <code>.env</code> / konfigurasi server dan
            bersifat read-only di sini — sesuai prinsip keamanan (Bagian 28), kredensial dan
            konfigurasi sensitif tidak diubah lewat antarmuka web.
        </p>
        <dl class="divide-y divide-slate-100 text-sm">
            @foreach ($settings as $key => $value)
                <div class="flex justify-between py-2">
                    <dt class="text-slate-500">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                    <dd class="font-medium text-slate-800">
                        @if (is_bool($value))
                            {{ $value ? 'Aktif' : 'Nonaktif' }}
                        @else
                            {{ $value }}
                        @endif
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</x-layouts.app>
