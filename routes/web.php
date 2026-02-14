<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuditLogController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('surat/export', [SuratController::class, 'export'])->name('surat.export');
    Route::get('surat/print', [SuratController::class, 'print'])->name('surat.print');
    Route::get('surat/check-number', [SuratController::class, 'getNextNumber'])->name('surat.check-number');
    Route::resource('surat', SuratController::class);
    Route::post('surat/{surat}/approve', [SuratController::class, 'approve'])->name('surat.approve');
    Route::post('surat/{surat}/reject', [SuratController::class, 'reject'])->name('surat.reject');
    Route::get('surat/{surat}/pdf', [SuratController::class, 'downloadPdf'])->name('surat.pdf');
    Route::get('surat/{surat}/verify', [SuratController::class, 'verify'])->name('surat.verify');
    
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
