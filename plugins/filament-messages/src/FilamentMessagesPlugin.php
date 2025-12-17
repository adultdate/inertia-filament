<?php

declare(strict_types=1);

namespace Adultdate\FilamentMessages;

use Adultdate\FilamentMessages\Filament\Pages\Messages;
use Filament\Contracts\Plugin;
use Filament\Panel;

final class FilamentMessagesPlugin implements Plugin
{
    /**
     * Resolve the plugin instance from the service container.
     */
    public static function make(): static
    {
        return app(self::class);
    }

    /**
     * Resolve the plugin instance from the Filament container.
     */
    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    /**
     * Get the plugin ID.
     */
    public function getId(): string
    {
        return 'filament-messages';
    }

    /**
     * Register the plugin's pages with the given panel.
     *
     * @param  Panel  $panel  The Filament panel instance to which the plugin's pages should be registered.
     */
    public function register(Panel $panel): void
    {
        $panel->pages([
            Messages::class,
        ]);
    }

    /**
     * Boot the plugin with the given panel.
     *
     * This function is called after all plugins have been registered. It is used to perform
     * any actions required to initialize the plugin within the given Filament panel.
     *
     * @param  Panel  $panel  The Filament panel instance used to boot the plugin.
     */
    public function boot(Panel $panel): void
    {
        //
    }
}
