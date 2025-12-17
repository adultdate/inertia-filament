<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitDatas\Pages;

use App\Filament\Panels\Data\Resources\RatsitDatas\RatsitDataResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditRatsitData extends EditRecord
{
    protected static string $resource = RatsitDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
