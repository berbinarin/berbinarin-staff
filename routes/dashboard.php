<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ManagerCPM\PsikologStaffController;
use App\Http\Controllers\Dashboard\ManagerCPM\PeerStaffController;

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::middleware('role:manager-cpm')->group(function () {
        // Psychologis Staff
        Route::resource('/psikolog-staff', PsikologStaffController::class);

        // Peer Counselor Staff
        Route::resource('/peer-staff', PeerStaffController::class);
    });
});
