<?php

declare(strict_types=1);

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Sprints\SprintResource;
use App\Filament\Resources\Tasks\TaskResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New task')
                ->icon('heroicon-o-plus'),
            Action::make('planSprint')
                ->label('New sprint')
                ->icon('heroicon-o-flag')
                ->color('primary')
                ->url(SprintResource::getUrl('create')),
        ];
    }
}
