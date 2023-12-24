<?php

namespace App\Http\Controllers;

use App\Helper\CodeGenerate;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\wallet;
use App\Notifications\GeneralNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class WalletController extends Controller
{
    // for wallet page
    public function index()
    {
        return view('admin.wallet.index');
    }

    // dataTable
    public function ssd()
    {
        $data = wallet::with('user');
        return DataTables::of($data)
            ->addColumn('account_person', function ($each) {
                $user = $each->user;
                if ($user) {
                    return "<p>Name - '$user->name'</p> <p>Email - '$user->email'</p> <p>Phone - '$user->phone'</p>";
                }
                return '-';
            })
            ->editColumn('amount', function ($each) {
                return number_format($each->amount, 2);
            })
            ->editColumn("created_at", function ($each) {
                return Carbon::parse($each->created_at)->format('j-F-Y');
            })
            ->editColumn("updated_at", function ($each) {
                return Carbon::parse($each->updated_at)->format('j-F-Y');
            })
            ->rawColumns(['account_person'])
            ->make(true);
    }

    // addMoney Page
    public function addMoney()
    {
        $user = User::get();
        return view('admin.wallet.addmoney', compact('user'));
    }

    // add money
    public function addMoneyData(Request $request)
    {
        $this->moneyValidate($request);
        $user = User::where('id', $request->user_id)->first();

        $user->wallet->increment('amount', $request->amount);

        $user->wallet->update();
        $ref_no = CodeGenerate::refNumber();
        $to_account = Transaction::create([
            'ref_no' => $ref_no,
            'trx_no' => CodeGenerate::TrxId(),
            'user_id' => Auth::user()->id,
            'type' => 1,
            'amount' => $request->amount,
            'source_id' => 0,
            'note' => $request->note,
        ]);

        $title = 'Receive Money';
        $message = 'Your have received money ' . $request->amount . 'MMK from ' . Auth::user()->name;
        $source_id = $user->user_id;
        $source_type = User::class;
        $deep_link = [
            'target' => 'transferDetail',
            'parameter' => ['trx_no' => $to_account->trx_no],
        ];

        Notification::send($user, new GeneralNotification($title, $message, $source_id, $source_type, $deep_link));
        return redirect()->route('wallet')->with('success');
    }

    // validate for add money
    private function moneyValidate($request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required',
            'amount' => 'required|min:10000',
            'note' => 'required',
        ])->validate();
    }
}
