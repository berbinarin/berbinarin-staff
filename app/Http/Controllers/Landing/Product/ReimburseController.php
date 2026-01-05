<?php

namespace App\Http\Controllers\Landing\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReimburseController extends Controller
{
    public function reimburseAjukan()
    {
        return view('landing.product.reimburse.reimburse-req');
    }
}
