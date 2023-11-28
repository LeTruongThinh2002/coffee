<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    function index(){
        $response = Http::post('http://127.0.0.1:8000/api/category');
        $arr=$response->json()['arr'];
        if($response->successful())
            return view('category.index',['arr'=>$arr]);
        else
            return redirect('/');
    }
    function add(Request $req){
            if($req->isMethod('post')){
                $data=$req->validate(['CategoryName'=>'required','Description'=>'required','ImageUrl'=>'required']);
                if($req->hasFile('ImageUrl')) {
                    $name = Str::random(28).'.jpg';
                }
                $data['ImageUrl']=$name;
                $response=Http::post('http://127.0.0.1:8000/api/category/add',$data);
                if(isset($response->json()['msg'])){
                    $msg=' đã tồn tại';
                    return response()->json(['success' => false,'msg'=>$msg]);
                }else{
                    $arr=$response->json();
                    if($arr){
                        $req->file('ImageUrl')->move(public_path('/images/product/'), $name);
                        return response()->json(['success' => true, 'CategoryId' => $arr['CategoryId'], 'CategoryName'=>$data['CategoryName'],'Description'=>$data['Description'],'ImageUrl'=>$data['ImageUrl']]);
                    }
                    return response()->json(['success' => false]);
                }   
            }
        return response()->json(['success' => false]);
    }
    
    function cdelete(int $id){
        $response=Http::post('http://127.0.0.1:8000/api/category/cdelete/'.$id);
        $arr=$response->json();
        if($arr){
            unlink(public_path('/images/product/').$arr);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    function edit(Request $req,int $id ){
        if($req->isMethod('post')){
            $data=$req->validate(['CategoryName'=>'required','Description'=>'required','ImageUrl'=>'required']);
            if($req->hasFile('ImageUrl')) {
                
                $name = Str::random(28).'.jpg';
            }
            $data['ImageUrl']=$name;
            $response=Http::post('http://127.0.0.1:8000/api/category/edit/'.$id,$data);
            $arr=$response->json();
            if(isset($arr)){
                if($arr['test']){
                    return response()->json(['success' => true, 'CategoryName'=>$data['CategoryName'],'Description'=>$data['Description'],'ImageUrl'=>$name]);
                }
                else{
                    $req->file('ImageUrl')->move(public_path('/images/product/'), $name);
                    $text=$arr['img'];
                    unlink(public_path('/images/product/').$text);
                    return response()->json(['success' => true, 'CategoryName'=>$data['CategoryName'],'Description'=>$data['Description'],'ImageUrl'=>$data['ImageUrl']]);
                }
            }
            return response()->json(['success' => false]);  
        }   
        return response()->json(['success' => false]);
    }
}