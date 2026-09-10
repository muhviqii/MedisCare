<?php

namespace App\Http\Requests\Registration;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('registrations.manage') || $this->user()->hasRole('super_admin');
    }

    public function rules(): array
    {
        return [
            // Pasien lama/baru (Bagian 10): kirim patient_id (lama) ATAU data pasien baru.
            'patient_id' => ['nullable', 'exists:patients,id', 'required_without:new_patient'],
            'new_patient' => ['nullable', 'array', 'required_without:patient_id'],
            'new_patient.nik' => ['required_with:new_patient', 'digits:16', 'unique:patients,nik'],
            'new_patient.full_name' => ['required_with:new_patient', 'string', 'max:255'],
            'new_patient.gender' => ['required_with:new_patient', Rule::in(['male', 'female'])],
            'new_patient.birth_date' => ['required_with:new_patient', 'date', 'before_or_equal:today'],
            'new_patient.phone' => ['nullable', 'string', 'max:20'],

            'polyclinic_id' => ['required', 'exists:polyclinics,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'doctor_schedule_id' => ['nullable', 'exists:doctor_schedules,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
