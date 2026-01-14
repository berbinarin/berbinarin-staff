<?php

namespace App\Services;

use App\Models\SecretaryFinance\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceNumberService
{
    public function createInvoiceNumber(Carbon $date): string
    {
        $year = $date->year;
        $monthRoman = $this->toRomanMonth($date->month);

        return DB::transaction(function () use ($year, $monthRoman) {
            $last = Invoice::whereYear('invoice_date', $year)
                ->orderBy('invoice_date', 'desc')
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->value('invoice_number');

            $nextSeq = 1;

            if ($last) {
                $parts = explode('/', $last);
                if (isset($parts[0]) && ctype_digit($parts[0])) {
                    $nextSeq = ((int) $parts[0]) + 1;
                }
            }

            $seq = str_pad((string) $nextSeq, 3, '0', STR_PAD_LEFT);

            return "{$seq}/INV/BERBINAR/{$monthRoman}/{$year}";
        });
    }

    private function toRomanMonth(int $month): string
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];
        return $map[$month] ?? 'I';
    }
}
