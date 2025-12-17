<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitDatas\Pages;

use App\Filament\Panels\Data\Resources\RatsitDatas\RatsitDataResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewRatsitData extends ViewRecord
{
    protected static string $resource = RatsitDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
