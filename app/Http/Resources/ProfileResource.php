<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $notiCount = $this->unreadNotifications->count();
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'account_number' => $this->wallet->account_number,
            'balance' => number_format($this->wallet->amount),
            'image' => asset('img/man.png'),
            'qr' => $this->phone,
            'noti_count' => $notiCount,
        ];
    }
}
