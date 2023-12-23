<?php

namespace App\Http\Controllers;

use App\Models\ProfileImage;
use App\Models\Role;
use App\Models\User;
use App\Models\Message;
use App\Models\MessageView;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Auth\Events\Registered;
use Tymon\JWTAuth\Facades\JWTAuth;
use Pusher\Pusher;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function index(Request $request)
    {
        $token = $request->bearerToken();
        $user = self::checkToken($token);
        if ($user) { 
            Auth::login($user);
        }
        if (Auth::check()) {
            
            
            return response()->json(['user'=>Auth::user(),'arr'=>Role::all(),'img'=>ProfileImage::all()]);
        }
        else
            return response()->json(['error' => 'Unauthorized'], 401);
    }
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    function logout(Request $request){
        $token = $request->bearerToken();
        $user = self::checkToken($token);
        // Xác thực người dùng
        if ($user) {
        // Đăng xuất người dùng
            $user->remember_token = null;
            $user->save();
            return response()->json(['status'=>'success']);
        } else {
            return response()->json(['msg' => 'Invalid token!']);
        }
    }
          
    function uploadImage(Request $rq){
        $token = $rq->bearerToken();
        $user = self::checkToken($token);
        if ($user) {
            $data=$rq->validate(['ImageUrl'=>'required']);
            $name=Str::random(64).'.'.$data['ImageUrl'];
            $ret=DB::statement('CALL InProfileImage(?,?)',[$user->id,$name]);
            if($ret){
                $retp=DB::statement('CALL InsertMessage(?,?)',[$user->id,'Đã thay đổi ảnh đại diện mới']);
                return response()->json(['success'=>true,'newImg'=>$name]);
            }
            else
                return response()->json(['faild']);
        } else {
                return response()->json(['msg' => 'Token không hợp lệ'], 401);
        }
    }
    
    function login(Request $req){   
        try{
            $data=$req->validate(['email'=>'required|email','password'=>'required']);
            $user = User::where('email', $data['email'])->first();
            if(!$user) {
                return response()->json(['error'=> 'User not found'], 404);
            }
            if(!Hash::check($data['password'], $user->password)){
                return response()->json(['error'=> 'Invalid password'], 401);
            }
            $token = Str::random(64);
            $hash_token = hash('sha256', $token);
            $user->remember_token = $token;
            $user->save();
            Auth::login($user);
            $retp=DB::statement('CALL InsertMessage(?,?)',[Auth::user()->id,'Đăng nhập mới thành công']);
            if($user->email_verify_at)
                return response()->json(['success'=> true,'token'=>$hash_token]);
            else
                return response()->json(['success'=> true,'token'=>$hash_token,'active'=>false]);
        }catch(ValidationException $ex){
            return response()->json(['error'=> 'Invalid data'], 400);
        }catch(Exception $ex){
            return response()->json(['error'=> $ex->getMessage()], 500);
        }
    }
    function register(Request $req){
        if($req->isMethod('post')){
            $data=$req->validate(['name'=>'required','email'=>'required|email|unique:User','password'=>'required']);
            $data['id']=random_int(99999999,PHP_INT_MAX);
            $data['role'] = 2;
            if(User::create($data)){
                return response()->json(['success'=>true]);
            }else
                return response()->json(['false']);
        }
        return response()->json();
    }
    public function verify(Request $request)
    {
        $token = $request->get('token');
        $user = self::checkToken($token);
        if ($user) {
            if ($user->email_verify_at) {
                return response()->json(['msg' => 'Email đã được xác thực trước đó']);
            } else {
                $user->email_verify_at = now();
                $user->save();
                $retp=DB::statement('CALL InsertMessage(?,?)',[$user->id,'Xác thực tài khoản '.$user->email.' thành công']);
                return response()->json(['msg' => 'Email đã được xác thực thành công']);
            }
        } else {
            return response()->json(['msg' => 'Token không hợp lệ'], 401);
        }
    }
    function forgotpassword(Request $req){
        if($req->isMethod('post')){
            $data=$req->validate(['email'=>'required']);
            $user = User::where('email', $data['email'])->first();
            if($user){
                $token = hash('sha3-512',$user->password);
                return response()->json(['token'=>$token]);
            }else{
                return response()->json();
            }
        }
        return response()->json();        
    }
    public function resetpw(Request $request)
    {
        try {
            $token = $request->bearerToken();
            $data=$request->validate(['password'=>'required']);
            
            $user = User::all()->firstWhere(function ($user) use ($token) {
                return hash('sha3-512',$user->password) == $token;
            });
            if (!$user) {
                throw new Exception('User not found');
            }else{
                $user->password = $data['password'];
                $user->save();
                $retp=DB::statement('CALL InsertMessage(?,?)',[$user->id,'Reset password cho '.$user->email.' thành công']);
                return response()->json(['success' => true]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

   

function changepassword(Request $request)
{
    $token = $request->bearerToken();
    $user = self::checkToken($token);
        if ($user) { 
            Auth::login($user);
        }
    if(Auth::check()){
        $data = $request->validate(['password'=>'required','newpassword'=>'required']);
        $user = User::where('id', Auth::user()->id)->first();
        if($user){
            if(Hash::check($data['password'], $user->password)){
                $user->password = bcrypt($data['newpassword']);
                $user->save();
                $retp=DB::statement('CALL InsertMessage(?,?)',[$user->id,'Đổi password cho '.$user->email.' thành công']);
                return response()->json(['success'=> true]);
            }else{
                return response()->json(['error'=> 'Mật khẩu hiện tại không chính xác']);
            }
        }
    }
    return response()->json(['error'=> 'Người dùng không đăng nhập']);
}
function changeMail(Request $request)
{
    $token = $request->bearerToken();
    $user = self::checkToken($token);
    if ($user) { 
        Auth::login($user);
    }
    if(Auth::check()){
        $data = $request->validate(['password'=>'required','newEmail'=>'required']);
        $user = User::where('id', Auth::user()->id)->first();
        if($user){
            if(Hash::check($data['password'], $user->password)){
                $user->email = $data['newEmail'];
                $user->email_verify_at = null;
                $user->save();
                $retp=DB::statement('CALL InsertMessage(?,?)',[$user->id,'Đổi email cho tài khoản thành công']);
                return response()->json(['success'=> true]);
            }else{
                return response()->json(['error'=> 'Mật khẩu hiện tại không chính xác']);
            }
        }
    }
    return response()->json(['error'=> 'Người dùng không đăng nhập']);
}


}
