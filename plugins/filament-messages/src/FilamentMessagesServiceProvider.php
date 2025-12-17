<?php

declare(strict_types=1);

namespace Adultdate\FilamentMessages;

use Adultdate\FilamentMessages\Commands\FilamentMessagesCommand;
use Adultdate\FilamentMessages\Livewire\Messages\Inbox;
use Adultdate\FilamentMessages\Livewire\Messages\Messages;
use Adultdate\FilamentMessages\Livewire\Messages\Search;
use Adultdate\FilamentMessages\Models\Inbox as InboxModel;
use Filament\Support\Assets\Asset;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class FilamentMessagesServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-messages';

    public static string $viewNamespace = 'filament-messages';

    /**
     * Configure the package.
     */
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(self::$name)
            ->hasCommands($this->getCommands())
            ->hasConfigFile()
            ->hasViews(self::$viewNamespace)
            ->hasMigrations($this->getMigrations())
            ->hasTranslations()
            ->hasRoutes('web')
            ->runsMigrations();
    }

    /**
     * Registers the package.
     *
     * This method is called after the package has been registered with the Laravel service container.
     */
    public function packageRegistered(): void
    {
        parent::packageRegistered();
    }

    /**
     * Boots the package after registration.
     *
     * Registers custom icons and Livewire components for the Filament Messages package.
     * This includes components such as 'fm-inbox', 'fm-messages', and 'fm-search'.
     */
    public function packageBooted(): void
    {
        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Livewire Components
        Livewire::component('fm-inbox', Inbox::class);
        Livewire::component('fm-messages', Messages::class);
        Livewire::component('fm-search', Search::class);

        // Publish CSS assets separately for theme integration
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/css' => public_path('vendor/filament-messages/css'),
            ], 'filament-messages-assets');
        }

        // Render a chat icon (outline) next to the global search (near the bell)
        // and register a slide-over modal that displays a compact inbox view.
        FilamentView::registerRenderHook(
            name: 'panels::global-search.after',
            hook: function (): string {
                if (! Auth::check()) {
                    return '';
                }

                $userId = Auth::id();

                // unread conversations count
                $unreadCount = InboxModel::whereJsonContains('user_ids', $userId)
                    ->whereHas('messages', function ($q) use ($userId) {
                        $q->whereJsonDoesntContain('read_by', $userId);
                    })->count();

                // load recent inboxes with the latest message
                $inboxes = InboxModel::whereJsonContains('user_ids', $userId)
                    ->with(['messages' => function ($q) {
                        $q->latest()->limit(1);
                    }])->get()
                    ->sortByDesc(fn ($i) => optional($i->latestMessage())->created_at)
                    ->take(8);

                return Blade::render(<<<'BLADE'
<div class="relative inline-flex items-center">
    <button x-data="{}" @click="$dispatch('open-modal', { id: 'fm-messages-panel' })" class="inline-flex items-center">
        <x-filament::icon
            icon="heroicon-o-chat-bubble-left"
            class="w-5 h-5 text-gray-500"
        />
    </button>
    @if($unreadCount > 0)
        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-medium leading-none text-white bg-danger-600 rounded-full">{{ $unreadCount }}</span>
    @endif
</div>

<x-filament::modal
    id="fm-messages-panel"
    width="lg"
    alignment="right"
    slide-over
    sticky-header
    :heading="__('Messages')"
>
    <div class="p-2">
        <div class="divide-y divide-gray-100">
            @forelse($inboxes as $inbox)
                @php
                    $other = \App\Models\User::whereIn('id', $inbox->user_ids)->where('id', '!=', $userId)->first();
                    $latest = $inbox->latestMessage();
                @endphp

                <a href="{{ url(config('filament.path', '/admin') . '/' . trim(config('filament-messages.slug', 'messages'), '/') . '/' . $inbox->id) }}" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded">
                    <div class="flex-shrink-0">
                        @if(optional($other)->profile_photo_path)
                            <img src="{{ optional($other)->profile_photo_url }}" class="w-10 h-10 rounded-full" alt="{{ optional($other)->name }}">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-sm text-gray-600">{{ optional($other)->name ? str(substr(optional($other)->name,0,1))->upper() : '?' }}</div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-medium text-gray-900 truncate">{{ optional($other)->name ?? $inbox->title }}</div>
                            <div class="text-xs text-gray-400">{{ optional($latest)->created_at?->diffForHumans() }}</div>
                        </div>
                        <div class="text-sm text-gray-500 truncate">{{ \Illuminate\Support\Str::limit(optional($latest)->message ?? '', 80) }}</div>
                    </div>
                </a>
            @empty
                <div class="p-4 text-sm text-gray-500">{{ __('No conversations yet') }}</div>
            @endforelse
        </div>
    </div>

</x-filament::modal>
BLADE
                    , ['inboxes' => $inboxes, 'unreadCount' => $unreadCount, 'userId' => $userId]);
            }
        );
    }

    /**
     * The name of the package that contains the assets for the Filament Messages package.
     * Returns 'jeddsaliba/filament-messages'.
     */
    protected function getAssetPackageName(): ?string
    {
        return 'jeddsaliba/filament-messages';
    }

    /**
     * The assets that the Filament Messages package registers to the Filament application.
     * This function should return an array of Asset instances that the package registers.
     * If there are no assets to be registered, return an empty array.
     *
     * @return array<Asset> The array of Asset instances.
     */
    protected function getAssets(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the artisan commands for the Filament Messages package.
     *
     * This function should return an array of artisan command classes that the package registers.
     * If there are no commands to be registered, return an empty array.
     *
     * @return array<class-string<\Illuminate\Console\Command>> The array of command classes.
     */
    protected function getCommands(): array
    {
        return [
            FilamentMessagesCommand::class,
        ];
    }

    /**
     * @return array<string, string> A key-value array of [icon_name => icon_path] where the path is relative to the package's resources/icons directory.
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * Get the routes for the Filament Messages package.
     *
     * This function should return an array of routes that the package registers.
     * If there are no routes to be registered, return an empty array.
     *
     * @return array<string> The array of route definitions.
     */
    protected function getRoutes(): array
    {
        return [
            'web',
        ];
    }

    /**
     * Gets the script data to be passed to the JavaScript application.
     *
     * If your package has JavaScript components that need to access data from the server,
     * you can add key-value pairs to this array. The values will be passed to the JavaScript
     * application as a global variable named after the package.
     *
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * Get the list of migration filenames for the Filament Messages package.
     *
     * @return array<string> The array of migration filenames.
     */
    protected function getMigrations(): array
    {
        return [
            'create_fm_inboxes_table',
            'create_fm_messages_table',
        ];
    }
}
