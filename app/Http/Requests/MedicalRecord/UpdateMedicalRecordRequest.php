<?php

namespace App\Http\Requests\MedicalRecord;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('medical_record'));
    }

    public function rules(): array
    {
        return [
            'chief_complaint' => ['nullable', 'string'],
            'medical_history' => ['nullable', 'string'],
            'physical_examination' => ['nullable', 'string'],
            'blood_pressure' => ['nullable', 'string', 'max:20'],
            'pulse_rate' => ['nullable', 'integer', 'min:0', 'max:300'],
            'temperature' => ['nullable', 'numeric', 'min:30', 'max:45'],
            'respiratory_rate' => ['nullable', 'integer', 'min:0', 'max:100'],
            'oxygen_saturation' => ['nullable', 'integer', 'min:0', 'max:100'],
            'weight_kg' => ['nullable', 'numeric', 'min:0', 'max:500'],
            'height_cm' => ['nullable', 'numeric', 'min:0', 'max:300'],
            'diagnosis_notes' => ['nullable', 'string'],
            'doctor_notes' => ['nullable', 'string'],
            'nurse_notes' => ['nullable', 'string'],
            'treatment_plan' => ['nullable', 'string'],
            'follow_up_date' => ['nullable', 'date', 'after_or_equal:examination_date'],
        ];
    }
}
