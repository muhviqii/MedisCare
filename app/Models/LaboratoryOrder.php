<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaboratoryOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code', 'medical_record_id', 'patient_id', 'doctor_id',
        'examination_type', 'order_date', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return ['order_date' => 'datetime'];
    }

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(LaboratoryResult::class);
    }
}
