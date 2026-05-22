<?php

namespace App\Jobs;

use App\Models\OcrTask;
use App\Models\User;
use App\Notifications\OcrTaskCompleted;
use Filament\Actions\Action as FilamentAction;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessOcrJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(public int $taskId)
    {
    }

    public function handle(): void
    {
        $task = OcrTask::find($this->taskId);

        if (! $task) {
            Log::error("OcrTask {$this->taskId} not found");
            return;
        }

        $task->update(['status' => 'processing']);

        $absolutePath = Storage::disk('public')->path($task->image_path);

        if (! is_file($absolutePath)) {
            $this->fail($task, 'Uploaded image file not found on disk.');
            return;
        }

        $baseUrl  = rtrim((string) config('services.flask_ocr.base_url'), '/');
        $endpoint = '/' . ltrim((string) config('services.flask_ocr.endpoint'), '/');
        $apiKey   = (string) config('services.flask_ocr.api_key');
        $timeout  = (int) config('services.flask_ocr.timeout', 60);

        try {
            $response = Http::timeout($timeout)
                ->withHeaders([
                    'X-API-KEY' => $apiKey,
                    'Accept'    => 'application/json',
                ])
                ->attach(
                    'image',
                    file_get_contents($absolutePath),
                    basename($absolutePath)
                )
                ->post($baseUrl . $endpoint, [
                    'title' => $task->title,
                    'mode'  => (string) config('services.flask_ocr.mode', 'formatted'),
                ]);

            if (! $response->successful()) {
                $this->fail($task, 'Flask API error: HTTP ' . $response->status() . ' ' . $response->body());
                return;
            }

            $payload = $response->json();
            $extracted = $payload['text']
                ?? $payload['extracted_text']
                ?? $payload['result']
                ?? (is_string($payload) ? $payload : json_encode($payload));

            $task->update([
                'extracted_text' => $extracted,
                'status'         => 'completed',
                'processed_at'   => now(),
                'error'          => null,
            ]);
        } catch (RequestException|\Throwable $e) {
            $this->fail($task, $e->getMessage());
            return;
        }

        $this->notifyUser($task);
    }

    protected function fail(OcrTask $task, string $message): void
    {
        Log::error("OCR task {$task->id} failed: {$message}");

        $task->update([
            'status' => 'failed',
            'error'  => $message,
        ]);

        $user = $task->user ?? User::first();
        if ($user) {
            FilamentNotification::make()
                ->title('OCR task failed')
                ->body("\"{$task->title}\" could not be processed.")
                ->danger()
                ->actions([
                    FilamentAction::make('view')
                        ->label('View task')
                        ->url(url('/admin/ocr-tasks/' . $task->getKey()))
                        ->markAsRead(),
                ])
                ->sendToDatabase($user);
        }
    }

    protected function notifyUser(OcrTask $task): void
    {
        $user = $task->user ?? User::first();
        if (! $user) {
            return;
        }

        // Send a Laravel database notification (custom payload).
        $user->notify(new OcrTaskCompleted($task));

        // Also push a Filament-styled bell notification with a clickable action.
        FilamentNotification::make()
            ->title('Your task has been completed')
            ->body("OCR for \"{$task->title}\" is ready to view.")
            ->success()
            ->icon('heroicon-o-check-circle')
            ->actions([
                FilamentAction::make('view')
                    ->label('View result')
                    ->url(url('/admin/ocr-tasks/' . $task->getKey()))
                    ->markAsRead(),
            ])
            ->sendToDatabase($user);
    }
}
