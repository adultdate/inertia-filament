<?php

declare(strict_types=1);

namespace App\Filament\App\Pages;

use BackedEnum;
use Filament\Pages\Page;

final class Settings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.app.pages.settings';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
