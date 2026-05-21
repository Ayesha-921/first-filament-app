<?php

namespace App\Filament\Resources\OcrTaskResource\Pages;

use App\Filament\Resources\OcrTaskResource;
use App\Jobs\ProcessOcrJob;
use App\Models\OcrTask;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateOcrTask extends CreateRecord
{
    protected static string $resource = OcrTaskResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['status']  = 'queued';

        return $data;
    }

    protected function afterCreate(): void
    {
        /** @var OcrTask $task */
        $task = $this->record;

        // Dispatch background job to call the Flask OCR API.
        ProcessOcrJob::dispatch($task->id);

        // Immediate UI feedback on submit.
        Notification::make()
            ->title('Your task is in queue')
            ->body("\"{$task->title}\" has been queued. You'll be notified when it's done.")
            ->info()
            ->icon('heroicon-o-clock')
            ->send();

        // Persistent bell notification.
        if ($user = Auth::user()) {
            Notification::make()
                ->title('Your task is in queue')
                ->body("OCR for \"{$task->title}\" is being processed in the background.")
                ->info()
                ->icon('heroicon-o-clock')
                ->sendToDatabase($user);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
