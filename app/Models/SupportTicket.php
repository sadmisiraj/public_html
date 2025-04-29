<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ticket', 'subject', 'status', 'last_reply'];

    protected $dates = ['last_reply'];

    public function getUsernameAttribute()
    {
        return $this->name;
    }

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('ticketRecord');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages(){
        return $this->hasMany(SupportTicketMessage::class)->latest();
    }

    public function lastReply(){
        return $this->hasOne(SupportTicketMessage::class)->latest();
    }
    public function  getLastMessageAttribute(){
        return Str::limit($this->lastReply->message,40);
    }

    function getTicketStatusBadge() {
        switch ($this->status) {
            case 0:
                return '<span class="badge bg-primary">' . __('Open') . '</span>';
            case 1:
                return '<span class="badge bg-success">' . __('Answered') . '</span>';
            case 2:
                return '<span class="badge bg-warning">' . __('Replied') . '</span>';
            case 3:
                return '<span class="badge bg-danger">' . __('Closed') . '</span>';
            default:
                return '<span class="badge bg-secondary">' . __('Unknown') . '</span>';
        }
    }

    function getTicketStatusBadgeEstateRise() {
        switch ($this->status) {
            case 0:
                return '<span class="badge  text-bg-primary">' . __('Open') . '</span>';
            case 1:
                return '<span class="badge text-bg-success">' . __('Answered') . '</span>';
            case 2:
                return '<span class="badge text-bg-warning">' . __('Replied') . '</span>';
            case 3:
                return '<span class="badge text-bg-danger">' . __('Closed') . '</span>';
            default:
                return '<span class="badge text-bg-secondary">' . __('Unknown') . '</span>';
        }
    }

    public static function generateTicketNumber()
    {
        $lastOrder = self::orderBy('created_at', 'desc')->first();

        if ($lastOrder && $lastOrder->ticket) {
            $lastOrderNumber = (int)filter_var($lastOrder->ticket, FILTER_SANITIZE_NUMBER_INT);
            $newOrderNumber = $lastOrderNumber + 1;
        } else {
            $newOrderNumber = mt_rand(10000, 999999);
        }

        return $newOrderNumber;
    }
}
