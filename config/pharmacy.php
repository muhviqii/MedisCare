<?php

return [
    /**
     * Jika true, sistem menolak resep yang meminta obat melebihi stok tersedia
     * (Bagian 16: "Jangan izinkan dokter memberikan obat yang tidak tersedia
     * jika sistem dikonfigurasi untuk menggunakan validasi stok").
     * Set PHARMACY_VALIDATE_STOCK=false di .env untuk menonaktifkan.
     */
    'validate_stock' => env('PHARMACY_VALIDATE_STOCK', true),
];
