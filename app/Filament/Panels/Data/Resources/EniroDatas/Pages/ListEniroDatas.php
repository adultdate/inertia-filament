<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\EniroDatas\Pages;

use App\Filament\Panels\Data\Resources\EniroDatas\EniroDatasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListEniroDatas extends ListRecords
{
    protected static string $resource = EniroDatasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
