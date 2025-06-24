<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\TaskList;
use Carbon\Carbon;

class TaskAssignedNotification extends Notification
{
    public function __construct(public TaskList $task) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = $this->task?->id
            ? url('/into/task-lists/' . $this->task->id . '/edit')
            : url('/into');

        return (new MailMessage)
            ->subject('New Task Assigned: ' . $this->task->title)
            ->line('A new task has been created and assigned.')
            ->line('Title: ' . $this->task->title)
            ->line('Description: ' . strip_tags($this->task->description))
            ->line('Due Date: ' . ($this->task->due_date ? Carbon::parse($this->task->due_date)->toFormattedDateString() : 'Not set'))
            ->action('View Task', $url);
    }
}
