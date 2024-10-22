<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register',[UserController::class,'store']);
Route::post('/login',[UserController::class,'login']);
Route::post('/product',[ProductController::class,'addProduct']);
Route::get('/list',[ProductController::class,'list']);
Route::get('/product/{id}',[ProductController::class,'productId']);
Route::delete('/delete/{id}',[ProductController::class,'delete']);
Route::post('/update/{id}',[ProductController::class,'update']);
