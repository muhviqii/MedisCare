<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements FromCollection, WithHeadings
{
    public function __construct(private readonly array $filters = [])
    {
    }

    public function collection(): Collection
    {
        return Invoice::with('patient')
            ->when($this->filters['from'] ?? null, fn ($q, $from) => $q->whereDate('created_at', '>=', $from))
            ->when($this->filters['to'] ?? null, fn ($q, $to) => $q->whereDate('created_at', '<=', $to))
            ->when($this->filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->get()
            ->map(fn ($invoice) => [
                $invoice->invoice_number,
                $invoice->patient->full_name,
                ucfirst($invoice->service_type),
                $invoice->grand_total,
                $invoice->paid_amount,
                ucfirst($invoice->status),
                $invoice->created_at->toDateString(),
            ]);
    }

    public function headings(): array
    {
        return ['No. Invoice', 'Pasien', 'Jenis Layanan', 'Total', 'Dibayar', 'Status', 'Tanggal'];
    }
}
