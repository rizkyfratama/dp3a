<?php

use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/pengaduan');
});

// Form publik
Route::get('/pengaduan', [PengaduanController::class, 'create']);
Route::post('/pengaduan', [PengaduanController::class, 'store']);

// Admin/list (simple, tanpa auth untuk sekarang — tambahkan middleware auth bila perlu)
Route::get('/list', [PengaduanController::class, 'index']);

// Export & upload
Route::get('/export', [PengaduanController::class, 'export']);
Route::get('/export-upload', [PengaduanController::class, 'exportAndUpload']);
