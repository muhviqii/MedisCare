<?php

namespace App\Http\Requests\Laboratory;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaboratoryResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('laboratory.manage') || $this->user()->hasRole('super_admin');
    }

    public function rules(): array
    {
        return [
            'results' => ['required', 'array', 'min:1'],
            'results.*.parameter_name' => ['required', 'string', 'max:255'],
            'results.*.result_value' => ['required', 'string', 'max:100'],
            'results.*.normal_value' => ['nullable', 'string', 'max:100'],
            'results.*.unit' => ['nullable', 'string', 'max:30'],
            'results.*.notes' => ['nullable', 'string'],
        ];
    }
}
