<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Transaction;
use App\Helper\CodeGenerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Validator;
use App\Notifications\GeneralNotification;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\TransactionDetailResource;
use App\Http\Resources\NotificationResourceDetail;

class PageController extends Controller
{
    //profile
    public function profile()
    {
        $user = Auth::user();

        $data = new ProfileResource($user);

        return success('success', $data);
    }

    // transaction
    public function transaction(Request $request)
    {
        $user = Transaction::where('user_id', Auth::user()->id);
        if($request->date){
            $user = $user->whereDate('created_at',$request->date);
        }
        if($request->type){
            $user = $user->where('type',$request->type);
        }
        $user=$user->get();

        $data = TransactionResource::collection($user);
        return success('success', $data);
    }

    // transactionDetail
    public function transactionDetail($trx_no)
    {
        $detail = Transaction::where('user_id',Auth::user()->id)->where('trx_no', $trx_no)->first();
        $data = new TransactionDetailResource($detail);
        return success('success', $data);
    }

    // notification
    public function notification(){
        $user = User::where('id',Auth::user()->id)->first();
        $notification =$user->notifications;
        // $data = NotificationResource::collection($notification);
        // return success('success',$data);
        return $notification;
    }

    // notification detail
    public function notificationDetail($id){
        $user = User::where('id',Auth::user()->id)->first();
        $notification =$user->notifications;
        $notificationDetail = $notification->where('id',$id)->first();
        $notification->markAsRead();
        return  $data = new NotificationResourceDetail( $notificationDetail);
        return success('success',$data);
    }

    // verifyPhone
    public function verifyPhone(Request $request){
        if($request->to_phone){
            if(Auth::user()->phone != $request->to_phone){
                $account = User::where('phone',$request->to_phone)->first();
                return  success('success',[
                    "to_name" => $account->name,
                    "to_phone"=> $account->phone
                ]);
            }
            return fail('Invalid Data',null);
        }
    }

    // transferConfirm
    public function transferConfirm(Request $request){
        $this->validateTransfer($request);
        $hashValue = $request->hashValue;
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $note = $request->note;
        $checkPhone = User::where('phone', $to_phone)->first();
        if (!$checkPhone) {
            return fail('Invalid phone number!',null);
        }
        if (Auth::user()->wallet->amount < $request->amount) {
            return fail('Insufficient balance!',null);
        }
        return success('success',[
           'to_phone'=>$to_phone,
           'amount'=>$amount,
           'note'=>$note,
           'hash_value' =>$hashValue
        ]);
    }

    // complete
    public function complete(Request $request){

        if (!Hash::check($request->password, Auth::user()->password)) {
            return fail('Your Password incorrect',null);
         }

        $from_account_wallet = Auth::user()->wallet;
        $to_account = User::where('phone',$request->to_phone)->first();
        $to_account_wallet = $to_account->wallet;


        $str = $request->to_phone.$request->amount.$request->note;
        $hashValue = hash_hmac('sha256',$str,'2321');


       if(!$from_account_wallet || !$to_account_wallet){
        return fail('Account not found',null);
       }

       if($request->hashValue != $hashValue){
        return fail('Your data is invalid',null);
       }

       if($from_account_wallet->amount < $request->amount){
        return fail('Insufficient balance',null);
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

        return fail('Money transfer success',['trx_no'=>$from->trx_no]);

       } catch (\Exception $error) {
        DB::rollBack();
        return fail('Something wrong',null);
       }
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
