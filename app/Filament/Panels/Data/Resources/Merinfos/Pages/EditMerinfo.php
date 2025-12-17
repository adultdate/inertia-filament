<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\Merinfos\Pages;

use App\Filament\Panels\Data\Resources\Merinfos\MerinfoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditMerinfo extends EditRecord
{
    protected static string $resource = MerinfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
