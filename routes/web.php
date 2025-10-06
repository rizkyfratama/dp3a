<?php

use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\GoogleDriveController;
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

// Google Drive
Route::get('/google/login', [GoogleDriveController::class, 'login'])->name('google.login');
Route::get('/google/callback', [GoogleDriveController::class, 'callback'])->name('google.callback');
Route::post('/upload-drive', [GoogleDriveController::class, 'upload']);
