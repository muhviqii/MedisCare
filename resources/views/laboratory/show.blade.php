<x-layouts.app title="Detail Laboratorium">
    <div class="max-w-lg mx-auto space-y-4">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h2 class="font-semibold text-slate-800">{{ $order->order_code }}</h2>
                    <p class="text-xs text-slate-500">{{ $order->patient->full_name }} &middot; {{ $order->examination_type }}</p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full
                    {{ match($order->status) { 'completed' => 'bg-teal-50 text-teal-700', 'processing' => 'bg-amber-50 text-amber-700', default => 'bg-slate-100 text-slate-500' } }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            @if ($order->status === 'requested')
                <form method="POST" action="{{ route('laboratory.process', $order) }}">
                    @csrf
                    <button class="px-4 py-2 bg-amber-500 text-white rounded-xl text-sm">Mulai Proses</button>
                </form>
            @endif
        </div>

        @if ($order->results->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Hasil</h3>
            <table class="w-full text-sm">
                <thead class="text-xs text-slate-400"><tr><th class="text-left py-1">Parameter</th><th class="text-left py-1">Hasil</th><th class="text-left py-1">Normal</th></tr></thead>
                <tbody>
                    @foreach ($order->results as $result)
                        <tr class="border-t border-slate-100">
                            <td class="py-2">{{ $result->parameter_name }}</td>
                            <td class="py-2">{{ $result->result_value }} {{ $result->unit }}</td>
                            <td class="py-2 text-slate-400">{{ $result->normal_value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @elseif ($order->status !== 'requested')
        <div class="bg-white rounded-2xl shadow-sm p-5" x-data="{ rows: [{parameter_name:'',result_value:'',normal_value:'',unit:''}] }">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Input Hasil</h3>
            <form method="POST" action="{{ route('laboratory.results.store', $order) }}" class="space-y-2">
                @csrf
                <template x-for="(row, i) in rows" :key="i">
                    <div class="grid grid-cols-4 gap-2">
                        <input type="text" :name="`results[${i}][parameter_name]`" placeholder="Parameter" required class="rounded-lg border-slate-300 text-xs py-2 px-2 col-span-1">
                        <input type="text" :name="`results[${i}][result_value]`" placeholder="Hasil" required class="rounded-lg border-slate-300 text-xs py-2 px-2">
                        <input type="text" :name="`results[${i}][normal_value]`" placeholder="Normal" class="rounded-lg border-slate-300 text-xs py-2 px-2">
                        <input type="text" :name="`results[${i}][unit]`" placeholder="Satuan" class="rounded-lg border-slate-300 text-xs py-2 px-2">
                    </div>
                </template>
                <button type="button" @click="rows.push({parameter_name:'',result_value:'',normal_value:'',unit:''})" class="text-xs text-teal-700">+ Tambah Parameter</button>
                <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-2.5 text-sm font-medium mt-2">Simpan Hasil</button>
            </form>
        </div>
        @endif
    </div>
</x-layouts.app>
