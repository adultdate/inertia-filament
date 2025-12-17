<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitStreets\Pages;

use App\Filament\Panels\Data\Resources\RatsitStreets\RatsitStreetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListRatsitStreets extends ListRecords
{
    protected static string $resource = RatsitStreetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
