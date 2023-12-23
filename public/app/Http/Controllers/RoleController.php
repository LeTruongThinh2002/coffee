<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RoleController extends Controller
{
    function index(){
        return view('role.index');
    }
    function getAllRole(Request $rq){
        $page=$rq->get('page');
        $data=$rq->validate(['orderBy'=>'required']);
        $response = Http::post('http://127.0.0.1:8000/api/role/getAllRole?page=' . $page,$data);
        if(isset($response->json()['arr']))
        {
            $totalpage=$response->json()['totalPages'];
            $arr=$response->json()['arr']['data'];
            if (count($arr) > 0)
                return response()->json(['success'=>true,'arr' => $arr,'page'=>$totalpage]);
            else
                return response()->json(['success'=>false,'msg'=>'Không tìm thấy role nào!']);
        }
        else
            return response()->json(['success'=>false,'msg'=>'Lỗi truy vấn role']);
    }
    function add(Request $req){
            if($req->isMethod('post')){
                $data=$req->validate(['RoleName'=>'required|unique:Role']);
                $response=Http::post('http://127.0.0.1:8000/api/role/add',$data);
                if(isset($response->json()['msg'])){
                    $msg=' đã tồn tại';
                    return response()->json(['success' => false,'msg'=>$msg]);
                }else{
                if($response->successful()){
                    // Trả về dữ liệu JSON chứa thông tin về vai trò mới
                    return response()->json(['success' => true, 'RoleId' => $response->json()['RoleId'], 'RoleName'=>$response->json()['RoleName']]);
                }
                return response()->json(['false' => false]);
            }   
        }
        return response()->json(['false' => false]);
    }
    
    function delete(int $id){
        $response=Http::post('http://127.0.0.1:8000/api/role/delete/'.$id);
        if($response->json()['msg']){
            $msg=' đã sử dụng';
            return response()->json(['success' => false,'msg'=>$msg]);
        }else{
            if($response->successful()){
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false]);
        }
    }
    function edit(Request $rq,int $id ){
        $data=$rq->validate(['RoleName'=>'required|unique:Role']);
        $response=Http::post('http://127.0.0.1:8000/api/role/edit/'.$id,$data);
        if($response->successful()){
            if($response->json()['msg']){
                $msg=' đã sử dụng';
                return response()->json(['success' => false,'msg'=>$msg]);
            }else{
                return response()->json(['success' => true, 'RoleName' => $data['RoleName']]);
                }
        }else
            return response()->json(['success' => false]);
        }    
}
