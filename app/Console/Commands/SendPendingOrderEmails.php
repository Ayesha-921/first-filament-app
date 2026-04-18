<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Jobs\SendOrderEmailJob;

class SendPendingOrderEmails extends Command
{
    protected $signature = 'orders:send-emails';
    protected $description = 'Send emails to customers for pending orders';

    public function handle()
    {
        $orders = Order::where('email_sent', false)->get();

        foreach ($orders as $order) {
            SendOrderEmailJob::dispatch($order);

            $this->info("Job dispatched for Order ID: " . $order->id);
        }

        return Command::SUCCESS;
    }
}