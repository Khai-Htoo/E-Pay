<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('user')->group(function () {
   Route::post('register',[AuthController::class,'register']);
   Route::post('login',[AuthController::class,'login']);

   Route::middleware(['auth:sanctum'])->group(function () {
       Route::get('profile',[PageController::class,'profile']);
       Route::post('logout',[AuthController::class,'logout']);

       Route::get('transaction',[PageController::class,'transaction']);
       Route::get('transaction/{trx_no}',[PageController::class,'transactionDetail']);

       Route::get('notification',[PageController::class,'notification']);
       Route::get('notification/{id}',[PageController::class,'notificationDetail']);

       Route::get('verifyPhone',[PageController::class,'verifyPhone']);
       Route::get('transferConfirm',[PageController::class,'transferConfirm']);
       Route::post('complete',[PageController::class,'complete']);

   });

});
