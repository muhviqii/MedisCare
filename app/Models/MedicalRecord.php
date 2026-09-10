<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_code', 'patient_id', 'doctor_id', 'nurse_id', 'appointment_id', 'examination_date',
        'chief_complaint', 'medical_history', 'physical_examination', 'blood_pressure', 'pulse_rate',
        'temperature', 'respiratory_rate', 'oxygen_saturation', 'weight_kg', 'height_cm',
        'diagnosis_notes', 'doctor_notes', 'nurse_notes', 'treatment_plan', 'follow_up_date',
    ];

    protected function casts(): array
    {
        return ['examination_date' => 'datetime', 'follow_up_date' => 'date'];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(Nurse::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function diagnoses(): HasMany
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function actions(): HasMany
    {
        return $this->hasMany(MedicalAction::class);
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function laboratoryOrders(): HasMany
    {
        return $this->hasMany(LaboratoryOrder::class);
    }

    public function radiologyOrders(): HasMany
    {
        return $this->hasMany(RadiologyOrder::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(MedicalRecordRevision::class);
    }
}
