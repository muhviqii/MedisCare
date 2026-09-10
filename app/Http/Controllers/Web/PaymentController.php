<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\StorePaymentRequest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct(private readonly AuditLogService $audit)
    {
    }

    public function store(StorePaymentRequest $request, Invoice $invoice): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($invoice, $validated) {
            Payment::create([
                'payment_code' => 'PAY-'.now()->year.'-'.str_pad((string) (Payment::count() + 1), 6, '0', STR_PAD_LEFT),
                'invoice_id' => $invoice->id,
                'amount' => $validated['amount'],
                'method' => $validated['method'],
                'reference_number' => $validated['reference_number'] ?? 'DUMMY-'.Str::upper(Str::random(8)),
                'status' => 'success',
                'processed_by' => Auth::id(),
            ]);

            $newPaidAmount = $invoice->paid_amount + $validated['amount'];
            $invoice->update([
                'paid_amount' => $newPaidAmount,
                'status' => $newPaidAmount >= $invoice->grand_total ? 'paid' : 'partial',
            ]);
        });

        $this->audit->log('Processed Payment', 'invoices', $invoice->id);

        return redirect()->route('invoices.show', $invoice)->with('status', 'Pembayaran berhasil diproses.');
    }
}
