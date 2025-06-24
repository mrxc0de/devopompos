<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class MeetingScheduled extends Mailable implements ShouldQueue
{
    public $meeting;

    public function __construct($meeting)
    {
        $this->meeting = $meeting;
    }

    public function build()
    {
        return $this->subject('New Meeting Scheduled')
            ->view('emails.meeting_scheduled')
            ->with(['meeting' => $this->meeting]);
    }
}
