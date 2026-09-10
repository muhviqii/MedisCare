<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Doctor::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'nip' => ['nullable', 'string', 'max:30', 'unique:doctors,nip'],
            'str_number' => ['nullable', 'string', 'max:50'],
            'sip_number' => ['nullable', 'string', 'max:50'],
            'specialty_id' => ['required', 'exists:specialties,id'],
            'polyclinic_id' => ['nullable', 'exists:polyclinics,id'],
            'email' => ['nullable', 'email', 'max:255', 'unique:doctors,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'status' => ['required', Rule::in(['active', 'inactive', 'on_leave'])],
        ];
    }
}
