<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * "Invoice INV-2026-00123 belum dibayar." (Bagian 23)
 */
class InvoiceUnpaidNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Invoice $invoice)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Tagihan Belum Dibayar',
            'message' => "Invoice {$this->invoice->invoice_number} belum dibayar.",
            'invoice_id' => $this->invoice->id,
        ];
    }
}
