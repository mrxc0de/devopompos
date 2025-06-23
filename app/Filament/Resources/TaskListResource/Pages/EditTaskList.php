<?php

namespace App\Filament\Resources\TaskListResource\Pages;

use App\Filament\Resources\TaskListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaskList extends EditRecord
{
    protected static string $resource = TaskListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
