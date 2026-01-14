<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManagerCPM\PeerStaff;
use App\Models\ManagerCPM\PsikologStaff;
use App\Models\SecretaryFinance\Invoice;
use App\Models\SecretaryFinance\Reimbursement;

class DashboardController extends Controller
{
    public function index() {
        $totalReimbursement = Reimbursement::count();
        $pendingReimbursement = Reimbursement::where('status', 'pending')->count();
        $approvedReimbursement = Reimbursement::where('status', 'approved')->count();
        $rejectedReimbursement = Reimbursement::where('status', 'rejected')->count();

        $peerStaffCount = PeerStaff::count();
        $psikologStaffCount = PsikologStaff::count();
        $totalCounselingRegistrants = $peerStaffCount + $psikologStaffCount;
        return view('dashboard.index', compact('totalReimbursement', 'pendingReimbursement', 'approvedReimbursement', 'rejectedReimbursement', 'peerStaffCount', 'psikologStaffCount', 'totalCounselingRegistrants'));
    }
}
