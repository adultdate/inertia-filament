<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitPersons\Pages;

use App\Filament\Panels\Data\Resources\RatsitPersons\RatsitPersonResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewRatsitPerson extends ViewRecord
{
    protected static string $resource = RatsitPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
