<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id', 'polyclinic_id', 'day_of_week', 'schedule_date',
        'start_time', 'end_time', 'room', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return ['schedule_date' => 'date'];
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function polyclinic(): BelongsTo
    {
        return $this->belongsTo(Polyclinic::class);
    }

    /**
     * Deteksi bentrok jadwal untuk dokter yang sama pada tanggal & rentang waktu yang sama.
     */
    public function scopeConflicting($query, int $doctorId, string $date, string $start, string $end, ?int $ignoreId = null)
    {
        return $query->where('doctor_id', $doctorId)
            ->where('schedule_date', $date)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_time', '<=', $start)->where('end_time', '>=', $end);
                    });
            })
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId));
    }
}
