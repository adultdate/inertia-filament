<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\PostNums\Pages;

use App\Filament\Panels\Data\Resources\PostNums\PostNumResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditPostNum extends EditRecord
{
    protected static string $resource = PostNumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
