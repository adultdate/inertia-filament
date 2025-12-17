<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\UpplysningDatas\Pages;

use App\Filament\Panels\Data\Resources\UpplysningDatas\UpplysningDatasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListUpplysningDatas extends ListRecords
{
    protected static string $resource = UpplysningDatasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
