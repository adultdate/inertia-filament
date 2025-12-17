<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\Merinfos\Pages;

use App\Filament\Panels\Data\Resources\Merinfos\MerinfoResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateMerinfo extends CreateRecord
{
    protected static string $resource = MerinfoResource::class;
}
