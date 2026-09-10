<?php

namespace App\Http\Requests\Laboratory;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaboratoryOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('laboratory.manage') || $this->user()->hasRole('super_admin', 'dokter');
    }

    public function rules(): array
    {
        return [
            'medical_record_id' => ['required', 'exists:medical_records,id'],
            'examination_type' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
