<?php

namespace App\Http\Requests\Polyclinic;

use Illuminate\Foundation\Http\FormRequest;

class StorePolyclinicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('super_admin', 'admin_rs');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', 'unique:polyclinics,code'],
            'specialty_id' => ['nullable', 'exists:specialties,id'],
            'location' => ['nullable', 'string', 'max:255'],
        ];
    }
}
