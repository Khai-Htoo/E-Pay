<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'deep_link'=>$this->data['deep_link'],
            'created_at'=>$this->created_at->format('j-F-Y H:s:i:a'),
            'read_at'=>$this->read_at // null=unread

        ];
    }
}
