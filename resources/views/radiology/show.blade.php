<x-layouts.app title="Detail Radiologi">
    <div class="max-w-lg mx-auto space-y-4">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h2 class="font-semibold text-slate-800">{{ $order->order_code }}</h2>
            <p class="text-xs text-slate-500 mb-2">{{ $order->patient->full_name }} &middot; {{ $order->examination_type }}</p>
            <span class="text-xs px-2 py-0.5 rounded-full {{ $order->status === 'completed' ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500' }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        @if ($order->result)
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-2">Hasil</h3>
            <p class="text-sm text-slate-600 whitespace-pre-line mb-2">{{ $order->result->findings }}</p>
            <p class="text-sm font-medium text-slate-700">Kesimpulan: {{ $order->result->conclusion }}</p>
            @if ($order->result->result_file)
                <a href="{{ route('radiology.download', $order) }}" class="inline-block mt-3 text-sm text-teal-700">📎 Unduh File Hasil</a>
            @endif
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Input Hasil</h3>
            <form method="POST" action="{{ route('radiology.result.store', $order) }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <textarea name="findings" rows="3" placeholder="Temuan" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4"></textarea>
                <textarea name="conclusion" rows="2" placeholder="Kesimpulan" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4"></textarea>
                <input type="file" name="result_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-sm">
                <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">Simpan Hasil</button>
            </form>
        </div>
        @endif
    </div>
</x-layouts.app>
