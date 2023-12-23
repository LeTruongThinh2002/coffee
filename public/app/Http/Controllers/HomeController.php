<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    function getProductIndex(Request $rq){
            $page=$rq->get('page');
            $response=Http::post('http://127.0.0.1:8000/api/home/getProductIndex?page=' . $page);
            if(isset($response->json()['success'])){
                $product = $response->json()['product']['data'];
                $totalpage=$response->json()['totalPages'];
                
                if (count($product) > 0) {
                    return response()->json(['success'=>true,'product' => $product,'page'=>$totalpage]);
                }
                else
                    return response()->json(['success'=>false,'msg'=>'Không tìm thấy sản phẩm nào!']);
            }else
                return response()->json(['success'=>false,'msg'=>'Lỗi truy vấn!']);
        
    }
    function getProductByClass(Request $rq){
        $page=$rq->get('page');
        $data=$rq->validate(['classId'=>'required']);
        $response=Http::post('http://127.0.0.1:8000/api/home/getProductByClass?page=' . $page,$data);
        if(isset($response->json()['success'])){
            $product = $response->json()['product']['data'];
            $totalpage=$response->json()['totalPages'];
            if (count($product) > 0) {
                return response()->json(['success'=>true,'product' => $product,'page'=>$totalpage]);
            }
            else
                return response()->json(['success'=>false,'msg'=>'Không tìm thấy sản phẩm nào!']);
        }else
            return response()->json(['success'=>false,'msg'=>'Lỗi truy vấn!']);
    
}
    function index(){
        $response = Http::get('http://127.0.0.1:8000/api/home');
        $arr=$response->json()['cat'];
        Session::put('category',$arr);
        $recommend=$response->json()['recommend'];
        if($response->successful()){
            return view('home.index',['recommend'=>$recommend,'arr'=>$arr]);
        }
        else
            return redirect('/');
    }
}
