<x-layouts.app title="Detail Invoice">
    <div class="max-w-lg mx-auto space-y-4">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 class="font-semibold text-slate-800">{{ $invoice->invoice_number }}</h2>
                    <p class="text-xs text-slate-500">{{ $invoice->patient->full_name }} &middot; {{ ucfirst($invoice->service_type) }}</p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full
                    {{ match($invoice->status) { 'paid' => 'bg-teal-50 text-teal-700', 'partial' => 'bg-amber-50 text-amber-700', 'unpaid' => 'bg-red-50 text-red-700', default => 'bg-slate-100 text-slate-500' } }}">
                    {{ ucfirst($invoice->status) }}
                </span>
            </div>

            <table class="w-full text-sm mb-3">
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr class="border-t border-slate-100">
                            <td class="py-2">{{ $item->description }}</td>
                            <td class="py-2 text-right">Rp{{ number_format($item->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <dl class="text-sm space-y-1 border-t border-slate-200 pt-2">
                <div class="flex justify-between"><dt class="text-slate-400">Subtotal</dt><dd>Rp{{ number_format($invoice->subtotal, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">Diskon</dt><dd>-Rp{{ number_format($invoice->discount, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">Pajak</dt><dd>Rp{{ number_format($invoice->tax, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between font-semibold text-slate-800"><dt>Total Tagihan</dt><dd>Rp{{ number_format($invoice->grand_total, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-400">Sudah Dibayar</dt><dd>Rp{{ number_format($invoice->paid_amount, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between font-semibold text-red-600"><dt>Sisa</dt><dd>Rp{{ number_format($invoice->remainingBalance(), 0, ',', '.') }}</dd></div>
            </dl>
        </div>

        @if ($invoice->remainingBalance() > 0)
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Proses Pembayaran</h3>
            @error('amount') <p class="text-red-600 text-xs mb-2">{{ $message }}</p> @enderror
            <form method="POST" action="{{ route('payments.store', $invoice) }}" class="space-y-3">
                @csrf
                <input type="number" name="amount" placeholder="Jumlah bayar" max="{{ $invoice->remainingBalance() }}" required
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                <select name="method" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    @foreach (['cash' => 'Tunai', 'transfer' => 'Transfer', 'debit' => 'Kartu Debit', 'qris' => 'QRIS', 'insurance' => 'Asuransi'] as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-400">Prototype menggunakan gateway pembayaran dummy. Nomor referensi dibuat otomatis. Tidak ada data kartu sensitif yang disimpan.</p>
                <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                    Proses Pembayaran
                </button>
            </form>
        </div>
        @endif

        @if ($invoice->payments->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Riwayat Pembayaran</h3>
            @foreach ($invoice->payments as $payment)
                <div class="flex justify-between text-sm py-1.5 border-b last:border-0 border-slate-100">
                    <span>{{ $payment->payment_code }} &middot; {{ strtoupper($payment->method) }}</span>
                    <span class="font-medium">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
        @endif
    </div>
</x-layouts.app>
