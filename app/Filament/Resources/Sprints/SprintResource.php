<?php

declare(strict_types=1);

namespace App\Filament\Resources\Sprints;

use App\Filament\Resources\Sprints\Pages\CreateSprint;
use App\Filament\Resources\Sprints\Pages\EditSprint;
use App\Filament\Resources\Sprints\Pages\ListSprints;
use App\Filament\Resources\Sprints\Schemas\SprintForm;
use App\Filament\Resources\Sprints\Schemas\SprintInfolist;
use App\Filament\Resources\Sprints\Tables\SprintsTable;
use App\Models\Sprint;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

final class SprintResource extends Resource
{
    protected static ?string $model = Sprint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Planning';

    public static function form(Schema $schema): Schema
    {
        return SprintForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SprintInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SprintsTable::configure($table);
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
            'index' => ListSprints::route('/'),
            'create' => CreateSprint::route('/create'),
            'edit' => EditSprint::route('/{record}/edit'),
        ];
    }
}
