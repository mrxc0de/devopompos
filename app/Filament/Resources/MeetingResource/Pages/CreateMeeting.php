<?php

namespace App\Filament\Resources\MeetingResource\Pages;

use App\Filament\Resources\MeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\MeetingScheduled;

class CreateMeeting extends CreateRecord
{
    protected static string $resource = MeetingResource::class;

    protected function afterCreate(): void
    {
        $meeting = $this->record;

        $users = User::all();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new MeetingScheduled($meeting));
        }
    }
}
