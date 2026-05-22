<?php

namespace App\Notifications;

use App\Models\OcrTask;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OcrTaskCompleted extends Notification
{
    use Queueable;

    public function __construct(public OcrTask $task)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $url = url('/admin/ocr-tasks/' . $this->task->getRouteKey());

        return [
            'title'   => 'Your task has been processed successfully.',
            'body'    => "OCR for \"{$this->task->title}\" is ready.",
            'task_id' => $this->task->getKey(),
            'url'     => $url,
            'icon'    => 'heroicon-o-check-circle',
            'color'   => 'success',
        ];
    }
}
