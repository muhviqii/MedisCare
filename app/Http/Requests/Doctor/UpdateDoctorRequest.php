<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('doctor'));
    }

    public function rules(): array
    {
        $doctorId = $this->route('doctor')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'nip' => ['nullable', 'string', 'max:30', Rule::unique('doctors', 'nip')->ignore($doctorId)],
            'str_number' => ['nullable', 'string', 'max:50'],
            'sip_number' => ['nullable', 'string', 'max:50'],
            'specialty_id' => ['required', 'exists:specialties,id'],
            'polyclinic_id' => ['nullable', 'exists:polyclinics,id'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('doctors', 'email')->ignore($doctorId)],
            'phone' => ['nullable', 'string', 'max:20'],
            'status' => ['required', Rule::in(['active', 'inactive', 'on_leave'])],
        ];
    }
}
