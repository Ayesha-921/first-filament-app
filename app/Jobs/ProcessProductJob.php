<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessProductJob implements ShouldQueue
{
    use Queueable;

    public $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    public function handle(): void
    {
        $product = Product::find($this->productId);

        if (!$product) {
            \Log::error("Product not found!");
            return;
        }

        sleep(5);

        \Log::info("Processing product: " . $product->name);

    // ✅ SAFE user fetch
    $user = User::first();

    // DATABASE notification bhejo
    Notification::make()
        ->title('Product Processed ✅')
        ->body("Product '{$product->name}' successfully listed.")
        ->success()
        ->sendToDatabase($user);
    }
}