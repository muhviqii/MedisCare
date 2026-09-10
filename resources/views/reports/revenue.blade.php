<x-layouts.app title="Laporan Pendapatan">
    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
        <form method="GET" class="flex gap-2 flex-wrap">
            <input type="date" name="from" value="{{ request('from') }}" class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <input type="date" name="to" value="{{ request('to') }}" class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <select name="status" class="rounded-xl border-slate-300 text-sm py-2 px-3">
                <option value="">Semua Status</option>
                @foreach (['unpaid' => 'Belum Dibayar', 'partial' => 'Sebagian', 'paid' => 'Lunas'] as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">Filter</button>
        </form>
        <div class="flex gap-2">
            <a href="{{ route('reports.export.invoices', request()->query()) }}" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-sm">⬇ Excel</a>
            <a href="{{ route('reports.export.revenue-pdf', request()->query()) }}" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">⬇ PDF</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
        <p class="text-xs text-slate-500">Total Pendapatan (sesuai filter)</p>
        <p class="text-2xl font-semibold text-teal-700">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr><th class="text-left px-4 py-3">No. Invoice</th><th class="text-left px-4 py-3">Pasien</th><th class="text-right px-4 py-3">Total</th><th class="text-right px-4 py-3">Dibayar</th><th class="text-left px-4 py-3">Status</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($invoices as $invoice)
                    <tr>
                        <td class="px-4 py-3">{{ $invoice->invoice_number }}</td>
                        <td class="px-4 py-3">{{ $invoice->patient->full_name }}</td>
                        <td class="px-4 py-3 text-right">Rp{{ number_format($invoice->grand_total, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">Rp{{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ ucfirst($invoice->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $invoices->links() }}</div>
</x-layouts.app>
