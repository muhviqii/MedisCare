<x-layouts.app title="Laboratorium">
    <div class="space-y-2">
        @forelse ($orders as $order)
            <a href="{{ route('laboratory.show', $order) }}" class="block bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-slate-800">{{ $order->patient->full_name }}</p>
                        <p class="text-xs text-slate-500">{{ $order->order_code }} &middot; {{ $order->examination_type }}</p>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full
                        {{ match($order->status) { 'completed' => 'bg-teal-50 text-teal-700', 'processing' => 'bg-amber-50 text-amber-700', default => 'bg-slate-100 text-slate-500' } }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </a>
        @empty
            <p class="text-sm text-slate-400 text-center py-8">Belum ada permintaan laboratorium.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
</x-layouts.app>
