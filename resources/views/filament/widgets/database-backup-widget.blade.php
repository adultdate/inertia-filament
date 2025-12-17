<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Database Backup & Restore</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Create backups or restore your database
                </p>
            </div>
            <div class="flex gap-2">
                {{ ($this->backupAction)(['size' => 'lg']) }}
                {{ ($this->importAction)(['size' => 'lg']) }}
            </div>
        </div>

        <div class="mt-4 rounded-lg bg-gray-50 p-4 dark:bg-gray-800/50 hidden">
            <div class="flex items-start space-x-3 hidden">
                <x-filament::icon
                    icon="heroicon-o-information-circle"
                    class="h-5 w-5 text-blue-500"
                />
                <div class="text-sm text-gray-600 dark:text-gray-400 hidden">
                    <p class="font-medium text-gray-900 dark:text-gray-100">Backup Information</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        <li>Database: <strong>{{ config('database.connections.' . config('database.default') . '.database') }}</strong></li>
                        <li>Connection: <strong>{{ config('database.default') }}</strong></li>
                        <li>Backups are saved to: <code class="rounded bg-gray-200 px-1 dark:bg-gray-700">storage/app/backups/</code></li>
                        <li class="text-orange-600 dark:text-orange-400">⚠️ Importing will replace ALL current data</li>
                    </ul>
                </div>
            </div>
        </div>
    </x-filament::section>

    <x-filament-actions::modals />
</x-filament-widgets::widget>
