<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Admission;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

/**
 * Menyusun invoice dari layanan yang sudah diberikan (Bagian 19):
 * tindakan medis, obat (resep), laboratorium, radiologi, kamar (rawat inap).
 */
class BillingService
{
    public function __construct(
        private readonly NumberGeneratorService $numberGenerator,
        private readonly AuditLogService $audit,
    ) {
    }

    public function generateForOutpatient(Appointment $appointment): Invoice
    {
        return DB::transaction(function () use ($appointment) {
            $invoice = Invoice::firstOrCreate(
                ['appointment_id' => $appointment->id],
                [
                    'invoice_number' => $this->numberGenerator->generate('invoices', 'invoice_number', 'INV'),
                    'patient_id' => $appointment->patient_id,
                    'service_type' => 'outpatient',
                    'status' => 'pending',
                ]
            );

            $invoice->items()->delete();

            foreach ($appointment->medicalRecords as $record) {
                foreach ($record->actions as $action) {
                    $invoice->items()->create([
                        'item_type' => 'medical_action',
                        'description' => $action->action_name,
                        'quantity' => 1,
                        'unit_price' => $action->cost,
                        'total_price' => $action->cost,
                    ]);
                }

                foreach ($record->prescriptions as $prescription) {
                    foreach ($prescription->items as $item) {
                        $price = $item->medication->price * $item->quantity;
                        $invoice->items()->create([
                            'item_type' => 'medication',
                            'description' => $item->medication->name.' x'.$item->quantity,
                            'quantity' => $item->quantity,
                            'unit_price' => $item->medication->price,
                            'total_price' => $price,
                        ]);
                    }
                }

                foreach ($record->laboratoryOrders as $lab) {
                    $invoice->items()->create([
                        'item_type' => 'laboratory',
                        'description' => $lab->examination_type,
                        'quantity' => 1,
                        'unit_price' => 150000,
                        'total_price' => 150000,
                    ]);
                }

                foreach ($record->radiologyOrders as $rad) {
                    $invoice->items()->create([
                        'item_type' => 'radiology',
                        'description' => $rad->examination_type,
                        'quantity' => 1,
                        'unit_price' => 300000,
                        'total_price' => 300000,
                    ]);
                }
            }

            return $this->recalculateTotals($invoice);
        });
    }

    public function generateForInpatient(Admission $admission): Invoice
    {
        return DB::transaction(function () use ($admission) {
            $invoice = Invoice::firstOrCreate(
                ['admission_id' => $admission->id],
                [
                    'invoice_number' => $this->numberGenerator->generate('invoices', 'invoice_number', 'INV'),
                    'patient_id' => $admission->patient_id,
                    'service_type' => 'inpatient',
                    'status' => 'pending',
                ]
            );

            $invoice->items()->where('item_type', 'room')->delete();

            $days = max(1, $admission->admission_date->diffInDays($admission->discharge_date ?? now()));
            $rate = $admission->bed->room->daily_rate;

            $invoice->items()->create([
                'item_type' => 'room',
                'description' => "Sewa kamar {$admission->bed->room->room_number} ({$days} hari)",
                'quantity' => $days,
                'unit_price' => $rate,
                'total_price' => $days * $rate,
            ]);

            return $this->recalculateTotals($invoice);
        });
    }

    public function recalculateTotals(Invoice $invoice): Invoice
    {
        $subtotal = $invoice->items()->sum('total_price');
        $grandTotal = $subtotal - $invoice->discount + $invoice->tax;
        $status = $this->resolveStatus($invoice->paid_amount, $grandTotal);

        $invoice->update([
            'subtotal' => $subtotal,
            'grand_total' => $grandTotal,
            'status' => $status,
        ]);

        $invoice->refresh();

        if ($invoice->status === 'unpaid') {
            $recipients = \App\Models\User::whereHas('role', fn ($q) => $q->where('slug', 'petugas_administrasi'))->get();
            \Illuminate\Support\Facades\Notification::send($recipients, new \App\Notifications\InvoiceUnpaidNotification($invoice));
        }

        return $invoice->fresh('items');
    }

    private function resolveStatus(float $paidAmount, float $grandTotal): string
    {
        if ($paidAmount <= 0) {
            return $grandTotal > 0 ? 'unpaid' : 'pending';
        }

        return $paidAmount >= $grandTotal ? 'paid' : 'partial';
    }
}
