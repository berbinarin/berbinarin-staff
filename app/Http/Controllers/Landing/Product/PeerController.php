<?php

namespace App\Http\Controllers\Landing\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeerController extends Controller
{
    public function registrationPeer()
    {
        return view('landing.product.peer.registration-peer');
    }
}
