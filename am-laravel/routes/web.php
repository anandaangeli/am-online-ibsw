<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BudgetRequestController;
use App\Http\Controllers\CashAdvanceController;
use App\Http\Controllers\DocumentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Menu Pengajuan AM (Anggaran Manajemen)
    Route::get('/am', [BudgetRequestController::class, 'index'])->name('budget-request.index');
    Route::get('/budget-request', function() {
        return redirect()->route('budget-request.index');
    });
    Route::post('/am', [BudgetRequestController::class, 'store'])->name('budget-request.store');
    Route::post('/budget-request', [BudgetRequestController::class, 'store']);

    // Menu Cash Advance dialihkan ke Semua Dokumen / AM
    Route::get('/cash-advance', function () {
        return redirect()->route('all-documents.index');
    })->name('cash-advance.index');

    // Menu Semua Dokumen
    Route::get('/all-documents', [DocumentController::class, 'index'])->name('all-documents.index');

    // Aksi Dokumen (Hapus / Update Status)
    Route::delete('/budget-requests/{id}', [BudgetRequestController::class, 'destroy'])->name('budget-requests.destroy');
    Route::patch('/budget-requests/{id}/status', [BudgetRequestController::class, 'updateStatus'])->name('budget-requests.update-status');
});
