<?php

namespace App\Http\Requests\Admission;

use Illuminate\Foundation\Http\FormRequest;

class DischargeAdmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('admissions.manage') || $this->user()->hasRole('super_admin');
    }

    public function rules(): array
    {
        return [
            'discharge_date' => ['required', 'date'],
            'discharge_notes' => ['nullable', 'string'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $admission = $this->route('admission');
            if ($admission && $this->input('discharge_date') < $admission->admission_date->toDateString()) {
                $validator->errors()->add('discharge_date', 'Tanggal keluar tidak boleh sebelum tanggal masuk.');
            }
        });
    }
}
