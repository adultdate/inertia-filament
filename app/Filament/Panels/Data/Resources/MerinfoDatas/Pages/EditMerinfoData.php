<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\MerinfoDatas\Pages;

use App\Filament\Panels\Data\Resources\MerinfoDatas\MerinfoDataResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditMerinfoData extends EditRecord
{
    protected static string $resource = MerinfoDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
