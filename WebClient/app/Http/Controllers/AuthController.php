<?php

namespace App\Http\Controllers;

use App\Events\GetMgsRealTime;
use App\Mail\ForgotPw;
use App\Models\Role;
use App\Models\User;
use App\Mail\Verify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function index(){
        $token = self::auths();
        if($token) {
            $response=Http::withToken($token)->get('http://127.0.0.1:8000/api/auth')->json();
            if(isset($response['user'])){
                $user=$response['user'];
                $img=$response['img'];
                foreach($img as $v){
                    if($user['id']==$v['UserId'])
                        $user['img']=$v['ImageUrl'];
                }
                if(!isset($user['img']))
                    $user['img']='none.jpg';
                $role=$response['arr'];
                foreach($role as $v)
                {
                    if($v['RoleId']==$user['role'])
                        $user['role']=$v['RoleName'];
                }
                if($user){
                    return view('auth.index',['u'=>$user]);
                }
            }else{
                Session::forget('token');
                setcookie('remember_token', '', time() - 3600, '/');
            }
        }
        return redirect('/auth/login');
    }
    
    function logout(){
        $token = self::auths();
        if($token){
            $response = Http::withToken($token)->post('http://127.0.0.1:8000/api/auth/logout');
            
            if(isset($response->json()['status']))
            {
                setcookie('remember_token', '', time() - 3600, '/');
                if(Session::has('token'))
                    Session::forget('token');
            }
        }
        return redirect('/auth/login');
    }
    function register(Request $req){
        if($req->isMethod('post')){
            $data=$req->validate(['name'=>'required','email'=>'required|email|unique:User','password'=>'required']);
            $response = Http::post('http://127.0.0.1:8000/api/auth/register',$data);
            $token=$response->json();
            if(isset($token['success'])){
                return response()->json(['success'=>true]);
            }
            else
                return response()->json(['success'=>false]); 
        }
        return view('auth.register');
    }
    function verify(Request $rq){
        $response = Http::post('http://127.0.0.1:8000/api/auth/verify',$rq);
        if(isset($response->json()['msg'])){
            return view('auth.verify',['msg'=>$response->json()['msg']]);
        }else
            return view('auth.verify');
    }
    function forgotpassword(Request $req){
        if($req->isMethod('post')){
            $data=$req->validate(['email'=>'required']);
            $response = Http::post('http://127.0.0.1:8000/api/auth/forgotpassword',$data);
            $token=$response->json();
            if(isset($token['token'])){
                Mail::to($data['email'])->send(new ForgotPw(['token'=>$token['token'],'title'=>'Reset password from your Account in CoffeeShop!']));
                return response()->json(['success'=>true]);
            }
            else
                return response()->json(['success'=>false,'token'=>$token]); 
        }
        return view('auth.forgotpassword');
    }
    function resetpassword(Request $rq){
        $token = $rq->get('token');
        if($token)
            return view('auth.resetpassword')->with('token', $token);
        else
            return view('auth.login');
    }    
function doResetpassword(Request $req){
        if($req->isMethod('post')){
            $data=$req->validate(['password'=>'required']);
            $token=$req->validate(['token'=>'required']);
            $response = Http::withToken($token['token'])->post('http://127.0.0.1:8000/api/auth/resetpw',$data);
            $ret=$response->json();
            if(isset($ret['success'])){
                return response()->json(['success'=>true]);
            }
            else
                return response()->json(['success'=>false,'error'=>$ret['error']]); 
        }
    }
    function changepassword(Request $req){
        if($req->isMethod('post')){
            $token = self::auths();
            $data=$req->validate(['password'=>'required','newpassword'=>'required']);
            $response = Http::withToken($token)->post('http://127.0.0.1:8000/api/auth/changepassword',$data);
            $ret=$response->json();
            if(isset($ret['success'])){
                return response()->json(['success'=>true]);
            }
            else
                return response()->json(['success'=>false,'msg'=>$ret['error']]);
        }
        return view('auth.changepassword');
    }
    function changeMail(Request $req){
        if($req->isMethod('post')){
            $token = self::auths();
            $data=$req->validate(['password'=>'required','newEmail'=>'required']);
            $response = Http::withToken($token)->post('http://127.0.0.1:8000/api/auth/changeMail',$data);
            $ret=$response->json();
            if(isset($ret['success'])){
                return response()->json(['success'=>true]);
            }
            else
                return response()->json(['success'=>false,'msg'=>$ret['error']]);
        }
        return view('auth.changeMail');
    }
    function login(Request $req)
    {
        if ($req->isMethod('post')) {
            $data = $req->validate(['email' => 'required|email', 'password' => 'required']);

            $response = Http::post('http://127.0.0.1:8000/api/auth/login', $data);
            $ret = $response->json();

            if (isset($ret['success']) && $ret['token']) {
                if(isset($ret['active']))
                    Mail::to($data['email'])->send(new Verify(['token'=>$ret['token'],'title'=>'Active from your Account in CoffeeShop!']));
                $isrem=$req->input('rem');
                if ($isrem=='true') {
                    // Lưu token vào cookie
                    setcookie('remember_token', $ret['token'], time() + 60 * 60 * 24 * 30, '/');
                    Session::forget('token'); // Xóa token khỏi session
                    return response()->json(['success' => true]);
                
                    
                } else {
                    // Lưu token vào session
                    Session::put('token', $ret['token']);
                    setcookie('remember_token', '', time() -3600, '/');// Xóa cookie remember_token
                    return response()->json(['success' => true]);
                }
                //return response()->json(['success' => true, 'msg' => Session::get('token')]);
            } else {
                return response()->json(['success' => false,'msg'=>$ret['error']]);
            }
        }else{
            setcookie('remember_token', '', time() -3600, '/');
            if(Session::has('token'))
                Session::forget('token');
            return view('auth.login');
        }
    }
    function uploadImage(Request $rq,int $id){
        $data=$rq->validate(['ImageUrl'=>'required']);
        if($rq->hasFile('ImageUrl')) {
            $image = $rq->file('ImageUrl');
            $extension = $image->getClientOriginalExtension();
            $data['ImageUrl'] = $extension;
            $oldname=$rq->validate(['old'=>'required']);
            $old=basename($oldname['old']);
            $token = self::auths();
            $response = Http::withToken($token)->post('http://127.0.0.1:8000/api/auth/uploadImage/'.$id, $data);
            $img= $response->json();
            if(isset($img['success'])){
                $rq->file('ImageUrl')->move(public_path('/images/user/'), $img['newImg']);
                if($old!='none.jpg')
                    unlink(public_path('/images/user/').$old);
                    event(new GetMgsRealTime('success'));
                return response()->json(['success'=>true,'img'=>$img['newImg']]);
            }
            else
                return response()->json(['success'=>false,$img]);
        }
        else
            return response()->json(['success'=>false]);
    }
}
