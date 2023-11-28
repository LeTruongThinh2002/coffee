<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public static function checkToken($token){
        $user = User::all()->firstWhere(function ($user) use ($token) {
            return hash('sha256', $user->remember_token) == $token;
        });
        return $user;
    }
    public static function getProduct($cart){
        foreach($cart as $k => $in){
            $lo = DB::select('CALL GetIProduct(?,?)', [$in['ProductId'],$in['Size']]);
            foreach ($lo as $row) {
                $cart[$k]['ProductName']=$row->pdName;
                $cart[$k]['ImageUrl']=$row->ImgUrl;
                $cart[$k]['Price']=$row->pdPrice;
            }
        }
        return $cart;
    }
}
