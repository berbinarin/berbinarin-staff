<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManagerCPM\PeerStaff;
use App\Models\ManagerCPM\PsikologStaff;
use App\Models\SecretaryFinance\Invoice;
use App\Models\SecretaryFinance\Reimbursement;
use Carbon\Carbon;

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

        $latestInvoices = Invoice::select('id', 'invoice_number', 'invoice_date', 'created_at')
            ->orderBy('invoice_date', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($invoice) {
                return [
                    'type' => 'Invoice',
                    'date' => $invoice->invoice_date ?? $invoice->created_at,
                    'number' => $invoice->invoice_number ?? '-',
                ];
            });

        $latestReimbursements = Reimbursement::select('id', 'reimbursement_number', 'reimbursement_date', 'created_at')
            ->orderBy('reimbursement_date', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($reimbursement) {
                $date = $reimbursement->reimbursement_date
                    ? Carbon::parse($reimbursement->reimbursement_date)
                    : $reimbursement->created_at;

                return [
                    'type' => 'Reimburse',
                    'date' => $date,
                    'number' => $reimbursement->reimbursement_number ?? '-',
                ];
            });

        $latestTransactions = $latestInvoices
            ->merge($latestReimbursements)
            ->sortByDesc('date')
            ->take(10)
            ->values();

        return view('dashboard.index', compact(
            'totalReimbursement',
            'pendingReimbursement',
            'approvedReimbursement',
            'rejectedReimbursement',
            'peerStaffCount',
            'psikologStaffCount',
            'totalCounselingRegistrants',
            'latestTransactions'
        ));
    }
}
