<?php

declare(strict_types=1);

namespace App\Filament\Panels\Data\Resources\PostNums\Pages;

use App\Filament\Panels\Data\Resources\PostNums\PostNumResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePostNum extends CreateRecord
{
    protected static string $resource = PostNumResource::class;
}
