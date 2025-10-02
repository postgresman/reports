<?php

namespace App\Filament\Resources\EventNames\Pages;

use App\Filament\Resources\EventNames\EventNameResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditEventName extends EditRecord
{
    protected static string $resource = EventNameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
