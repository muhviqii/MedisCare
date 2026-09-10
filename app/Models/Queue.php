<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id', 'polyclinic_id', 'queue_number', 'queue_date',
        'status', 'called_at', 'completed_at',
    ];

    protected function casts(): array
    {
        return ['queue_date' => 'date', 'called_at' => 'datetime', 'completed_at' => 'datetime'];
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function polyclinic(): BelongsTo
    {
        return $this->belongsTo(Polyclinic::class);
    }
}
