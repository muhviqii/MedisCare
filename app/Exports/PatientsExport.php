<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class PatientsExport extends DefaultValueBinder implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithCustomValueBinder
{
    public function query()
    {
        return Patient::query();
    }

    public function headings(): array
    {
        return [
            'No. RM',
            'Nama',
            'NIK',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Telepon',
            'Status',
        ];
    }

    public function map($patient): array
    {
        return [
            $patient->mr_number ?? $patient->medical_record_number,
            $patient->name ?? $patient->full_name ?? $patient->nama, // Mengambil field nama yang sesuai
            $patient->nik,
            $patient->gender,
            $patient->dob ?? $patient->birth_date,
            $patient->phone,
            $patient->status,
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        // Paksa kolom NIK (C) dan Telepon (F) disimpan sebagai STRING murni
        if (in_array($cell->getColumn(), ['C', 'F'])) {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
}