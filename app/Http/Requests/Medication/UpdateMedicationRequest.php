<?php

namespace App\Http\Requests\Medication;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('pharmacy.manage') || $this->user()->hasRole('super_admin', 'admin_rs');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'unit' => ['required', 'string', 'max:30'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'dosage' => ['nullable', 'string', 'max:100'],
            'usage_instructions' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
