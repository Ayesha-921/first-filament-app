<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use App\Jobs\ProcessProductJob;
use Filament\Notifications\Notification;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
   protected function afterCreate(): void
{
    ProcessProductJob::dispatch($this->record->id)->afterCommit();

     Notification::make()
        ->title('Your request is in queue')
        ->body('Processing started...')
        ->success()
        ->send();
}

//remove default notification
protected function getCreatedNotification(): ?Notification
{
    return null;
}

}
