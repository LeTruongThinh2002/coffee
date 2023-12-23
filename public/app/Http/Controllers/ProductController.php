<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class ProductController extends Controller
{
    function index(){
        return view('product.index');
    }
    function getProductInx(Request $rq){
        $page=$rq->get('page');
        $order=$rq->get('order','ASC');
        $response=Http::post('http://127.0.0.1:8000/api/product/getProductInx?page=' . $page.'&order='.$order);
        if(isset($response->json()['success'])){
            $product = $response->json()['product']['data'];
            $totalpage=$response->json()['totalPages'];
            $cat=$response->json()['cat'];
            $sz=$response->json()['sz'];
            if (count($product) > 0) {
                return response()->json(['success'=>true,'product' => $product,'page'=>$totalpage,'cat'=>$cat,'sz'=>$sz]);
            }
            else
                return response()->json(['success'=>false,'msg'=>'Không tìm thấy sản phẩm nào!']);
        }else
            return response()->json(['success'=>false,'msg'=>'Lỗi truy vấn']);
    }
    function searchBoxPro(Request $rq){
        $page=$rq->get('page');
        $data=$rq->validate(['q'=>'required','order'=>'required']);
        $response=Http::post('http://127.0.0.1:8000/api/product/searchBoxPro?page='.$page,$data)->json();
        if(isset($response['success'])){
            $product = $response['product']['data'];
            $totalpage=$response['totalPages'];
            if (count($product) > 0) {
                return response()->json(['success'=>true,'product' => $product,'page'=>$totalpage]);
            }
            else
                return response()->json(['success'=>false,'msg'=>'Không tìm thấy sản phẩm nào!']);
            }else
                return response()->json(['success'=>false,'msg'=>$response['error']]);
    }
    function details(int $id){
        $response = Http::post('http://127.0.0.1:8000/api/product/details/'.$id);
        $arr=$response->json()['arr'];
        $prr=$response->json()['prr'];
        $name=$response->json()['name'];
        foreach($name as $v){
            if($v['CategoryId'] == $arr['CategoryId'])
                $arr['CategoryName']=$v['CategoryName'];
        }
        foreach ($prr as $pValue) {
            if ($arr['ProductId'] == $pValue['ProductId']) {
            $arr['Sizes'][] = $pValue['Size'];
            $arr['Prices'][] = $pValue['Price'];
            }
        }
        $rrr=$response->json()['drr'];
        shuffle($rrr);
        $drr = array_slice($rrr, 0, 5);
        if($arr)
            return view('product.details',['arr'=>$arr,'drr'=>$drr]);
        else
            var_dump($response->json());
            //return redirect('/');
    }
    function edit(int $id){
        $response = Http::post('http://127.0.0.1:8000/api/product/edit/'.$id);
        if(isset($response->json()['pd'])){
        $pd=$response->json()['pd'];
        $price=$response->json()['price'];
        $cat=$response->json()['cat'];
        $sz=$response->json()['sz'];
        foreach ($price as $pValue) {
            if ($pd['ProductId'] == $pValue['ProductId']) {
            $pd['Sizes'][] = $pValue['Size'];
            $pd['Prices'][] = $pValue['Price'];
            }
        }
            return view('product.edit',['pd'=>$pd,'cat'=>$cat,'sz'=>$sz]);
        }
        var_dump($response->json());
    }
    function delete(int $id){
        $response=Http::post('http://127.0.0.1:8000/api/product/delete/'.$id);
        $arr=$response->json();
        if($arr){
            unlink(public_path('/images/product/').$arr);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    function searchBox(Request $rq){
        if($rq->method() == 'POST'){
            $data=$rq->validate(['q'=>'required']);
            $response=Http::post('http://127.0.0.1:8000/api/product/searchBox',$data);
            $arr=$response->json();
            if(isset($arr['dataSB'])){
                return response()->json(['success' => true,'dataSB'=>$arr['dataSB']]);
            }
            return response()->json(['success' => false]);
        }
    }
    function doEdit(Request $req,int $id ){
        if($req->isMethod('post')){
            $data=$req->validate(['ProductName'=>'required','CategoryId'=>'required','Description'=>'required','ImageUrl'=>'required','SizePriceArray'=>'required','UncheckedSizes'=>'required']);
            if($req->hasFile('ImageUrl')) {
                $name = Str::random(28).'.jpg';
                $data['ImageUrl'] = $name;
                $test=true;
            }else{
                $name = $req->validate(['ImageUrl'=>'required']);
                $imageName = basename($name['ImageUrl']);
                $data['ImageUrl'] = $imageName;
                $test=false;
            }
            $response = Http::post('http://127.0.0.1:8000/api/product/doEdit/'.$id,$data);
            if($response->json()){
                if($test){
                    $req->file('ImageUrl')->move(public_path('/images/product/'), $name);
                    unlink(public_path('/images/product/').$name);
                }
                return response()->json(['success'=>true]);
            }else
                return response()->json(['success'=>false,'er'=>$response->json()['er']]);
        
        }
        return redirect('/product');
    }
    function cadd(Request $req){
        if($req->isMethod('post')){
            $data=$req->validate(['ProductId'=>'required','ProductName'=>'required','CategoryId'=>'required','Description'=>'required','ImageUrl'=>'required','SizePriceArray'=>'required']);
            if($req->hasFile('ImageUrl')) {
                $name = Str::random(28).'.jpg';
                $data['ImageUrl'] = $name;
                $data['ProductId'] = random_int(1,100000);
                $response = Http::post('http://127.0.0.1:8000/api/product/cadd',$data);
                $arr=$response->json();
                if(isset($arr)){
                    if(isset($arr['success'])){
                            if($arr['success'])
                            {$req->file('ImageUrl')->move(public_path('/images/product/'), $name);
                                $data['CategoryName']=$arr['name'];
                            return response()->json(['success'=>true,'dt'=>$data]);
                        }else
                            return response()->json(['success'=>false,'fs'=>true]);
                    }else
                        var_dump($arr);
                }
                var_dump($response->json());
            }
        }
        return response()->json(['success'=>false]);
    }
}
