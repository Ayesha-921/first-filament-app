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


// Linux cron to run every minute to check how much customer orders are completed:
// * * * * * cd /path/to/project && php artisan tinker --execute="echo App\Models\Order::where('status', 'completed')->count();"

// Linux cron to run every minute to check how much customer orders are pending:
// * * * * * cd /path/to/project && php artisan tinker --execute="echo App\Models\Order::where('status', 'pending')->count();"

// linux cron to run every minute to send order emails
// * * * * * cd /path/to/project && php artisan queue:work --queue=send-order-email

// linux cron to run every minute to check if there are any pending order emails
// * * * * * cd /path/to/project && php artisan tinker --execute="echo App\Models\Order::where('email_sent', false)->count();"

// linux cron to run every minute to check if there are any pending order emails that are older than 1 hour
// * * * * * cd /path/to/project && php artisan tinker --execute="echo App\Models\Order::where('email_sent', false)->where('created_at', '<', now()->subHour())->count();"

// linux cron to run every minute to check how many customer added products to cart
// * * * * * cd /path/to/project && php artisan tinker --execute="echo App\Models\Order::where('status', 'pending')->count();"

// Linux cron to run every minute to check how much customer orders are cancelled:
// * * * * * cd /path/to/project && php artisan tinker --execute="echo App\Models\Order::where('status', 'cancelled')->count();"
