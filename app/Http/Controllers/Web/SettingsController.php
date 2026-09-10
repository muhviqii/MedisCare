<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Halaman Settings (Bagian 32). Untuk prototype ini menampilkan ringkasan
 * konfigurasi sistem yang bersumber dari .env / config (read-only) —
 * perubahan nilai sensitif tetap harus lewat file .env, bukan lewat UI,
 * sesuai prinsip Bagian 28 (jangan hardcode/expose credentials).
 */
class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = [
            'app_name' => config('app.name'),
            'app_timezone' => config('app.timezone'),
            'app_locale' => config('app.locale'),
            'session_lifetime_minutes' => config('session.lifetime'),
            'pharmacy_validate_stock' => config('pharmacy.validate_stock'),
            'mr_number_prefix' => env('MR_NUMBER_PREFIX', 'MR'),
        ];

        return view('settings.index', compact('settings'));
    }
}
