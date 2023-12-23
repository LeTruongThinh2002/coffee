<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\District;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Province;
use App\Models\User;
use App\Models\Wards;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    function index(Request $rq){
        $token = $rq->bearerToken();
        $user = self::checkToken($token);
        if ($user) { 
            Auth::login($user);
        }
        if(Auth::check()){
            $invoice=Invoice::where("UserId",Auth::user()->id)->get();
            foreach($invoice as $k => $in){
                $lo = DB::select('CALL GetLocation(?)', [$in['WardId']]);
                foreach ($lo as $row) {
                    $invoice[$k]['Address'] .= ', ' . $row->wName . ', ' . $row->dName . ', ' . $row->pName;
                }
            }
            return response()->json(['invoice'=>$invoice]);
        }
        else
            return response()->json(['auth']);
    }
    function doAdmins(Request $rq){
        try{
            $perPage = 5; // Số lượng hóa đơn trên mỗi trang
            $page=$rq->get('page',1);
            $order=$rq->validate(['order'=>'required']);
            $invoices = DB::select('CALL GetInvoiceAll(?)',[$order['order']]);
            foreach ($invoices as $k => $invoice) {
                $lo = DB::select('CALL GetLocation(?)', [$invoice->WardId]);
                foreach ($lo as $row) {
                    $invoices[$k]->Address .= ', ' . $row->wName . ', ' . $row->dName . ', ' . $row->pName;
                }
            }
            $invoices=collect($invoices);
            // Chuyển đổi kết quả đã sắp xếp thành một bộ sưu tập phân trang
            $paginator = new LengthAwarePaginator($invoices->forPage($page, $perPage), $invoices->count(), $perPage, $page, ['path' => url()->current()]);
            $totalPages = $paginator->lastPage(); // Lấy tổng số trang
            return response()->json(['success' => true, 'invoice' => $paginator, 'totalPages' => $totalPages]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
    
    
    function searchBoxInv(Request $rq){
        try{
        $perPage = 5; // Số lượng hóa đơn trên mỗi trang
        $page=$rq->get('page',1);
        $data=$rq->validate(['q'=>'required','day'=>'required','order'=>'required']);
        if($data['day']!='f')
            $data['day']='AND DATE(Invoice.created_at) = "'.$data['day'].'"';
        else
            $data['day']='';
        $ret=DB::select('CALL GetUserInvoices(?,?,?)',[$data['q'],$data['day'],$data['order']]);
        if($ret){
            foreach($ret as $k => $v){
                $lo = DB::select('CALL GetLocation(?)', [$v->WardId]);
                foreach ($lo as $row) {
                    $ret[$k]->Address .= ', ' . $row->wName . ', ' . $row->dName . ', ' . $row->pName;
                }
            }
            $ret=collect($ret);
            // Chuyển đổi kết quả đã sắp xếp thành một bộ sưu tập phân trang
            $paginator = new LengthAwarePaginator($ret->forPage($page, $perPage), $ret->count(), $perPage, $page, ['path' => url()->current()]);
            $totalPages = $paginator->lastPage(); // Lấy tổng số trang
            return response()->json(['success' => true, 'dataSB' => $paginator, 'totalPages' => $totalPages]);
        }
        return response()->json(['error'=>'khong tim thay user']);
    }catch(\Exception $e){
        return response()->json(['error'=>$e]);
        }
    }
    function searchDay(Request $rq){
        try{
        $perPage = 5; // Số lượng hóa đơn trên mỗi trang
        $page=$rq->get('page',1);
        $data=$rq->validate(['date'=>'required','order'=>'required']);
        $invoice = DB::select('CALL GetDayInvoices(?,?)',[$data['date'],$data['order']]);
        
        foreach($invoice as $k => $in){
            $lo = DB::select('CALL GetLocation(?)', [$in->WardId]);
            foreach ($lo as $row) {
                $invoice[$k]->Address .= ', ' . $row->wName . ', ' . $row->dName . ', ' . $row->pName;
            }
        }
        $invoice=collect($invoice);
        // Chuyển đổi kết quả đã sắp xếp thành một bộ sưu tập phân trang
        $paginator = new LengthAwarePaginator($invoice->forPage($page, $perPage), $invoice->count(), $perPage, $page, ['path' => url()->current()]);
        $totalPages = $paginator->lastPage(); // Lấy tổng số trang
        return response()->json(['success' => true, 'invoice' => $paginator, 'totalPages' => $totalPages]);
    }catch(\Exception $e){
        return response()->json(['error'=>$e]);
        }
    }
    function details(int $id){
        $detail=InvoiceDetail::where('InvoiceId',$id)->get();
        $pr=Product::all();
        foreach($detail as $k => $v){
            foreach($pr as $n){
                if($v['ProductId']==$n['ProductId']){
                    $detail[$k]['ProductName']=$n['ProductName'];
                    $detail[$k]['ImageUrl']=$n['ImageUrl'];
                }
            }
        }
        return response()->json(['detail'=>$detail]);
    }
    public function add(Request $rq){
        try {
            $token = $rq->bearerToken();
            $user = self::checkToken($token);
            if ($user) { 
                Auth::login($user);
            }
            if(Auth::check()){
                if(Auth::user()->email_verify_at=='')
                    return response()->json(['error' => 'Vui lòng xác thực email trước khi đặt hàng!']);
                $data=$rq->validate(['Phone'=>'required|numeric|digits_between:10,11','Address'=>'required','Wards_id'=>'required','Province_id'=>'required','District_id'=>'required']);
                $data['InvoiceId']=random_int(1,1000000);
                $data['created_at']=date('Y-m-d H:i:s');
                $response=DB::statement('CALL InsertIntoInvoice(?,?,?,?,?,?,?,?)',[$data['InvoiceId'],Auth::user()->id,$data['Province_id'],$data['District_id'],$data['Wards_id'],$data['Phone'],$data['Address'],now()]);
                $pro=Cart::where('UserId',Auth::user()->id)->get();
                $lo = DB::select('CALL GetLocation(?)', [$data['Wards_id']]);
                foreach ($lo as $row) {
                    $data['Address'] .= ', ' . $row->wName . ', ' . $row->dName . ', ' . $row->pName;
                }
                $price=ProductPrice::all();
                $data['TotalAll']=0;
                // Khởi tạo
                $data['product'] = [];
                if($response){
                    foreach($pro as $key => $v){
                        foreach($price as $k)
                        {
                            if($v['ProductId']==$k['ProductId']){
                                if($v['Size']==$k['Size']){
                                    $total=$v['Amount']*$k['Price'];
                                    $ret=DB::statement('CALL InInvoiceDetail(?,?,?,?,?,?)',[$data['InvoiceId'],$v['ProductId'],$k['Price'],$v['Size'],$v['Amount'],$total]);
                                    // Thêm sản phẩm mới vào mảng
                                    $data['product'][$key] = [
                                        'ProductId' => $v['ProductId'],
                                        'Price' => $k['Price'],
                                        'Size' => $v['Size'],
                                        'Amount' => $v['Amount']
                                    ];
                                    $data['TotalAll']+=$total;
                                }
                            }
                        }
                    }
                    if($ret){
                        foreach($pro as $v){
                            $r=DB::statement('CALL DeleteCart(?,?)',[Auth::user()->id,$v['ProductId']]);
                        }
                        if($r){
                            $pName=Product::all();
                            foreach($data['product'] as $k =>$p){
                                foreach($pName as $m){
                                    if($p['ProductId']==$m['ProductId']){
                                        // Thêm ProductName và ImageUrl vào sản phẩm hiện tại
                                        $data['product'][$k]['ProductName']=$m['ProductName'];
                                        $data['product'][$k]['ImageUrl']=$m['ImageUrl'];
                                    }
                                }
                            }
                            $retp=DB::statement('CALL InsertMessage(?,?)',[Auth::user()->id,'Đặt hàng thành công đơn hàng #'.$data['InvoiceId']]);
                            return response()->json(['success' =>$data, 'email'=>Auth::user()->email]);
                        }
                    }
                    else
                        return response()->json();
                }
            }else{
                return response()->json(['auth']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    function getCategory(){
        $category = Category::all();
        return response()->json(['category'=> $category]);
    }
    function getProductul(){
        $product = DB::select('SELECT ProductName as name, ProductId as id FROM Product');
        return response()->json(['product'=> $product]);
    }
    function getChartDetail(Request $rq){
        try{
            $data=$rq->validate(['checkedInputId'=>'required','arrayTime'=>'required','arrayClass'=>'required']);
            $arrayChart = [];
            $checkedInputId = $data['checkedInputId'];
            $arrayClass = $data['arrayClass'];
            $arrayTime = $data['arrayTime'];
            foreach($arrayClass as $k => $v){
                switch($checkedInputId) {
                    case 'checkPer':
                        $arrayChart[$k] = DB::select('CALL GetChartPeriod(?,?,?)', [$v, $arrayTime[0], $arrayTime[1]]);
                        break;
                    case 'checkDay':
                        $arrayChart[$k] = DB::select('CALL GetChartDay(?,?,?,?)', [$v, $arrayTime[2], $arrayTime[1], $arrayTime[0]]);
                        break;
                    case 'checkMonth':
                        $arrayChart[$k] = DB::select('CALL GetChartMonth(?,?,?)', [$v, $arrayTime[1], $arrayTime[0]]);
                        break;
                    case 'checkYear':
                        $arrayChart[$k] = DB::select('CALL GetChartYear(?,?)', [$v, $arrayTime[0]]);
                        break;
                    default:
                        return response()->json(['error'=> 'Fail Check Time Input!']);
                }
            }
            return response()->json(['arrayChart'=> $arrayChart]);
        }catch (\Exception $e) {
            return response()->json(['error'=> $e->getMessage()]);
        }
    }
    function getChartDetailProduct(Request $rq){
        try{
            $data=$rq->validate(['checkedInputId'=>'required','arrayTime'=>'required','arrayClass'=>'required']);
            $arrayChart = [];
            $checkedInputId = $data['checkedInputId'];
            $arrayClass = $data['arrayClass'];
            $arrayTime = $data['arrayTime'];
            foreach($arrayClass as $k => $v){
                switch($checkedInputId) {
                    case 'checkPer':
                        $arrayChart[$k] = DB::select('CALL GetChartPeriodProduct(?,?,?)', [$v, $arrayTime[0], $arrayTime[1]]);
                        break;
                    case 'checkDay':
                        $arrayChart[$k] = DB::select('CALL GetChartDayProduct(?,?,?,?)', [$v, $arrayTime[2], $arrayTime[1], $arrayTime[0]]);
                        break;
                    case 'checkMonth':
                        $arrayChart[$k] = DB::select('CALL GetChartMonthProduct(?,?,?)', [$v, $arrayTime[1], $arrayTime[0]]);
                        break;
                    case 'checkYear':
                        $arrayChart[$k] = DB::select('CALL GetChartYearProduct(?,?)', [$v, $arrayTime[0]]);
                        break;
                    default:
                        return response()->json(['error'=> 'Fail Check Time Input!']);
                }
            }
            return response()->json(['arrayChart'=> $arrayChart]);
        }catch (\Exception $e) {
            return response()->json(['error'=> $e->getMessage()]);
        }
    }
}
