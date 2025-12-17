<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\HittaDatas\Pages;

use App\Filament\Panels\Data\Resources\HittaDatas\HittaDataResource;
use Filament\Resources\Pages\EditRecord;

final class EditHittaData extends EditRecord
{
    protected static string $resource = HittaDataResource::class;
}
