<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\CalendarEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

final class CalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = CalendarEvent::class;

    protected static ?int $sort = 1;

    protected static ?string $title = 'calendar';

    protected static string $viewIdentifier = 'calendar-widget';

    protected int|string|array $columnSpan = 'full';

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mountUsing(function ($form, array $arguments) {
                    $form->fill([
                        'start' => $arguments['start'] ?? null,
                        'end' => $arguments['end'] ?? null,
                        'all_day' => $arguments['allDay'] ?? false,
                    ]);
                })
                ->mutateFormDataUsing(function (array $data): array {
                    // Set user_id to current user
                    $data['user_id'] = Auth::user()?->id;

                    return $data;
                }),
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    // Ensure user_id is preserved
                    if (! isset($data['user_id'])) {
                        $data['user_id'] = Auth::user()?->id;
                    }

                    return $data;
                }),
        ];
    }
}
