<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\RatsitDatas\Pages;

use App\Filament\Panels\Data\Resources\RatsitDatas\RatsitDataResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateRatsitData extends CreateRecord
{
    protected static string $resource = RatsitDataResource::class;
}
