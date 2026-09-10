<?php

namespace App\Http\Requests\Admission;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('admissions.manage') || $this->user()->hasRole('super_admin');
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'bed_id' => ['required', 'exists:beds,id'],
            'admission_date' => ['required', 'date'],
            'diagnosis' => ['nullable', 'string'],
        ];
    }
}
