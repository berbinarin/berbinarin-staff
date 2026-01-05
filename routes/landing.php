<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Landing\Product\CounselingController;
use App\Http\Controllers\Landing\Product\PsikologController;
use App\Http\Controllers\Landing\Product\PeerController;
use App\Http\Controllers\Landing\Product\ReimburseController;



// Route::get('/', [CounselingController::class, 'index'])->name('home.index');
Route::get('/', [LandingController::class, 'index'])->name('home.index');
Route::get('/prodrag', [CounselingController::class, 'index'])->name('product.index');

Route::prefix('produk')->name('product.')->group(function () {
    
    Route::get('/peer-counselor', [PeerController::class, 'registrationPeer'])->name('registrationPeer');
    
    Route::get('/psikolog', [PsikologController::class, 'registrationPsikolog'])->name('registrationPsikolog');

    Route::get('/reimburse', [ReimburseController::class, 'reimburseAjukan'])->name('reimburseAjukan');

});