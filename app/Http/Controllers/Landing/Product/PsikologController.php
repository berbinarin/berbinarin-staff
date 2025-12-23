<?php

namespace App\Http\Controllers\Landing\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PsikologController extends Controller
{
    public function registrationPsikolog()
    {
        return view('landing.product.psikolog.registration-psikolog');
    }
}
