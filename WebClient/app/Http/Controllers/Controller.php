<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public static function auths(){
        $token = null;
        if(Session::has('token')===true) {
            $token = Session::get('token');
        } elseif(isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
        }
        return $token;
    }
}
