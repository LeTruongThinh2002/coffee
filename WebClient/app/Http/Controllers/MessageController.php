<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{
    function getMessageUser(){
        $token = self::auths();
        if($token){
            $response=Http::withToken($token)->post('http://127.0.0.1:8000/api/message/getMessageUser')->json();
            if(isset($response['auth'])){
                Session::forget('token');
                return redirect('/auth/login');
            }
            else
            {
                if(isset($response['msgs'])){
                    $msgs = $response['msgs'];
                    if (count($msgs) > 0)
                        return response()->json(['success'=>true,'msg' => $msgs]);
                    else
                        return response()->json(['success'=>false,'msg' => 'Không có thông báo nào!']);
                }else
                    return response()->json(['success'=>false,'msg' => 'Không tải được thông báo!']);
            }    
        }else
            return response()->json(['success'=>false,'msg' => 'Lỗi đăng nhập!']);
    }
    function activeMessage(){
        $token = self::auths();
        if($token){
            $response=Http::withToken($token)->post('http://127.0.0.1:8000/api/message/activeMessage')->json();
            if(isset($response['auth'])){
                Session::forget('token');
                return redirect('/auth/login');
            }
            else
            {
                if(isset($response['success'])){
                    if ($response['success'])
                        return response()->json(['success'=>true]);
                    else
                        return response()->json(['success'=>false]);
                }else
                    return response()->json(['success'=>false]);
            }    
        }else
            return response()->json(['success'=>false]);
    }
}
