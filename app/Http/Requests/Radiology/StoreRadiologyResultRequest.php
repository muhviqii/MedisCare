<?php

namespace App\Http\Requests\Radiology;

use Illuminate\Foundation\Http\FormRequest;

class StoreRadiologyResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('radiology.manage') || $this->user()->hasRole('super_admin');
    }

    public function rules(): array
    {
        return [
            'findings' => ['nullable', 'string'],
            'conclusion' => ['nullable', 'string'],
            // Storage Laravel yang aman (Bagian 18): disimpan di disk non-public, diakses via
            // route terautentikasi + Policy, bukan URL publik langsung.
            'result_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,dicom', 'max:20480'],
        ];
    }
}
