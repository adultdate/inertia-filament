<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitStreets\Pages;

use App\Filament\Panels\Data\Resources\RatsitStreets\RatsitStreetResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewRatsitStreet extends ViewRecord
{
    protected static string $resource = RatsitStreetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
