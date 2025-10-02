<?php

namespace App\Filament\Resources\EventNames;

use App\Filament\Resources\EventNames\Pages\CreateEventName;
use App\Filament\Resources\EventNames\Pages\EditEventName;
use App\Filament\Resources\EventNames\Pages\ListEventNames;
use App\Filament\Resources\EventNames\Schemas\EventNameForm;
use App\Filament\Resources\EventNames\Tables\EventNamesTable;
use App\Models\EventName;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventNameResource extends Resource
{
    protected static ?string $model = EventName::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Events';

    public static function form(Schema $schema): Schema
    {
        return EventNameForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventNamesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventNames::route('/'),
            'create' => CreateEventName::route('/create'),
            'edit' => EditEventName::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
