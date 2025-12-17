<?php

declare(strict_types=1);

namespace App\Filament\Resources\Sprints\Pages;

use App\Filament\Resources\Sprints\SprintResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateSprint extends CreateRecord
{
    protected static string $resource = SprintResource::class;
}
