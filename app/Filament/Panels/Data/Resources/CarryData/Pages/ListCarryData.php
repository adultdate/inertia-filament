<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\CarryData\Pages;

use App\Filament\Panels\Data\Resources\CarryData\CarryDataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListCarryData extends ListRecords
{
    protected static string $resource = CarryDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
