<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitPostorter\Pages;

use App\Filament\Panels\Data\Resources\RatsitPostorter\RatsitPostortResource;
use Filament\Resources\Pages\ListRecords;

final class ListRatsitPostorter extends ListRecords
{
    protected static string $resource = RatsitPostortResource::class;
}
