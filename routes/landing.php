<?php

use App\Http\Controllers\Landing\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('home.index');
