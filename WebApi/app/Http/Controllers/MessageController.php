<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    function getMessageUser(Request $rq){
        $token = $rq->bearerToken();
        $user = self::checkToken($token);
        if ($user) { 
            Auth::login($user);
        }
        if(Auth::check()){
            $messages = Message::where("member_id", Auth::user()->id)->orderBy('id', 'desc')->get();
            foreach($messages as $k => $v){
                $timestamp = strtotime($messages[$k]->created_at);
                $messages[$k]->date = date('Y-m-d', $timestamp);
                $messages[$k]->time = date('H:i:s', $timestamp);
            }
            return response()->json(['msgs'=>$messages]);
        }
        else
            return response()->json(['auth']);
    }
    function activeMessage(Request $rq){
        $token = $rq->bearerToken();
        $user = self::checkToken($token);
        if ($user) { 
            Auth::login($user);
        }
        if(Auth::check()){
            $ret = DB::statement('CALL UpdateActiveMessage(?)',[Auth::user()->id]);
            if($ret)
                return response()->json(['success'=>true]);
            else
                return response()->json(['success'=>false]);
        }
        else
            return response()->json(['auth']);
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
}
