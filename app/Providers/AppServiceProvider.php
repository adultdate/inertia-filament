<?php

declare(strict_types=1);

namespace App\Providers;

use BezhanSalleh\LanguageSwitch\Enums\Placement;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use BezhanSalleh\PanelSwitch\PanelSwitch;
// PLUGINS
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->bootModelsDefaults();
        $this->bootPasswordDefaults();

        PanelSwitch::configureUsing(function (PanelSwitch $switch): void {
            $switch
                ->labels([
                    'admin' => 'Admin',
                    'app' => 'App',
                ])
                ->icons([
                    'admin' => 'heroicon-o-shield-check',
                    'app' => 'heroicon-o-cloud',
                ])
                ->iconSize(20)
                ->renderHook('panels::global-search.after');
            //  ->sort('asc');
        });  

            PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
                $user = Auth::user();
                $panels = ['admin', 'app'];
                if ($user instanceof User && $user->hasRole('super_admin')) {
                    $panels = ['app', 'admin'];
                }
                $panelSwitch->panels($panels);
            });

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch): void {
            $switch
                ->locales(['sv', 'en', 'th'])
                ->displayLocale('sv')
                ->labels([
                    'sv' => 'Svenska',
                    'en' => 'English',
                    'th' => 'ไทย',
                ])
                ->flags([
                    'sv' => asset('flags/se.svg'),
                    'en' => asset('flags/us.svg'),
                    'th' => asset('flags/th.svg'),
                ])
                ->excludes([
                    'admin/login',
                ])

            //  ->visible(outsidePanels: true)
            // ->circular()
                ->visible(true, true)
                ->outsidePanelPlacement(Placement::TopRight)
                ->renderHook('panels::global-search.before');
        });

    }

    private function bootModelsDefaults(): void
    {
        Model::unguard();
    }

    private function bootPasswordDefaults(): void
    {
        Password::defaults(fn () => app()->isLocal() || app()->runningUnitTests() ? Password::min(12)->max(255) : Password::min(12)->max(255)->uncompromised());
    }
}
