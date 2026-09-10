<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Generator nomor otomatis terpusat (Bagian 6, 10, 11, 19 dst).
 * Menggunakan row lock (lockForUpdate) di dalam transaction agar aman
 * dari race condition ketika dua pendaftaran terjadi bersamaan.
 */
class NumberGeneratorService
{
    /**
     * Contoh: MR-2026-000001, EMR-2026-000001, INV-2026-000001, dst.
     */
    public function generate(string $table, string $column, string $prefix, int $padLength = 6): string
    {
        return DB::transaction(function () use ($table, $column, $prefix, $padLength) {
            $year = now()->year;
            $likePattern = "{$prefix}-{$year}-%";

            $last = DB::table($table)
                ->where($column, 'like', $likePattern)
                ->lockForUpdate()
                ->orderByDesc($column)
                ->value($column);

            $nextNumber = 1;
            if ($last) {
                $lastSequence = (int) substr($last, -$padLength);
                $nextNumber = $lastSequence + 1;
            }

            return sprintf('%s-%d-%s', $prefix, $year, str_pad((string) $nextNumber, $padLength, '0', STR_PAD_LEFT));
        });
    }

    /**
     * Nomor antrean harian per poli, contoh: A-001 (Bagian 11), reset harian.
     */
    public function generateQueueNumber(string $table, string $column, string $prefixLetter, int $polyclinicId, string $date): string
    {
        return DB::transaction(function () use ($table, $column, $prefixLetter, $polyclinicId, $date) {
            $existingNumbers = DB::table($table)
                ->where('polyclinic_id', $polyclinicId)
                ->whereDate('queue_date', $date)
                ->pluck($column)
                ->all();

            $nextNumber = 1;

            foreach ($existingNumbers as $queueNumber) {
                $digits = preg_replace('/\D+/', '', (string) $queueNumber);

                if ($digits === '') {
                    continue;
                }

                $nextNumber = max($nextNumber, ((int) $digits) + 1);
            }

            return sprintf('%s-%s', $prefixLetter, str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT));
        });
    }
}
