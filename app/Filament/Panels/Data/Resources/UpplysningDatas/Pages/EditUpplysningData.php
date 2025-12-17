<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\UpplysningDatas\Pages;

use App\Filament\Panels\Data\Resources\UpplysningDatas\UpplysningDatasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditUpplysningData extends EditRecord
{
    protected static string $resource = UpplysningDatasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
