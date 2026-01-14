<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ManagerCPM\PsikologStaffController;
use App\Http\Controllers\Dashboard\ManagerCPM\PeerStaffController;
use App\Http\Controllers\Dashboard\SecretaryFinance\InvoiceController;
use App\Http\Controllers\Dashboard\SecretaryFinance\ReimbursementController;

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::middleware('role:manager-cpm')->group(function () {
        // Psychologis Staff
        Route::resource('/psikolog-staff', PsikologStaffController::class);

        // Peer Counselor Staff
        Route::resource('/peer-staff', PeerStaffController::class);
    });

    Route::middleware('role:secfin')->group(function () {
        // Invoice
        Route::resource('/invoice', InvoiceController::class);
        Route::get('/invoice/{invoice}/export', [InvoiceController::class, 'exportDocx'])
            ->name('invoice.export');

        // Reimbursement
        Route::resource('/reimbursement', ReimbursementController::class);
        Route::post('/reimbursement/{reimbursement}/approve', [ReimbursementController::class, 'approve'])
            ->name('reimbursement.approve');
        Route::post('/reimbursement/{reimbursement}/reject', [ReimbursementController::class, 'reject'])
            ->name('reimbursement.reject');
        Route::get('/reimbursement/{reimbursement}/proof/{index}', [ReimbursementController::class, 'downloadProof'])
            ->whereNumber('index')
            ->name('reimbursement.proof.download');
        Route::get('/reimbursement/{reimbursement}/signature', [ReimbursementController::class, 'downloadSignature'])
            ->name('reimbursement.signature.download');
        Route::get('/reimbursement/{reimbursement}/export', [ReimbursementController::class, 'exportDocx'])
            ->name('reimbursement.export');
    });
});
