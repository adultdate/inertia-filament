<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitStreets\Pages;

use App\Filament\Panels\Data\Resources\RatsitStreets\RatsitStreetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditRatsitStreet extends EditRecord
{
    protected static string $resource = RatsitStreetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
