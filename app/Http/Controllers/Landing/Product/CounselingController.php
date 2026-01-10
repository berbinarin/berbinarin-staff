<?php

namespace App\Http\Controllers\Landing\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CounselingController extends Controller
{
    public function index()
    {
        $konselings = [
            [
                'image' => 'assets/landing/images/product/psikolog1-new.webp',
                'nama' => 'Psikolog',
                'deskripsi' => 'Konseling bersama Psikolog berizin (SIPP) yang berpengalaman menangani keluhan staff.
                Dilaksanakan secara profesional dan rahasia untuk mendukung kesehatan mental serta performa staff.',
            ],
            [
                'image' => 'assets/landing/images/product/psikolog3-new.webp',
                'nama' => 'Peer Counselor',
                'deskripsi' => 'Sesi bersama Peer Counselor terlatih oleh Psikolog Berbinar, siap menjadi pendengar empatik bagi staff dalam menghadapi tantangan kerja dan menjaga kesejahteraan emosional.',
            ],
        ];

        return view('landing.product.counseling.index')->with([
            'konselings' => $konselings
        ]);
    }
}
