<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\wallet;
use App\Models\Transaction;
use App\Helper\CodeGenerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class UserWalletController extends Controller
{
    // wallet page
    public function wallet()
    {
        return view('user.wallet');
    }
    // transfer
    public function transfer(Request $request)
    {
        $toPhone = $request->to_phone;
        $hasPhone = User::where('phone',$toPhone)->first();
        // if(!$hasPhone){
        //     return back()->with(['fail'=>'Your phone number is invalid!']);
        // }
        return view('user.transfer',compact('toPhone'));
    }
    // transfer confirm
    public function transferConfirm(Request $request)
    {

        $this->validateTransfer($request);
        $hashValue = $request->hashValue;
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $note = $request->note;
        $checkPhone = User::where('phone', $to_phone)->first();
        if (!$checkPhone) {
            return back()->with(['fail' => 'Invalid phone number!']);
        }
        if (Auth::user()->wallet->amount < $request->amount) {
            return back()->with(['fail' => 'Insufficient balance!']);
        }
        return view('user.transferConfirm', compact('to_phone','hashValue', 'amount', 'note'));
    }

    // user phone transfer
    public function verifyPhone(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if (Auth::user()->phone != $request->phone) {
            if ($user) {
                return response()->json([
                    'msg' => 'success',
                    'user' => $user,
                ]);
            }
            return response()->json([
                'status' => '404',
                'msg' => 'Account not found',
            ]);
        }
        return response()->json([
            'status' => 'same',
            'msg' => "You can't transfer money your phone no:",
        ]);
    }

    // check completed
    public function checkPassword(Request $request)
    {

        if (Hash::check($request->password, Auth::user()->password)) {
           return response()->json([
            'status' => 'success',
            'msg'=> 'Your password is correct'
           ]);
        }
        return response()->json([
            'status' => 'fail',
            'msg'=> 'Your password is incorrect'
           ]);
    }

    // transfer completed
    public function completed(Request $request)
    {

        $from_account_wallet = Auth::user()->wallet;
        $to_account = User::where('phone',$request->to_phone)->first();
        $to_account_wallet = $to_account->wallet;


        $str = $request->to_phone.$request->amount.$request->note;
        $hashValue = hash_hmac('sha256',$str,'2321');


       if(!$from_account_wallet || !$to_account_wallet){
        return back()->with(['fail'=>'Account not found']);
       }

       if($request->hashValue != $hashValue){
        return back()->with(['fail'=>'Your data is invalid']);
       }

       if($from_account_wallet->amount < $request->amount){
        return back()->with(['fail'=>'Insufficient balance']);
       }



       DB::beginTransaction();
       try {
        $from_account_wallet->decrement('amount',$request->amount);
        $from_account_wallet->update();

        $to_account_wallet->increment('amount',$request->amount);
        $to_account_wallet->update();

        $ref_no = CodeGenerate::refNumber();
        $from = Transaction::create([
           'ref_no' => $ref_no,
           'trx_no' => CodeGenerate::TrxId(),
           'user_id' => Auth::user()->id,
           'type' => 2,
           'amount'=> $request->amount,
           'source_id'=>$to_account->id,
           'note'=>$request->note
        ]);


        $to_account_no =Transaction::create([
            'ref_no' => $ref_no,
            'trx_no' => CodeGenerate::TrxId(),
            'user_id' => $to_account->id,
            'type' => 1,
            'amount'=> $request->amount,
            'source_id'=>Auth::user()->id,
            'note'=>$request->note
         ]);

        DB::commit();

            // auth user notification
            $user = User::where('id',Auth::user()->id)->first();
            $title = 'Transfer Money';
            $message = 'Your Money is successfully Transfer.';
            $source_id = Auth::user()->id;
            $source_type = User::class;
            $deep_link = [
                'target'=>'transferDetail',
                'parameter'=>['trx_no' =>  $to_account_no->trx_no]
            ];
            Notification::send($user, new GeneralNotification($title,$message,$source_id, $source_type,$deep_link));

            // source notification
            $from_account = User::where('id',Auth::user()->id)->first();
            $sourceUser = User::where('id',$to_account->id)->first();
            $title = 'Receive Money';
            $message = 'Your have received money '.$request->amount.'MMK from '.$from_account->name;
            $source_id = $to_account->id;
            $source_type = User::class;
            $deep_link = [
                'target'=>'transferDetail',
                'parameter'=>['trx_no' => $from->trx_no]
            ];

            Notification::send($sourceUser, new GeneralNotification($title,$message,$source_id, $source_type,$deep_link));

        return redirect('user/transactionDetail/'.$from->trx_no)->with(['success'=>'Money transfer success']);
       } catch (\Exception $error) {
        DB::rollBack();
        return back()->with(['fail' => 'Something wrong']);
       }

    }

    // transfer hash
    public function transferHash(Request $request){
     $str = $request->to_phone.$request->amount.$request->note;

     $hashValue = hash_hmac('sha256',$str,'2321');

     return response()->json([
        'status' => 'success',
        'data'=> $hashValue
     ]);
    }

    // Receive qr
    public function receiveQr(){
        return view('user.receiveQr');
    }

    // scanQr
    public function scanQr(){
        return view('user.scan');
    }
    // validate for transfer confirm
    private function validateTransfer($request)
    {
        Validator::make($request->all(), [
            'to_phone' => 'required',
            'amount' => 'required',
            'note' => 'required',
        ])->validate();
    }
}
