<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitStreets\Pages;

use App\Filament\Panels\Data\Resources\RatsitStreets\RatsitStreetResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateRatsitStreet extends CreateRecord
{
    protected static string $resource = RatsitStreetResource::class;
}
