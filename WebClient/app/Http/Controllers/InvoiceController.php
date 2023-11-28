<?php

namespace App\Http\Controllers;

use App\Events\GetMgsRealTime;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class InvoiceController extends Controller
{
    function index(){
        $token = self::auths();
        if($token){
            $response=Http::withToken($token)->post('http://127.0.0.1:8000/api/invoice')->json();
            if(isset($response['auth'])){
                Session::forget('token');
                return redirect('/auth/login');
            }
            else
            {
                if(isset($response['invoice'])){
                    $invoice = $response['invoice'];
                    if (count($invoice) > 0)
                        return view('invoice.index', ['arr' => $invoice]);
                    else
                        return view('invoice.index',['msg'=>'Không tìm thấy hóa đơn đặt hàng nào!']);
                }else
                return redirect('/auth/login');
            }    
        }else
            return redirect('/auth/login');
    }
    function add(Request $rq){
        $token = self::auths();
        if($token){
            $data=$rq->validate(['Phone'=>'required|numeric','Address'=>'required','Wards_id'=>'required','Province_id'=>'required','District_id'=>'required']);
            $response=Http::withToken($token)->post('http://127.0.0.1:8000/api/invoice/add',$data)->json();
            if(isset($response['auth'])){
                Session::forget('token');
                return redirect('/auth/login');
            }
            else
            {
                if(isset($response['success'])){
                    Mail::to($response['email'])->send(new SendEmail(['content'=>$response['success'],'title'=>'Your Order Complete!']));
                    event(new GetMgsRealTime('success'));
                    return response()->json(['success'=>true]);
                }
                else
                    return response()->json(['success'=>false,'error'=>$response['error']]);
            }
        }else
            return response()->json(['success'=>false,'error'=>'User not found']);
    }
    function details(int $id){
        $response=Http::post('http://127.0.0.1:8000/api/invoice/details/'.$id);
        if(isset($response->json()['detail'])){
            return response()->json(['success' => true, 'arr'=>$response->json()['detail']]);
        }
        return response()->json(['success' => false]);
    }
    function admins(){
        return view('invoice.admins');
    }
    function doAdmins(Request $rq){
        $page=$rq->get('page',1);
        $order=$rq->validate(['order'=>'required']);
        $response=Http::post('http://127.0.0.1:8000/api/invoice/doAdmins?page=' . $page,$order)->json();
        if(isset($response['success'])){
            $invoice = $response['invoice']['data'];
            $totalpage=$response['totalPages'];
            if (count($invoice) > 0) {
                foreach($invoice as $k => $v){
                    $timestamp = strtotime($v['created_at']);
                    $invoice[$k]['date'] = date('Y-m-d', $timestamp);
                    $invoice[$k]['time'] = date('H:i:s', $timestamp);
                }
                return response()->json(['success'=>true,'arr' => $invoice,'page'=>$totalpage]);
            }
            else
                return response()->json(['success'=>false,'msg'=>'Không tìm thấy hóa đơn đặt hàng nào!']);
        }else
            return response()->json(['success'=>false,'msg'=>$response['error']]);
    }
    
    function revenue(){
        return view('invoice.revenue');
    }
    function getCategory(){
        $response=Http::post('http://127.0.0.1:8000/api/invoice/getCategory');
        if(isset($response->json()['category'])){
            $category = $response->json()['category'];
            if (count($category) > 0) 
                return response()->json(['success'=>true,'cat' => $category]);
            else
                return response()->json(['success'=>false,'msg' => 'error']);
        }else
            return response()->json(['success'=>false,'msg' => 'errorApi']);
    }
    function getProductul(){
        $response=Http::post('http://127.0.0.1:8000/api/invoice/getProductul');
        if(isset($response->json()['product'])){
            $product = $response->json()['product'];
            if (count($product) > 0) 
                return response()->json(['success'=>true,'pro' => $product]);
            else
                return response()->json(['success'=>false,'msg' => 'error']);
        }else
            return response()->json(['success'=>false,'msg' => 'errorApi']);
    }
    function getChartDetail(Request $rq){
        if($rq->method() == 'POST'){
            $data=$rq->validate(['checkedInputId'=>'required','arrayTime'=>'required','arrayClass'=>'required']);
            $response=Http::post('http://127.0.0.1:8000/api/invoice/getChartDetail',$data);
            if(isset($response->json()['arrayChart'])){
                $arrayChart = $response->json()['arrayChart'];
                return response()->json(['success'=>true,'Chart' => $arrayChart]);
            }else
                return response()->json(['success'=>false,'error' => $response->json()['error']]);
        }
    }
    function getChartDetailProduct(Request $rq){
        if($rq->method() == 'POST'){
            $data=$rq->validate(['checkedInputId'=>'required','arrayTime'=>'required','arrayClass'=>'required']);
            $response=Http::post('http://127.0.0.1:8000/api/invoice/getChartDetailProduct',$data);
            if(isset($response->json()['arrayChart'])){
                $arrayChart = $response->json()['arrayChart'];
                return response()->json(['success'=>true,'Chart' => $arrayChart]);
            }else
                return response()->json(['success'=>false,'error' => $response->json()['error']]);
        }
    }
    function searchBoxInv(Request $rq){
        if($rq->method() == 'POST'){
            $page=$rq->get('page');
            $data=$rq->validate(['q'=>'required','day'=>'required','order'=>'required']);
            $response=Http::post('http://127.0.0.1:8000/api/invoice/searchBoxInv?page='.$page,$data)->json();
            if(isset($response['success'])){
                $dataSB = $response['dataSB']['data'];
                $totalpage=$response['totalPages'];
                return response()->json(['success' => true,'dataSB'=>$dataSB,'page'=>$totalpage]);
            }else
                return response()->json(['success' => false,'msg'=>$response['error']]);
        }
    }
    function searchDay(Request $rq){
        if($rq->method() == 'POST'){
            $page=$rq->get('page');
            $data=$rq->validate(['date'=>'required','order'=>'required']);
            $response=Http::post('http://127.0.0.1:8000/api/invoice/searchDay?page='.$page,$data)->json();
            if(isset($response['success'])){
                $invoice = $response['invoice']['data'];
                $totalpage=$response['totalPages'];
                if (count($invoice) > 0) {
                    return response()->json(['success'=>true,'arr' => $invoice,'page'=>$totalpage]);
                }
                else
                    return response()->json(['success'=>false,'msg'=>'Không tìm thấy hóa đơn đặt hàng nào!']);
            }else
                return response()->json(['success'=>false,'msg'=>$response['error']]);
        }
    }
}
