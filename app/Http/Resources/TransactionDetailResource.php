<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $title = '';
        if($this->type === 1){
            $title = 'from'.$this->source->name;
        }
        if($this->type === 2){
            $title = 'to' .$this->source->name;
        }

        return [
            'trx_no'=>$this->trx_no,
            'Ref_Number' => $this->ref_no,
            'type'=>$this->type,
            'date'=>$this->created_at->format('j-F-Y H:s:i:a'),
            'title'=> $title,
            'note'=>$this->note
        ];
    }
}
