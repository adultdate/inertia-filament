<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitKommuner\Pages;

use App\Filament\Panels\Data\Resources\RatsitKommuner\RatsitKommunResource;
use Filament\Resources\Pages\ListRecords;

final class ListRatsitKommuner extends ListRecords
{
    protected static string $resource = RatsitKommunResource::class;
}
