<?php

namespace App\Http\Requests\Radiology;

use Illuminate\Foundation\Http\FormRequest;

class StoreRadiologyOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('radiology.manage') || $this->user()->hasRole('super_admin', 'dokter');
    }

    public function rules(): array
    {
        return [
            'medical_record_id' => ['required', 'exists:medical_records,id'],
            'examination_type' => ['required', 'string', 'max:255'],
        ];
    }
}
