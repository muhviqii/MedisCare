<?php

namespace App\Http\Requests\MedicalRecord;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\MedicalRecord::class);
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'nurse_id' => ['nullable', 'exists:nurses,id'],
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'examination_date' => ['required', 'date'],
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

            // Diagnosis (bisa lebih dari satu)
            'diagnoses' => ['nullable', 'array'],
            'diagnoses.*.diagnosis_name' => ['required_with:diagnoses', 'string', 'max:255'],
            'diagnoses.*.icd10_code' => ['nullable', 'string', 'max:20'],
            'diagnoses.*.diagnosis_type' => ['nullable', 'in:primary,secondary'],

            // Tindakan
            'actions' => ['nullable', 'array'],
            'actions.*.action_name' => ['required_with:actions', 'string', 'max:255'],
            'actions.*.cost' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
