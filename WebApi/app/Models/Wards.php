<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    use HasFactory;
    protected $fillable = [
        'wards_id',
        'district_id',
        'name'
    ];
    protected $table='Wards';
}
