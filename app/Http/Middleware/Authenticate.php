<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Filament\Facades\Filament;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

final class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     */
    protected function redirectTo($request): ?string
    {
        // Try to get the current panel from the request
        $panel = Filament::getCurrentPanel();

        if ($panel) {
            return $panel->getLoginUrl();
        }

        // Fallback: try to get the admin panel login URL
        $adminPanel = Filament::getPanel('admin');
        if ($adminPanel) {
            return $adminPanel->getLoginUrl();
        }

        // Final fallback
        return Filament::getLoginUrl();
    }
}
