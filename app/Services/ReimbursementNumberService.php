<?php

namespace App\Services;

use App\Models\SecretaryFinance\Reimbursement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReimbursementNumberService
{
    public function createReimbursementNumber(Carbon $date): string
    {
        $year = $date->year;

        return DB::transaction(function () use ($year) {
            $last = Reimbursement::whereYear('approved_at', $year)
                ->whereNotNull('reimbursement_number')
                ->orderBy('approved_at', 'desc')
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->value('reimbursement_number');
            $nextSeq = 1;

            if ($last) {
                if (preg_match('/^FR-(\d{3})$/', $last, $matches)) {
                    $nextSeq = ((int) $matches[1]) + 1;
                }
            }

            $seq = str_pad((string) $nextSeq, 3, '0', STR_PAD_LEFT);

            return "FR-{$seq}";
        });
    }
}
