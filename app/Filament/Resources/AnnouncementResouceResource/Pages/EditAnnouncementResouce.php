<?php

namespace App\Filament\Resources\AnnouncementResouceResource\Pages;

use App\Filament\Resources\AnnouncementResouceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnnouncementResouce extends EditRecord
{
    protected static string $resource = AnnouncementResouceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
