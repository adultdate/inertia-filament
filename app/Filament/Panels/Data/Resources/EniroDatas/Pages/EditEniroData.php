<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\EniroDatas\Pages;

use App\Filament\Panels\Data\Resources\EniroDatas\EniroDatasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditEniroData extends EditRecord
{
    protected static string $resource = EniroDatasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
