<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\HittaSes\Pages;

use App\Filament\Panels\Data\Resources\HittaSes\HittaSeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListHittaSes extends ListRecords
{
    protected static string $resource = HittaSeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
