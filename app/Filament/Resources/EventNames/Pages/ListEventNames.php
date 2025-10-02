<?php

namespace App\Filament\Resources\EventNames\Pages;

use App\Filament\Resources\EventNames\EventNameResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventNames extends ListRecords
{
    protected static string $resource = EventNameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
