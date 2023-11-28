<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\District;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Province;
use App\Models\User;
use App\Models\Wards;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class CartController extends Controller
{
    function index(Request $request){
        try {
            $token = $request->bearerToken();
            $user = self::checkToken($token);
            if ($user) { 
                Auth::login($user);
            }
            if(Auth::check()){
                $ret=Cart::where('UserId',Auth::user()->id)->get();
                $cart=self::getProduct($ret);
                return response()->json(['cart'=>$cart]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    function edit(Request $rq,int $id){
        $token = $rq->bearerToken();
        $user = self::checkToken($token);
        if ($user) { 
            Auth::login($user);
        }
        if(Auth::check()){
            $data=$rq->validate(['Amount'=>'required','Size'=>'required']);
            $response=DB::statement('CALL UpdateCartAmount(?,?,?,?)',[Auth::user()->id,$id,$data['Size'],$data['Amount']]);
            if($response)
                return response()->json(['success' => true]);
            else
                return response()->json();
        }else{
            return response()->json(['auth']);
        }
    }
    function add(Request $rq){
        $token = $rq->bearerToken();
        $user = self::checkToken($token);
        if ($user) { 
            Auth::login($user);
        }
        if(Auth::check()){
            $data=$rq->validate(['Amount'=>'required','Size'=>'required','ProductId'=>'required']);
            $response=DB::statement('CALL InsertIntoCart(?,?,?,?)',[Auth::user()->id,$data['ProductId'],$data['Size'],$data['Amount']]);
            if($response)
                return response()->json(['success' => true]);
            else
                return response()->json();
        }else{
            return response()->json(['auth']);
        }
    }
    function delete(Request $rq,int $id){
        $token = $rq->bearerToken();
        $user = self::checkToken($token);
        if ($user) { 
            Auth::login($user);
        }
        if(Auth::check()){
            $data=$rq->validate(['Size'=>'required']);
            $response=DB::statement('CALL DeleteFromCart(?,?,?)',[Auth::user()->id,$id,$data['Size']]);
            if($response)
                return response()->json(['success' => true]);
            else
                return response()->json();
        }else{
            return response()->json(['auth']);
        }
    }
    function checkout(Request $rq){
        $token = $rq->bearerToken();
        $user = self::checkToken($token);
        if ($user) { 
            Auth::login($user);
        }
        if(Auth::check()){
            $ret=Cart::where('UserId',Auth::user()->id)->get();
            $cart=self::getProduct($ret);
            $results = DB::select('CALL GetAllLocation');
            $lct = [];
            foreach ($results as $row) {
                if (!isset($lct[$row->province_id])) {
                    $lct[$row->province_id] = [
                        'name' => $row->province_name,
                        'districts' => []
                    ];
                }
                if (!isset($lct[$row->province_id]['districts'][$row->district_id])) {
                    $lct[$row->province_id]['districts'][$row->district_id] = [
                        'name' => $row->district_name,
                        'wards' => []
                    ];
                }
                $lct[$row->province_id]['districts'][$row->district_id]['wards'][] = [
                    'wards_id' => $row->wards_id,
                    'name' => $row->wards_name
                ];
            }
            return response()->json(['lct'=>$lct,'cart'=>$cart]);
        }else
            return response()->json(['auth']);
    }
}
