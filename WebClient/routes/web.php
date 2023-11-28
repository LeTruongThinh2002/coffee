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
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::controller(HomeController::class)->group(function(){
    Route::get('/','index');
    Route::get('/home/contact','contact');
    Route::post('/home/contact','doContact');
    Route::post('/home/getProductIndex','getProductIndex');
    Route::post('/home/getProductByClass','getProductByClass');
    Route::post('/home/messageview/{id}','messageview');
});
Route::controller(MessageController::class)->group(function(){
    Route::post('/message/getMessageUser','getMessageUser');
    Route::post('/message/activeMessage','activeMessage');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(InvoiceController::class)->group(function(){
    Route::match(['post','get'],'/invoice','index');
    Route::post('/invoice/add','add');
    Route::post('/invoice/details/{o}','details');
    Route::match(['post','get'],'/invoice/admins','admins');
    Route::post('/invoice/doAdmins','doAdmins');
    Route::post('/invoice/getCategory','getCategory');
    Route::post('/invoice/getProductul','getProductul');
    Route::post('/invoice/getChartDetail','getChartDetail');
    Route::post('/invoice/getChartDetailProduct','getChartDetailProduct');
    Route::post('/invoice/searchBoxInv','searchBoxInv');
    Route::post('/invoice/searchDay','searchDay');
    Route::match(['post','get'],'/invoice/revenue','revenue');
});
Route::controller(CartController::class)->group(function(){
    Route::match(['post','get'],'/cart','index');
    Route::post('/cart/edit/{o}','edit');
    Route::post('/cart/delete/{o}','delete');
    Route::post('/cart/add','add');
    Route::get('/cart/checkout','checkout');
});
Route::controller(ProductController::class)->group(function(){
    Route::match(['post','get'],'/product','index');
    Route::match(['post','get'],'/product/details/{o}','details');
    Route::match(['post','get'],'/product/edit/{o}','edit');
    Route::post('/product/doEdit/{o}','doEdit');
    Route::post('/product/delete/{o}','delete');
    Route::post('/product/cadd','cadd');
    Route::post('/product/searchBox','searchBox');
    Route::post('/product/getProductInx','getProductInx');
    Route::post('/product/searchBoxPro','searchBoxPro');
});
Route::controller(AuthController::class)->group(function(){
    Route::get('/auth','index');
    Route::match(['post','get'],'/auth/login','login');
    Route::match(['post','get'],'/auth/register','register');
    Route::match(['post','get'],'/auth/logout','logout');
    Route::match(['post','get'],'/auth/uploadImage/{o}','uploadImage');
    Route::match(['post','get'],'/auth/verify','verify');
    Route::match(['post','get'],'/auth/forgotpassword','forgotpassword');
    Route::match(['post','get'],'/auth/resetpassword','resetpassword');
    Route::match(['post','get'],'/auth/doResetpassword','doResetpassword');
    Route::match(['post','get'],'/auth/changepassword','changepassword');
    Route::match(['post','get'],'/auth/changeMail','changeMail');
});
Route::controller(CategoryController::class)->group(function(){
    Route::get('/category','index');
    Route::post('/category/add','add');
    Route::post('/category/edit/{o}','edit');
    Route::post('/category/cdelete/{o}','cdelete');
});
Route::controller(RoleController::class)->group(function(){
    Route::get('/role','index');
    Route::post('/role/getAllRole','getAllRole');
    Route::post('/role/add','add');
    Route::post('/role/edit/{o}','edit');
    Route::post('/role/delete/{o}','delete');
});
Route::controller(UserController::class)->group(function(){
    Route::get('/user','index');
    Route::post('/user/edit/{o}','edit');
    Route::post('/user/delete/{o}','delete');
    Route::post('/user/getAllUser','getAllUser');
    Route::post('/user/searchBoxUs','searchBoxUs');
});

