<?php

use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QrCodeController::class, 'index'])->name('qrcode.index');
Route::post('/generate', [QrCodeController::class, 'generate'])->name('qrcode.generate');
Route::post('/download', [QrCodeController::class, 'download'])->name('qrcode.download');
