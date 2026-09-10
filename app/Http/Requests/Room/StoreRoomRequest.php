<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('super_admin', 'admin_rs');
    }

    public function rules(): array
    {
        return [
            'building' => ['required', 'string', 'max:100'],
            'floor' => ['required', 'string', 'max:20'],
            'room_number' => ['required', 'string', 'max:20'],
            'room_class' => ['required', Rule::in(['vip', 'class_1', 'class_2', 'class_3', 'icu', 'isolation'])],
            'daily_rate' => ['required', 'numeric', 'min:0'],
            'bed_count' => ['required', 'integer', 'min:1', 'max:20'],
        ];
    }
}
