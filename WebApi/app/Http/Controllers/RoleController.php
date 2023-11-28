<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
class RoleController extends Controller
{
    function getAllRole(Request $rq){
        $page=$rq->get('page', 1); // Mặc định là trang 1 nếu không có tham số 'page'
        $perPage = 4;
        $data=$rq->validate(['orderBy'=>'required']);
        $ret=DB::select('CALL SearchRole(?)',[$data['orderBy']]);
        if($ret){
            $ret = collect($ret);
            $paginator = new LengthAwarePaginator($ret->forPage($page, $perPage), $ret->count(), $perPage, $page, ['path' => url()->current()]);
            $totalPages = $paginator->lastPage();
            return response()->json(['arr'=>$paginator, 'totalPages' => $totalPages]);
        }
        else
            return response()->json();
    }
    function add(Request $req){
        $kt = Role::where('RoleName', $req)->exists();
        if($kt){
            $msg=true;
            return response()->json(['success' => false,'msg'=>$msg]);}
        else{
            if($req->isMethod('post')){
                $data=$req->validate(['RoleName'=>'required|unique:Role']);
                $newRole = Role::create($data);
                if($newRole){
                    return response()->json(['success' => true, 'RoleId' => $newRole->id, 'RoleName'=>$data['RoleName']]);
                }
                return response()->json(['success' => false]);
            }
            return response()->json(['success' => false]);
        }
        }
    
    function delete(int $id){
        $kt = User::where('role', $id)->exists();
        $msg=false;
        if($kt){
            $msg=true;
            return response()->json(['success' => false,'msg'=>$msg]);
        }else{
            $ret=Role::remove($id);
            if($ret){
                return response()->json(['success' => true,'msg'=>$msg]);
            }
            return response()->json(['success' => false,'msg'=>$msg]);
        }
    }
    function edit(Request $rq,int $id ){
        $kt = User::where('role', $id)->exists();
        $msg=false;
        if($kt){
            $msg=true;
            return response()->json(['success' => false,'msg'=>$msg]);
        }else{
                $data=$rq->validate(['RoleName'=>'required|unique:Role']);
                if(Role::edit($id,$data)){
                    return response()->json(['success' => true, 'RoleName' => $data['RoleName'],'msg'=>$msg]);
                }
                return response()->json(['success' => false,'msg'=>$msg]);
        }
    }
}
