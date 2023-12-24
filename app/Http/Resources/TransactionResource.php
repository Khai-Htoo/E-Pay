<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $title = '';
        if($this->type === 1){
            $title = 'from '.$this->source->name;
        }
        if($this->type === 2){
            $title = 'to ' .$this->source->name;
        }
        return [
          'trx_no' =>$this->trx_no,
          'amount'=>number_format($this->amount,2),
          'type'=>$this->type, //1=>income,2=>expense
          'title'=> $title,
          'created_at'=>$this->created_at->format('j-F-Y h:s:i:a')
        ];
    }
}
