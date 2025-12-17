<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\EniroDatas\Pages;

use App\Filament\Panels\Data\Resources\EniroDatas\EniroDatasResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateEniroData extends CreateRecord
{
    protected static string $resource = EniroDatasResource::class;
}
