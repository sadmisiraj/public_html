<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'support_ticket_id' => $this->support_ticket_id,
            'admin_id' => $this->admin_id,
            'message' => $this->message,
            'created_at' => dateTime($this->created_at),
            'attachment' => $this->attachments?TicketAttachmentResource::collection($this->attachments):[]
        ];
    }
}
