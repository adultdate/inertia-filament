<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitPersons\Pages;

use App\Filament\Panels\Data\Resources\RatsitPersons\RatsitPersonResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateRatsitPerson extends CreateRecord
{
    protected static string $resource = RatsitPersonResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
