<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\HittaDatas\Pages;

use App\Filament\Panels\Data\Resources\HittaDatas\HittaDataResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewHittaData extends ViewRecord
{
    protected static string $resource = HittaDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
