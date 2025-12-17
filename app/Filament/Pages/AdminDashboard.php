<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Panel;
use Illuminate\Contracts\Support\Htmlable;

final class AdminDashboard extends BaseDashboard
{
    // A customizable admin dashboard that extends the vendor Dashboard.

    // (Legacy property kept for reference; Filament uses getRoutePath/getSlug.)
    protected static string $routePath = '/dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    // Override or extend widget and content methods here as needed.

    // Force the admin dashboard to register at the root path of the panel (`/`).
    public static function getRoutePath(Panel $panel): string
    {
        return '/';
    }

    // Keep the relative route name as `dashboard` so existing code/links continue
    // to resolve the same named route (filament.{panel}.pages.dashboard).
    public static function getRelativeRouteName(Panel $panel): string
    {
        return 'dashboard';
    }

    public function getTitle(): string|Htmlable
    {
        return self::$title ?? 'Dashboard';
    }
}
