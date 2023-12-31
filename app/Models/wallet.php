<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','account_number','amount'];

   public function user(){
    return $this->belongsTo(User::class,'user_id','id');
   }
}
