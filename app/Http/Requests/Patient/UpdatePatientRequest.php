<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('patient'));
    }

    public function rules(): array
    {
        $patientId = $this->route('patient')->id;

        return [
            'nik' => ['required', 'digits:16', Rule::unique('patients', 'nik')->ignore($patientId)],
            'full_name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:100'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'blood_type' => ['nullable', Rule::in(['A', 'B', 'AB', 'O', 'unknown'])],
            'allergies' => ['nullable', 'string'],
            'marital_status' => ['nullable', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'occupation' => ['nullable', 'string', 'max:100'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'nik.digits' => 'NIK harus berupa 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar dalam sistem.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh berada di masa depan.',
        ];
    }
}
