<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\CarryData\Pages;

use App\Filament\Panels\Data\Resources\CarryData\CarryDataResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditCarryData extends EditRecord
{
    protected static string $resource = CarryDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
