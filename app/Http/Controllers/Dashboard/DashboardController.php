<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $totalReimburseDiajukan = 70;
        $menungguVerifikasi = 40;
        $disetujui = 20;
        $ditolak = 10;
        return view('dashboard.index', compact('totalReimburseDiajukan', 'menungguVerifikasi', 'disetujui', 'ditolak'));
    }
}
