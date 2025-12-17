<?php

declare(strict_types=1);

namespace App\Filament\Resources\Teams\Widgets;

use Filament\Widgets\ChartWidget;

final class EventCalendar extends ChartWidget
{
    protected ?string $heading = 'Event Calendar';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
