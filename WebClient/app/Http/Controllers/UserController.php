<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    function index(){
        return view('user.index');
    }
    function getAllUser(Request $rq){
        $page=$rq->get('page');
        $data['orderBy']=$rq->get('orderBy');
        $response=Http::post('http://127.0.0.1:8000/api/user/getAllUser?page=' . $page,$data);
        if(isset($response->json()['success'])){
            $user = $response->json()['user']['data'];
            array_walk($user, function(&$item, $key) {
                $item['id'] = strval($item['id']);
            });

            $totalpage=$response->json()['totalPages'];
            $crr=$response->json()['crr'];
            if (count($user) > 0) {
                return response()->json(['success'=>true,'user' => $user,'page'=>$totalpage,'crr'=>$crr]);
            }
            else
                return response()->json(['success'=>false,'msg'=>'Không tìm thấy user nào!']);
        }else
            return response()->json(['success'=>false,'msg'=>'Lỗi truy vấn!']);
    }
    function searchBoxUs(Request $rq){
        if($rq->method() == 'POST'){
            $page=$rq->get('page');
            $order=$rq->get('orderBy');
            $data=$rq->validate(['q'=>'required']);
            $response=Http::post('http://127.0.0.1:8000/api/user/searchBoxUs?page='.$page.'&orderBy='.$order,$data);
            if($response->json()['success']){
                $user = $response->json()['user']['data'];
                array_walk($user, function(&$item, $key) {
                    $item['id'] = strval($item['id']);
                });

                $totalpage=$response->json()['totalPages'];
                $crr=$response->json()['crr'];
                if (count($user) > 0) {
                    return response()->json(['success'=>true,'user' => $user,'page'=>$totalpage,'crr'=>$crr]);
                }
                else
                    return response()->json(['success'=>false,'msg'=>'Không tìm thấy user nào!']);
            }else
                return response()->json(['success'=>false,'msg'=>$response->json()['msg']]);
        }
    }
    function delete(int $id){
        $response = Http::post('http://127.0.0.1:8000/api/user/delete/'.$id);
        if($response->json()['success'])
            return response()->json(['success' => true]);
        else
            return response()->json(['success' => false]);
    }
    function edit(Request $rq, int $id){
        if($rq->isMethod('post')){
            $data = $rq->validate(['RoleId'=>'required']);
            $idlog = $rq->validate(['idlog'=>'required']);
            if($id!=$idlog){
                $response = Http::post('http://127.0.0.1:8000/api/user/edit/'.$id,$data);
                if($response->json()['success']){
                    return response()->json(['success' => true]);
                }else{
                    if(isset($response->json()['msg']))
                        return response()->json(['success' => false,'msg'=>$response->json()['msg']]);
                    else
                        return response()->json(['success' => false]);
                }
            }else
            return response()->json(['success' => false]);
        }else
        return response()->json(['success' => false]);
    }    
}
