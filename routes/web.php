<?php

use App\Http\Controllers\AdminCOntroller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserWalletController;
use App\Http\Controllers\WalletController;
use App\Models\Transaction;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['login'])->group(function () {
    Route::get('/',[DashboardController::class,'login']);
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    //  for admin
    Route::group(['prefix'=>'admin','middleware'=> 'admin_auth'],function(){
        Route::get('homePage', [DashboardController::class, 'adminHomePage'])->name('adminHomePage');

        Route::resource('management', AdminCOntroller::class);
        Route::get('delete/{id}',[AdminCOntroller::class,'delete'])->name('admin#delete');
        Route::get('dataTable/ssd',[AdminCOntroller::class,'ssd']);

        // wallet
        Route::get('wallet',[WalletController::class,'index'])->name('wallet');
        Route::get('wallet/dataTable/ssd',[WalletController::class,'ssd']);

        Route::get('addMoney',[WalletController::class,'addMoney'])->name('addMoney');
         Route::post('AddMoneyData',[WalletController::class,'addMoneyData'])->name('addMoneyCreate');

    });

   // for user
   Route::group(['prefix'=>'user','middleware'=> 'user_auth'],function(){
    Route::get('homePage', [DashboardController::class, 'userHomePage'])->name('userHomePage');
    Route::get('account',[UserAccountController::class,'index'])->name('user#account');
    Route::get('updatePassword',[UserAccountController::class,'updatePassword'])->name('account#updatePassword');
    Route::post('changePassword',[UserAccountController::class,'changePassword'])->name('account#changePassword');

    Route::get('wallet',[UserWalletController::class,'wallet'])->name('user#wallet');
    Route::get('transfer',[UserWalletController::class,'transfer'])->name('user#transfer');
    Route::get('transferConfirm',[UserWalletController::class,'transferConfirm'])->name('user#transferConfirm');
    Route::get('checkPassword',[UserWalletController::class,'checkPassword']);
    Route::get('transferHash',[UserWalletController::class,'transferHash'])->name('transferHash');

    Route::get('verifyPhone',[UserWalletController::class,'verifyPhone']);
    Route::post('completed',[UserWalletController::class,'completed'])->name('completed');

    Route::get('transaction',[TransactionController::class,'transaction'])->name('user#transaction');
    Route::get('transactionDetail/{trx_no}',[TransactionController::class,'transactionDetail'])->name('user#transactionDetail');

    Route::get('receiveQr',[UserWalletController::class,'receiveQr'])->name('receiveQr');
    Route::get('scanQr',[UserWalletController::class,'scanQr'])->name('scanQr');

    Route::get('notification',[NotificationController::class,'notification'])->name('notification');
    Route::get('notiDetail/{id}',[NotificationController::class,'notiDetail'])->name('notiDetail');

    Route::get('notiCount',[NotificationController::class,'notiCount'])->name('notiCount');
   });
});



require __DIR__ . '/auth.php';
