<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;

class EarningsNotification extends Notification
{
    use Queueable;

    public $user;
    public $amount;

    public function __construct($user, $amount)
    {
        $this->user = $user;
        $this->amount = $amount;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Earnings for attendant ' . $this->user->name . ' have been updated.',
            'amount' => $this->amount,
            'user_id' => $this->user->id,
        ];
    }
}
