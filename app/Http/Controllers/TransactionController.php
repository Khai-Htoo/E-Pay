<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // transaction page
    public function transaction(Request $request){
        $transaction = Transaction::with('user','source')->where('user_id',Auth::user()->id)->orderBy('created_at','desc');

        if($request->type){
            $transaction = $transaction->where('type',$request->type);
        }

        if($request->date){
            $transaction = $transaction->whereDate('created_at',$request->date);
        }

        $transaction = $transaction->get();
        // return $transaction;
        return view('user.transaction',compact('transaction'));
    }

    // transaction detail
    public function transactionDetail($trx_no){
       $t = Transaction::with('user','source')->where('trx_no',$trx_no)->first();
       return view('user.TransactionDetail',compact('t'));
    }
}
