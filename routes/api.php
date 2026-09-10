<?php

use Illuminate\Support\Facades\Route;

/**
 * Rute API (Sanctum) untuk konsumsi mobile/PWA offline-sync di masa depan.
 * Endpoint per modul ditambahkan bertahap mengikuti pengerjaan Web routes.
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (\Illuminate\Http\Request $request) => $request->user()->load('role'));

    // GET/POST /api/patients, /api/doctors, dst — ditambahkan pada tahap modul masing-masing.
});
