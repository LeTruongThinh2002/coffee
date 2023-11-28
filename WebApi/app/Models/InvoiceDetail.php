<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'InvoiceId',
        'ProductId',
        'Price',
        'Size',
        'Amount',
        'TotalPrice'
    ];
    protected $table='InvoiceDetail';
}
