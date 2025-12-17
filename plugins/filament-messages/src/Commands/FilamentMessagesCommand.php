<?php

declare(strict_types=1);

namespace Adultdate\FilamentMessages\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

final class FilamentMessagesCommand extends Command
{
    public $signature = 'filament-messages:install';

    public $description = 'Install the Filament Messages plugin';

    /**
     * Handle the command.
     */
    public function handle(): int
    {
        $this->info('Starting Filament Messages installation...');
        $this->publishAssets();
        $this->runMigrations();
        $this->comment('All done');

        return self::SUCCESS;
    }

    /**
     * Publishes the assets, such as migrations and config files.
     */
    protected function publishAssets(): void
    {
        $this->info('Publishing assets...');

        // Publish migrations
        Artisan::call('vendor:publish', [
            '--provider' => 'Adultdate\FilamentMessages\FilamentMessagesServiceProvider',
            '--tag' => 'filament-messages-migrations',
        ]);

        // Publish configuration
        Artisan::call('vendor:publish', [
            '--provider' => 'Adultdate\FilamentMessages\FilamentMessagesServiceProvider',
            '--tag' => 'filament-messages-config',
        ]);

        $this->info('Assets published.');
    }

    /**
     * Run the migrations for the package.
     *
     * This runs the normal `migrate` Artisan command, which will run all
     * pending migrations for the package.
     */
    protected function runMigrations(): void
    {
        $this->info('Running migrations...');
        Artisan::call('migrate');
        $this->info('Migrations completed.');
    }
}
