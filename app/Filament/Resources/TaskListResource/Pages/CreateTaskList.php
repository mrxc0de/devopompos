<?php

namespace App\Filament\Resources\TaskListResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use App\Filament\Resources\TaskListResource;
use Spatie\Permission\Models\Role;

class CreateTaskList extends CreateRecord
{
    protected static string $resource = TaskListResource::class;

    // protected function afterCreate(): void
    // {
    //     $task = $this->record;

    //     // Get users
    //     $superAdmins = User::role('super_admin')->get();
    //     $teamLeads = User::role('Team Lead')->get();
    //     $assignedUser = $task->assignee; // related user model via 'assigned_to'

    //     // Notify each group
    //     foreach ($superAdmins as $user) {
    //         $user->notify(new TaskAssignedNotification($task));
    //     }

    //     foreach ($teamLeads as $user) {
    //         $user->notify(new TaskAssignedNotification($task));
    //     }

    //     if ($assignedUser) {
    //         $assignedUser->notify(new TaskAssignedNotification($task));
    //     }
    // }
    protected function afterCreate(): void
    {
        $task = $this->record;

        $superAdmins = Role::where('name', 'super_admin')->exists()
            ? User::role('super_admin')->get()
            : collect();

        $teamLeads = Role::where('name', 'team_lead')->exists()
            ? User::role('team_lead')->get()
            : collect();

        $assignedUser = $task->assignee;

        foreach ($superAdmins as $user) {
            $user->notify(new TaskAssignedNotification($task));
        }

        foreach ($teamLeads as $user) {
            $user->notify(new TaskAssignedNotification($task));
        }

        if ($assignedUser) {
            $assignedUser->notify(new TaskAssignedNotification($task));
        }
    }
}
