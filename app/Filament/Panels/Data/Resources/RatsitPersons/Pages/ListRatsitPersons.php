<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitPersons\Pages;

use App\Filament\Panels\Data\Resources\RatsitPersons\RatsitPersonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListRatsitPersons extends ListRecords
{
    protected static string $resource = RatsitPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
