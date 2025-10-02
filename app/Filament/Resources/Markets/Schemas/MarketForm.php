<?php

namespace App\Filament\Resources\Markets\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MarketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('domain'),
                TextInput::make('path'),
                TextInput::make('time_zone_id')
                    ->numeric(),
                DateTimePicker::make('latest_unavailability'),
            ]);
    }
}
