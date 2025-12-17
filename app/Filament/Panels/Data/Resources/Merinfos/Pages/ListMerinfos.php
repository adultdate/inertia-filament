<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\Merinfos\Pages;

use App\Filament\Panels\Data\Resources\Merinfos\MerinfoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListMerinfos extends ListRecords
{
    protected static string $resource = MerinfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
