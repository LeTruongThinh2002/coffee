<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    function index(){
        $token = self::auths();
        if($token){
            $response=Http::withToken($token)->post('http://127.0.0.1:8000/api/cart')->json();
            if(isset($response['auth'])){
                Session::forget('token');
                return redirect('/auth/login');
            }
            else
            {
                if(isset($response['cart'])){
                    $cart=$response['cart'];
                    if(count($cart) > 0){
                        return view('cart.index',['arr'=>$cart]);
                    }else{
                        return view('cart.index',['msg'=>'Không có sản phẩm nào trong giỏ hàng!']);
                    }
                }else{
                    return redirect('/auth/login');
                }
            }
        }else
            return redirect('/auth/login');
    }
    function edit(Request $rq,int $id){
        $token = self::auths();
        if($token){
            $data=$rq->validate(['Amount'=>'required','Size'=>'required']);
            $response=Http::withToken($token)->post('http://127.0.0.1:8000/api/cart/edit/'.$id,$data)->json();
            if(isset($response['auth'])){
                Session::forget('token');
                return redirect('/auth/login');
            }
            else
            {
                if(isset($response['success']))
                    return response()->json(['success'=>true]);
                else
                    return response()->json(['success'=>false,$response]);
            }
        }else
            return response()->json(['success'=>false]);
    }
    function add(Request $rq){
        $token = self::auths();
        if($token){
            $data=$rq->validate(['Amount'=>'required','Size'=>'required','ProductId'=>'required']);
            $response=Http::withToken($token)->post('http://127.0.0.1:8000/api/cart/add',$data)->json();
            if(isset($response['auth'])){
                Session::forget('token');
                return redirect('/auth/login');
            }
            else
            {
                if(isset($response['success']))
                    return response()->json(['success'=>true]);
                else
                    return response()->json(['success'=>false]);
            }
        }else
            return response()->json(['success'=>false]);
    }
    function delete(Request $rq,int $id){
        $token = self::auths();
        if($token){
            $data=$rq->validate(['Size'=>'required']);
            $response=Http::withToken($token)->post('http://127.0.0.1:8000/api/cart/delete/'.$id,$data)->json();
            if(isset($response['auth'])){
                Session::forget('token');
                return redirect('/auth/login');
            }
            else
            {
                if(isset($response['success']))
                    return response()->json(['success'=>true]);
                else
                    return response()->json(['success'=>false]);
            }
        }else
            return response()->json(['success'=>false]);
    }
    function checkout(){
        $token = self::auths();
        if($token){
            $response=Http::withToken($token)->get('http://127.0.0.1:8000/api/cart/checkout')->json();
            if(isset($response['auth'])){
                Session::forget('token');
                return redirect('/auth/login');
            }
            else
            {
                if(isset($response['cart'])){
                    $cart=$response['cart'];
                    $lct=$response['lct'];
                    if(count($cart) > 0){
                        return view('cart.checkout',['cart'=>$cart,'lct'=>$lct]);
                    }else
                        return redirect('/cart');
                }else
                return redirect('/auth/login');
            }
        }else
            return redirect('/auth/login');
    }
}
