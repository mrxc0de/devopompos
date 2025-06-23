<?php

namespace App\Filament\Resources\TaskLinkResource\Pages;

use App\Filament\Resources\TaskLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaskLink extends EditRecord
{
    protected static string $resource = TaskLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
