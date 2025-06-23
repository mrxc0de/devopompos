<?php

namespace App\Filament\Resources\TaskLinkResource\Pages;

use App\Filament\Resources\TaskLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaskLinks extends ListRecords
{
    protected static string $resource = TaskLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
