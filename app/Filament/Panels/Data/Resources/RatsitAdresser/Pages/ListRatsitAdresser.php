<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitAdresser\Pages;

use App\Filament\Panels\Data\Resources\RatsitAdresser\RatsitAdressResource;
use Filament\Resources\Pages\ListRecords;

final class ListRatsitAdresser extends ListRecords
{
    protected static string $resource = RatsitAdressResource::class;
}
