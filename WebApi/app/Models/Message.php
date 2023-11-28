<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable=[
        'id',
        'member_id',
        'content',
        'created_at',
        'updated_at'
    ];
    
    protected $table='Message';
}
