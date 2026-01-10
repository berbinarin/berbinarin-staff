<?php

namespace App\Models\SecretaryFinance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reimbursement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reimbursements';

    protected $casts = [
        'items' => 'array',
        'proof_path' => 'array',
    ];

    protected $fillable = [
        'reimbursement_number',
        'reimbursement_date',
        'employee_name',
        'employee_division',
        'employee_position',
        'items', // No, Keterangan, Tanggal, Nominal
        'total_amount',
        'employee_account_number',
        'employee_account_name',
        'employee_bank_name',
        'employee_signature_path',
        'employee_phone_number',
        'proof_path',
        'status',
        'notes',
        'approved_by',
        'approved_at',
    ];
}
