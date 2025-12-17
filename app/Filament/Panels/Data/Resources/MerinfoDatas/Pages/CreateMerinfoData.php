<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\MerinfoDatas\Pages;

use App\Filament\Panels\Data\Resources\MerinfoDatas\MerinfoDataResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateMerinfoData extends CreateRecord
{
    protected static string $resource = MerinfoDataResource::class;
}
