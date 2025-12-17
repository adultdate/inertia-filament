<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitPersons\Pages;

use App\Filament\Panels\Data\Resources\RatsitPersons\RatsitPersonResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditRatsitPerson extends EditRecord
{
    protected static string $resource = RatsitPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
