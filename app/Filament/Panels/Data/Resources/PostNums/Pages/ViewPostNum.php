<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\PostNums\Pages;

use App\Filament\Panels\Data\Resources\PostNums\PostNumResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewPostNum extends ViewRecord
{
    protected static string $resource = PostNumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
