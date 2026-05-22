<?php

namespace App\Filament\Resources\OcrTaskResource\Pages;

use App\Filament\Resources\OcrTaskResource;
use App\Jobs\ProcessOcrJob;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewOcrTask extends ViewRecord
{
    protected static string $resource = OcrTaskResource::class;

    protected string $view = 'filament.resources.ocr-task-resource.pages.task-show';

    protected function getViewData(): array
    {
        return [
            'record' => $this->record,
        ];
    }

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return $this->record->title;
    }

    public function getHeading(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return '';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reprocess')
                ->label('Re-process')
                ->icon('heroicon-o-arrow-path')
                ->visible(fn () => in_array($this->record->status, ['failed', 'completed']))
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update([
                        'status' => 'queued',
                        'error'  => null,
                    ]);
                    ProcessOcrJob::dispatch($this->record->id);

                    Notification::make()
                        ->title('Your task is in queue')
                        ->body('OCR re-processing has been queued.')
                        ->info()
                        ->send();

                    $this->redirect(static::getResource()::getUrl('view', ['record' => $this->record]));
                }),

            DeleteAction::make()
                ->record($this->record)
                ->successRedirectUrl(static::getResource()::getUrl('index')),
        ];
    }
}
