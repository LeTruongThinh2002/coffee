<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    function index(){
        return response()->json(['arr'=>Category::all()]);
    }
    function add(Request $req){
        $kt = Category::where('CategoryName', $req)->exists();
        if($kt){
            $msg=true;
            return response()->json(['success' => false,'msg'=>$msg]);
        }
        else{
            $data=$req->validate(['CategoryName'=>'required','Description'=>'required','ImageUrl'=>'required']);
            $newCategory = DB::statement('CALL InsertCategory(?,?,?)',[$data['CategoryName'],$data['Description'],$data['ImageUrl']]);
            if($newCategory)
            {
                $id=Category::where('CategoryName', $data['CategoryName'])->first()['CategoryId'];
                return response()->json(['CategoryId'=>$id]);
            }
            else
                return response()->json();
        }
    }
    
    function cdelete(int $id){
        $result = DB::select('CALL GetCategoryById(?)',[$id]);
        $arr = $result[0]->ImageUrl;
        $ret=DB::statement('CALL RemoveCategory(?)',[$id]);
        if($ret){
            return response()->json($arr);
        }
        return response()->json();
    }
    function edit(Request $rq,int $id ){
        $result = DB::select('CALL GetCategoryById(?)',[$id]);
        $arr = $result[0]->ImageUrl;
        $test=false;
        $data=$rq->validate(['CategoryName'=>'required','Description'=>'required','ImageUrl'=>'required']);
        if($arr==$data['ImageUrl'])
            $test=true;
        $ret=DB::statement('CALL EditCategory(?,?,?,?)',[$id,$data['CategoryName'],$data['Description'],$data['ImageUrl']]);
        if($ret){
            if($test)
                return response()->json(['test'=>$test]);
            else
                return response()->json(['test'=>$test,'img'=>$arr]);
        }
        return response()->json();
    }
}
