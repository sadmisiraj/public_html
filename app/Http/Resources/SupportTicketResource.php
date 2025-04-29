<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->status == 0) {
            $status = trans('Open');
        } elseif ($this->status == 1) {
            $status = trans('Answered');
        } elseif ($this->status == 2) {
            $status = trans('Replied');
        } elseif ($this->status == 3) {
            $status = trans('Closed');
        }
        return [
            'id' => $this->id,
            'ticket' => $this->ticket,
            'subject' => $this->subject,
            'last_reply' => $this->last_reply,
            'status' => $this->status,
            'messages' => $this->messages?SupportTicketMessageResource::collection($this->messages):[],
            'user' => $this->user?new UserResource($this->user):[]
        ];
    }
}
