@php
    $currentPanelLabel = $labels[$currentPanel->getId()] ?? str($currentPanel->getId())->ucfirst();
@endphp

<x-filament::icon-button
    x-data="{}"
    icon="heroicon-s-square-2-stack"
    icon-alias="panels::panel-switch-modern-icon"
    icon-size="lg"
    @click="$dispatch('open-modal', { id: 'panel-switch' })"
    :label="$heading"
    class="fi-topbar-action-button"
/> 

<x-filament::modal
    id="panel-switch"
    width="md"
    alignment="end"
    slide-over
    sticky-header
    :heading="$heading"
    teleport="body"
    display-classes="block"
    class="panel-switch-modal"
>
    <div
        class="flex flex-wrap items-center justify-center gap-4 md:gap-6"
    >
        @foreach ($panels as $id => $url)
            <a
                href="{{ $url }}"
                class="flex flex-col items-center justify-center flex-1 hover:cursor-pointer group panel-switch-card"
            >
                <div
                    @class([
                        'p-2 bg-white rounded-lg shadow-md dark:bg-gray-800 panel-switch-card-section',
                        'group-hover:ring-2 group-hover:ring-primary-600' => $id !== $currentPanel->getId(),
                        'ring-2 ring-primary-600' => $id === $currentPanel->getId(),
                    ])
                >
                    @if ($renderIconAsImage)
                        <img
                            class="rounded-lg panel-switch-card-image w-16 h-16 object-cover"
                            src="{{ $icons[$id] ?? 'https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/3.x/art/banner.jpg' }}"
                            alt="Panel Image"
                        >
                    @else
                        @php
                            $iconName = $icons[$id] ?? 'heroicon-s-square-2-stack';
                        @endphp
                        @svg($iconName, 'text-primary-600 panel-switch-card-icon w-12 h-12')
                    @endif
                </div>
                <span
                    @class([
                        'mt-2 text-sm font-medium text-center text-gray-400 dark:text-gray-200 break-words panel-switch-card-title',
                        'text-gray-400 dark:text-gray-200 group-hover:text-primary-600 group-hover:dark:text-primary-400' => $id !== $currentPanel->getId(),
                        'text-primary-600 dark:text-primary-400' => $id === $currentPanel->getId(),
                    ])
                >
                    {{ $labels[$id] ?? str($id)->ucfirst() }}
                </span>
            </a>
        @endforeach
    </div>
</x-filament::modal>
