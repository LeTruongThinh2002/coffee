<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Role extends Model
{
    public $timestamps=true;
    use HasFactory;
    
    protected $fillable=[
        'RoleId',
        'RoleName',
        'created_at',
        'updated_at'
    ];
    
    protected $table='Role';
    static function remove(int $id){
        return self::where('RoleId',$id)->delete($id);
    }
    static function edit(int $id, $arr){
        return self::where('RoleId',$id)->update($arr);
    }
}
