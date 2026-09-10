<?php

namespace App\Http\Requests\DoctorSchedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDoctorScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('schedules.manage') || $this->user()->hasRole('super_admin');
    }

    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'exists:doctors,id'],
            'polyclinic_id' => ['nullable', 'exists:polyclinics,id'],
            'schedule_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            // Jam selesai jadwal harus lebih besar daripada jam mulai (Bagian 35).
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room' => ['nullable', 'string', 'max:50'],
            'status' => ['required', Rule::in(['available', 'on_leave', 'holiday', 'cancelled'])],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'end_time.after' => 'Jam selesai jadwal harus lebih besar daripada jam mulai.',
        ];
    }
}
