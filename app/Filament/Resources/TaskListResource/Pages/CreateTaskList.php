<?php

namespace App\Filament\Resources\TaskListResource\Pages;

use App\Filament\Resources\TaskListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTaskList extends CreateRecord
{
    protected static string $resource = TaskListResource::class;
}
