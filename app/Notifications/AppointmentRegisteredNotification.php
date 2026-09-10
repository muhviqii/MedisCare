<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * "Pasien MR-2026-000123 telah terdaftar." (Bagian 23)
 */
class AppointmentRegisteredNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Appointment $appointment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Pendaftaran Baru',
            'message' => "Pasien {$this->appointment->patient->medical_record_number} telah terdaftar.",
            'appointment_id' => $this->appointment->id,
        ];
    }
}
