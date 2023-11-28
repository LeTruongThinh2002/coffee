<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
    Route::controller(HomeController::class)->group(function(){
        Route::get('/','index');
        Route::post('/home/getProductIndex','getProductIndex');
        Route::post('/home/getProductByClass','getProductByClass');
    });
Route::controller(InvoiceController::class)->middleware('api')->group(function(){
    Route::post('/invoice','index');
    Route::post('/invoice/doAdmins','doAdmins');
    Route::post('/invoice/add','add');
    Route::post('/invoice/details/{o}','details');
    Route::post('/invoice/getCategory','getCategory');
    Route::post('/invoice/getProductul','getProductul');
    Route::post('/invoice/getChartDetail','getChartDetail');
    Route::post('/invoice/getChartDetailProduct','getChartDetailProduct');
    Route::post('/invoice/searchBoxInv','searchBoxInv');
    Route::post('/invoice/searchDay','searchDay');
});
Route::controller(CartController::class)->middleware('api')->group(function(){
    Route::post('/cart','index');
    Route::post('/cart/edit/{o}','edit');
    Route::post('/cart/delete/{o}','delete');
    Route::post('/cart/add','add');
    Route::get('/cart/checkout','checkout');
});
Route::controller(ProductController::class)->group(function(){
    Route::post('/product/details/{o}','details');
    Route::post('/product/cadd','cadd');
    Route::post('/product/edit/{o}','edit');
    Route::post('/product/doEdit/{o}','doEdit');
    Route::post('/product/delete/{o}','delete');
    Route::post('/product/searchBox','searchBox');
    Route::post('/product/getProductInx','getProductInx');
    Route::post('/product/searchBoxPro','searchBoxPro');
});
Route::controller(AuthController::class)->middleware('api')->group(function(){
    Route::get('/auth','index');
    Route::post('/auth/login','login');
    Route::post('/auth/register','register');
    Route::post('/auth/logout','logout');
    Route::post('/auth/uploadImage/{o}','uploadImage');
    Route::post('/auth/verify','verify');
    Route::post('/auth/forgotpassword','forgotpassword');
    Route::post('/auth/resetpw','resetpw');
    Route::post('/auth/changepassword','changepassword');
    Route::post('/auth/changeMail','changeMail');
});
Route::controller(CategoryController::class)->group(function(){
    Route::post('/category','index');
    Route::post('/category/add','add');
    Route::post('/category/edit/{o}','edit');
    Route::post('/category/cdelete/{o}','cdelete');
});
Route::controller(MessageController::class)->middleware('api')->group(function(){
    Route::post('/message/getMessageUser','getMessageUser');
    Route::post('/message/activeMessage','activeMessage');
});
Route::controller(RoleController::class)->group(function(){
    Route::post('/role/add','add');
    Route::post('/role/getAllRole','getAllRole');
    Route::post('/role/edit/{o}','edit');
    Route::post('/role/delete/{o}','delete');
});
Route::controller(UserController::class)->group(function(){
    Route::post('/user','index');
    Route::post('/user/edit/{o}','edit');
    Route::post('/user/delete/{o}','delete');
    Route::post('/user/getAllUser','getAllUser');
    Route::post('/user/searchBoxUs','searchBoxUs');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


