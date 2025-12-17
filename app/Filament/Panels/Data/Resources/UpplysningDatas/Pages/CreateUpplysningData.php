<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\UpplysningDatas\Pages;

use App\Filament\Panels\Data\Resources\UpplysningDatas\UpplysningDatasResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateUpplysningData extends CreateRecord
{
    protected static string $resource = UpplysningDatasResource::class;
}
