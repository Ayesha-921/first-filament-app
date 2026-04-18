<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderEmailJob implements ShouldQueue
{
    use Dispatchable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        Mail::to($this->order->email)
            ->send(new OrderConfirmationMail($this->order));

        // mark email as sent
        $this->order->update([
            'email_sent' => true
        ]);
    }
}