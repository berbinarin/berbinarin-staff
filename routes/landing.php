<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Landing\Product\CounselingController;
use App\Http\Controllers\Landing\Product\PsikologController;
use App\Http\Controllers\Landing\Product\PeerController;
use App\Http\Controllers\Landing\Reimbursement\ReimbursementController;



// Route::get('/', [CounselingController::class, 'index'])->name('home.index');
Route::get('/', [LandingController::class, 'index'])->name('home.index');

Route::prefix('konseling')->name('counseling.')->group(function () {
    Route::get('/', [CounselingController::class, 'index'])->name('index');

    Route::get('/peer-counselor', [PeerController::class, 'registrationPeer'])->name('registrationPeer');
    Route::post('/peer-counselor/store', [PeerController::class, 'storePeerStaffRegistration'])->name('storePeerStaffRegistration');

    Route::get('/psikolog', [PsikologController::class, 'registrationPsikolog'])->name('registrationPsikolog');
    Route::post('/psikolog/store', [PsikologController::class, 'storePsikologStaffRegistration'])->name('storePsikologStaffRegistration');
});

Route::prefix('reimbursement')->name('reimbursement.')->group(function () {
    Route::get('/', [ReimbursementController::class, 'index'])->name('index');
    Route::post('/store', [ReimbursementController::class, 'store'])->name('store');
});
