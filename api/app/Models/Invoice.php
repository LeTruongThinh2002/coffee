<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'InvoiceId',
        'UserId',
        'WardId',
        'Phone',
        'Address',
        'created_at'
    ];
    protected $table='Invoice';
}
