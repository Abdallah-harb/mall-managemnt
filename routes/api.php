<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Department\DepartmentController;
use App\Http\Controllers\Api\Malls\MallController;
use App\Http\Controllers\Api\Manager\ManagerController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Vendor\VendorController;
use Illuminate\Http\Request;
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

Route::group(['middleware' => ['Authenticate','Manager']],function(){
     //managers
    Route::group(['prefix' => 'managers'],function (){
        Route::get('/',[ManagerController::class,'allManager']);
        Route::get('edit',[ManagerController::class,'edit']);
        Route::post('update',[ManagerController::class,'update']);

    });
        //malls
    Route::group(['prefix' => 'malls'],function(){
        Route::get('/',[MallController::class,'index']);
        Route::post('create',[MallController::class,'create']);
        Route::post('update/{id}',[MallController::class,'update']);
        Route::post('delete/{id}',[MallController::class,'destroy']);
    });
        //Department
    Route::group(['prefix'=>'department'],function(){
        Route::get('/',[DepartmentController::class,'index']);
        Route::post('store',[DepartmentController::class,'store']);
        Route::get('show/{id}',[DepartmentController::class,'show']);
        Route::post('update/{id}',[DepartmentController::class,'update']);
        Route::post('delete/{id}',[DepartmentController::class,'destroy']);
    });
        //vendor
    Route::group(['prefix' => 'vendor'],function(){
        Route::get('/',[VendorController::class,'index']);
        Route::post('store',[VendorController::class,'store']);
        Route::get('show/{id}',[VendorController::class,'show']);
        Route::post('update/{id}',[VendorController::class,'update']);
        Route::post('delete/{id}',[VendorController::class,'destroy']);
    });
        //category
    Route::group(['prefix' => 'category'],function(){
        Route::get('/',[CategoryController::class,'index']);
        Route::post('store',[CategoryController::class,'store']);
        Route::get('show/{id}',[CategoryController::class,'show']);
        Route::post('update/{id}',[CategoryController::class,'update']);
        Route::post('delete/{id}',[CategoryController::class,'destroy']);
    });

    //vendor
    Route::group(['prefix' => 'products'],function(){
        Route::get('/',[ProductController::class,'index']);
        Route::post('store',[ProductController::class,'store']);
        Route::get('show/{id}',[ProductController::class,'show']);
        Route::post('update/{id}',[ProductController::class,'update']);
        Route::post('delete/{id}',[ProductController::class,'destroy']);
    });


});

Route::group(['prefix' => 'public'],function(){

    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);

});
