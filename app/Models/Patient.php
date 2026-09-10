<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'medical_record_number', 'nik', 'full_name', 'nickname', 'gender', 'birth_place',
        'birth_date', 'address', 'phone', 'email', 'blood_type', 'allergies',
        'marital_status', 'occupation', 'emergency_contact_name', 'emergency_contact_phone', 'status',
    ];

    protected function casts(): array
    {
        return ['birth_date' => 'date'];
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function age(): int
    {
        return $this->birth_date->age;
    }
}
