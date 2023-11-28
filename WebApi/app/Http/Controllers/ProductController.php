<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Size;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    function getProductInx(Request $rq)
    {
        $order=$rq->get('order','ASC');
        $perPage = 5;
        $product=Product::orderBy('ProductName', $order)->paginate($perPage);
        $totalPages = $product->lastPage();
        $productprice=ProductPrice::all();
        $cat=Category::all();
        foreach ($product as $key => $value) {
            foreach($cat as $i)
            {
                if($i['CategoryId']==$value['CategoryId']){
                    $product[$key]['CategoryName']=$i['CategoryName'];
                }
            }
            $sizes = [];
            $prices = [];
            foreach ($productprice as $pValue) {
                if ($value['ProductId'] == $pValue['ProductId']) {
                    $sizes[] = $pValue['Size'];
                    $prices[] = $pValue['Price'];
                }
            }
            if (!empty($sizes) && !empty($prices)) {
                $product[$key]['Sizes'] = $sizes;
                $product[$key]['Prices'] = $prices;
            }
        }
        return response()->json(['success'=>true,'product'=>$product, 'totalPages' => $totalPages,'cat'=>$cat,'sz'=>Size::all()]);
    }
    function searchBoxPro(Request $rq)
    {
        try{
            $perPage = 5; // Số lượng hóa đơn trên mỗi trang
            $page=$rq->get('page',1);
            $data=$rq->validate(['q'=>'required','order'=>'required']);
            $product=DB::select('CALL GetSearchProduct(?,?)',[$data['q'],$data['order']]);
            if($product){
                $productprice=ProductPrice::all();
                foreach ($product as $key => $value) {
                    $sizes = [];
                    $prices = [];
                    foreach ($productprice as $pValue) {
                        if ($value->ProductId == $pValue['ProductId']) {
                            $sizes[] = $pValue['Size'];
                            $prices[] = $pValue['Price'];
                        }
                    }
                    if (!empty($sizes) && !empty($prices)) {
                        $product[$key]->Sizes = $sizes;
                        $product[$key]->Prices = $prices;
                    }
                }
                $product=collect($product);
                // Chuyển đổi kết quả đã sắp xếp thành một bộ sưu tập phân trang
                $paginator = new LengthAwarePaginator($product->forPage($page, $perPage), $product->count(), $perPage, $page, ['path' => url()->current()]);
                $totalPages = $paginator->lastPage(); // Lấy tổng số trang
                return response()->json(['success' => true, 'product' => $paginator, 'totalPages' => $totalPages]);
            }
            return response()->json(['error'=>'khong tim thay product phù hợp']);
        }catch(Exception $e){
            return response()->json(['error'=>$e]);
            }
    }
    function details(int $id){
        return response()->json(['drr'=>Product::all(),'arr'=>Product::where('ProductId', $id)->first(),'prr'=>ProductPrice::all(),'name'=>Category::all()]);
    }
    function cadd(Request $req){
        try {
            $data=$req->validate(['ProductId'=>'required','ProductName'=>'required','CategoryId'=>'required','Description'=>'required','ImageUrl'=>'required','SizePriceArray'=>'required']);
            $name=Category::where('CategoryId',$data['CategoryId'])->first()['CategoryName'];
            $newCategory = DB::statement('CALL InsertProduct(?,?,?,?,?)',[$data['ProductId'],$data['CategoryId'],$data['ProductName'],$data['Description'],$data['ImageUrl']]);
            $size = $req->validate(['SizePriceArray'=>'required']);
            $sizeArray = json_decode($size['SizePriceArray'], true); // Giả sử $size['SizePriceArray'] là một chuỗi JSON
            if($newCategory){
                foreach ($sizeArray as $subArray) {
                    if(isset($subArray[0]) && isset($subArray[1]))
                        $rst = DB::statement('CALL UpdateSize(?,?,?)', [$data['ProductId'], $subArray[0], $subArray[1]]);
                }
                if(isset($rst)){
                    if($rst)
                        return response()->json(['success'=>true,'name'=>$name]);
                }
                else
                    return response()->json(['success'=>false]);
            }
            return response()->json($data);
        } catch (Exception $e) {
            // Xử lý lỗi ở đây
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    function searchBox(Request $rq){
        $data=$rq->validate(['q'=>'required']);
        $ret=DB::select('CALL SearchProducts(?)',[$data['q']]);
        if($ret){
            return response()->json(['dataSB'=>$ret]);
        }
        return response()->json();
    }
    function delete(int $id){
        $result = DB::select('CALL GetProductById(?)',[$id]);
        $arr = $result[0]->ImageUrl;
        $re=DB::statement('CALL DeleteProduct(?)',[$id]);
        $ret=DB::statement('CALL DeletePrice(?)',[$id]);
        if($re){
            if($ret)
                return response()->json($arr);
        }
        return response()->json();
    }
    function edit(int $id){
        $result = DB::select('CALL GetProductById(?)',[$id]);
        $pd=$result[0];
        if(isset($pd)){
        $pd->CategoryName=Category::where('CategoryId', $pd->CategoryId)->first()['CategoryName'];
        return response()->json(['pd'=>$pd,'price'=>ProductPrice::all(),'cat'=>Category::all(),'sz'=>Size::all()]);
        }else
            return response()->json();
    }
    function doEdit(Request $rq,int $id ){
        $data=$rq->validate(['ProductName'=>'required','CategoryId'=>'required','Description'=>'required','ImageUrl'=>'required']);
        $data['ProductId']=$id;
        $result=DB::statement('CALL UpdateProduct(?,?,?,?,?)',[$id,$data['CategoryId'],$data['ProductName'],$data['Description'],$data['ImageUrl']]);
        $size = $rq->validate(['SizePriceArray'=>'required']);
        $sizeArray = json_decode($size['SizePriceArray'], true); // Giả sử $size['SizePriceArray'] là một chuỗi JSON
        foreach ($sizeArray as $subArray) {
            if(isset($subArray[0]) && isset($subArray[1]))
                $rst = DB::statement('CALL UpdateSize(?,?,?)', [$id, $subArray[0], $subArray[1]]);
        }
        $dsize = $rq->validate(['UncheckedSizes'=>'required']);
        $dsizeArray = json_decode($dsize['UncheckedSizes'], true); // Giả sử $dsize['UncheckedSizes'] là một chuỗi JSON
        foreach ($dsizeArray as $sizeId) {
            $rst = DB::statement('CALL DeleteSize(?,?)', [$id, $sizeId]);
        }
        if($result && $rst)
            return response()->json(true);
        else
            return response()->json(false);
    }
}