<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\CarryData\Pages;

use App\Filament\Panels\Data\Resources\CarryData\CarryDataResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateCarryData extends CreateRecord
{
    protected static string $resource = CarryDataResource::class;
}
