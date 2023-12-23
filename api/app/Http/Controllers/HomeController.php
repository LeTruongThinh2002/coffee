<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pro=DB::select('CALL getRem()'); //procedure lấy product bán chạy nhất
        if($pro)
            $re=array_slice($pro, 0, 7);
        else{
            $ret=Product::all()->toArray();
            shuffle($ret);
            $re=array_slice($ret, 0, 7);
        }
        return response()->json(['cat'=>Category::all(),'recommend'=>$re]);
    }
    function getProductIndex(){
        $perPage = 3;
        $product=Product::paginate($perPage);
        $totalPages = $product->lastPage();
        return response()->json(['success'=>true,'product'=>$product, 'totalPages' => $totalPages]);
    }
    function getProductByClass(Request $rq){
        $perPage = 3;
        $data = $rq->validate(['classId' => 'required']);
        $product = Product::where('CategoryId', $data['classId'])->paginate($perPage);
        $totalPages = $product->lastPage();
        $productprice=ProductPrice::all();
        foreach ($product as $key => $value) {
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
        return response()->json(['success'=>true,'product'=>$product, 'totalPages' => $totalPages]);
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
