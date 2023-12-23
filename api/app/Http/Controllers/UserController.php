<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
class UserController extends Controller
{
    function index(){
        return response()->json(['arr'=>User::all(),'crr'=>Role::all()]);
    }
    
    function getAllUser(Request $rq){
        $perPage = 4;
        $orderBy = $rq->get('orderBy');  // Lấy giá trị 'ASC' hoặc 'DESC'
        $user = User::orderBy('name', $orderBy)->paginate($perPage);
        $totalPages = $user->lastPage();
        $role=Role::all();
        foreach ($user as $key => $value) {
            foreach ($role as $pValue) {
                if ($value['role'] == $pValue['RoleId']) {
                    $user[$key]['roleName'] = $pValue['RoleName'];
                }
            }
        }
        return response()->json(['success'=>true,'user'=>$user, 'totalPages' => $totalPages,'crr'=>$role]);
    }

    function searchBoxUs(Request $rq){
        try{
            $data=$rq->validate(['q'=>'required']);
            $page=$rq->get('page', 1); // Mặc định là trang 1 nếu không có tham số 'page'
            $orderBy = $rq->get('orderBy', 'ASC'); 
            $perPage = 4;
            $ret=DB::select('CALL SearchUsers(?,?)',[$data['q'],$orderBy]);
            $role=Role::all();
            if($ret){
                $ret = collect($ret);
                $paginator = new LengthAwarePaginator($ret->forPage($page, $perPage), $ret->count(), $perPage, $page, ['path' => url()->current()]);
                $totalPages = $paginator->lastPage();
                foreach ($paginator as $key => $value) {
                        foreach ($role as $pValue) {
                            if ($value->role == $pValue->RoleId) {
                                $paginator[$key]->roleName = $pValue->RoleName;
                            }
                        }
                }
                return response()->json(['success'=>true,'user'=>$paginator, 'totalPages' => $totalPages,'crr'=>$role]);
            }
            return response()->json(['success'=>false]);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
    

    function delete(string $id){
        $user = User::find($id);
        if($user){
            $user->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    function edit(Request $rq, string $id){
        try {
            if($rq->isMethod('post')){
                $data = $rq->validate(['RoleId'=>'required']);
                $user = DB::statement('CALL UpdateRoleUser(?,?)',[$id,$data['RoleId']]);
                if($user){
                    return response()->json(['success' => true]);
                }
                return response()->json(['success' => false]);
            }
            return response()->json(['success' => false]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg'=>$e->getMessage()]);
        }
    }
       
}
