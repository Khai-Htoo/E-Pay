<?php
namespace App\Helper;

use App\Models\Transaction;
use App\Models\wallet;

class CodeGenerate {
    public static function accountNumber(){
        $number = mt_rand(1000000000000000,9999999999999999);
        if(wallet::where('account_number',$number)->exists()){
            self::accountNumber();
        }
        return $number;
    }

    public static function refNumber(){
        $number = mt_rand(1000000000000000,9999999999999999);
        if(Transaction::where('ref_no',$number)->exists()){
            self::accountNumber();
        }
        return $number;
    }

    public static function TrxId(){
        $number = mt_rand(1000000000000000,9999999999999999);
        if(Transaction::where('trx_no',$number)->exists()){
            self::accountNumber();
        }
        return $number;
    }
}

?>
