<?php

namespace App\Models\SecretaryFinance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoices';

    protected $casts = [
        'products' => 'array',
        'invoice_date' => 'date',
    ];

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'customer_name',
        'customer_agency',
        'products', // No, Keterangan, Jumlah, Harga Satuan, Diskon, Subtotal
        'subtotal_amount',
        'total_discount',
        'total_amount',
    ];
}
