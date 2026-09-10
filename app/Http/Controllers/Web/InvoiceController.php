<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Services\BillingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function __construct(private readonly BillingService $billingService)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Invoice::class);

        $invoices = Invoice::with('patient')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('billing.invoices.index', compact('invoices'));
    }

    public function generateFromAppointment(Appointment $appointment): RedirectResponse
    {
        $this->authorize('create', Invoice::class);

        $invoice = $this->billingService->generateForOutpatient($appointment);

        return redirect()->route('invoices.show', $invoice)->with('status', 'Invoice berhasil dibuat dari kunjungan rawat jalan.');
    }

    public function generateFromAdmission(Admission $admission): RedirectResponse
    {
        $this->authorize('create', Invoice::class);

        $invoice = $this->billingService->generateForInpatient($admission);

        return redirect()->route('invoices.show', $invoice)->with('status', 'Invoice berhasil dibuat dari rawat inap.');
    }

    public function show(Invoice $invoice): View
    {
        $this->authorize('view', $invoice);

        $invoice->load(['patient', 'items', 'payments']);

        return view('billing.invoices.show', compact('invoice'));
    }
}
