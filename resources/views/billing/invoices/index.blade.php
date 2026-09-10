<x-layouts.app title="Invoice">
    <form method="GET" class="mb-4">
        <select name="status" onchange="this.form.submit()" class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <option value="">Semua Status</option>
            @foreach (['pending' => 'Pending', 'unpaid' => 'Belum Dibayar', 'partial' => 'Dibayar Sebagian', 'paid' => 'Lunas', 'cancelled' => 'Dibatalkan'] as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </form>

    <div class="space-y-2">
        @forelse ($invoices as $invoice)
            <a href="{{ route('invoices.show', $invoice) }}" class="block bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-slate-800">{{ $invoice->patient->full_name }}</p>
                        <p class="text-xs text-slate-500">{{ $invoice->invoice_number }} &middot; {{ ucfirst($invoice->service_type) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-slate-800">Rp{{ number_format($invoice->grand_total, 0, ',', '.') }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ match($invoice->status) { 'paid' => 'bg-teal-50 text-teal-700', 'partial' => 'bg-amber-50 text-amber-700', 'unpaid' => 'bg-red-50 text-red-700', default => 'bg-slate-100 text-slate-500' } }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-sm text-slate-400 text-center py-8">Belum ada invoice.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $invoices->links() }}</div>
</x-layouts.app>
