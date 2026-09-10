<?php

namespace App\Notifications;

use App\Models\DoctorSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * "Dokter Andi memiliki jadwal praktik pukul 08:00." (Bagian 23)
 */
class DoctorScheduleReminderNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly DoctorSchedule $schedule)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Pengingat Jadwal Praktik',
            'message' => "Dokter {$this->schedule->doctor->name} memiliki jadwal praktik pukul {$this->schedule->start_time}.",
            'schedule_id' => $this->schedule->id,
        ];
    }
}
