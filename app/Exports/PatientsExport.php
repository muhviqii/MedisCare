<?php

namespace App\Exports;

use App\Models\Patient;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientsExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Patient::query()->get()->map(fn ($patient) => [
            $patient->medical_record_number,
            $patient->full_name,
            $patient->nik,
            $patient->gender === 'male' ? 'Laki-laki' : 'Perempuan',
            $patient->birth_date->toDateString(),
            $patient->phone,
            ucfirst($patient->status),
        ]);
    }

    public function headings(): array
    {
        return ['No. RM', 'Nama', 'NIK', 'Jenis Kelamin', 'Tanggal Lahir', 'Telepon', 'Status'];
    }
}
