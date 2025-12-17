@php
    use Illuminate\Support\Facades\Schema;
    use Adultdate\FilamentMessages\Filament\Pages\Messages;
    // use Adultdate\FilamentMessages\Enums\MediaCollectionType;
@endphp

@props(['selectedConversation'])
<div wire:poll.visible.{{ $pollInterval }}="loadConversations" style="display: flex; flex-direction: column; background-color: #ffffff; transition: all 0.3s; height: 100%; overflow: hidden; width: 100%; padding: 0.75rem;" class="dark:bg-gray-950">
    {{-- Header --}}
    <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem; flex-shrink: 0;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
          
            @if ($this->unreadCount() > 0)
                <span style="display: inline-flex; align-items: center; border-radius: 9999px; background-color: #dbeafe; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #1e40af;">
                    {{ $this->unreadCount() }}
                </span>
            @endif
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <div style="flex: 1;">
                <input type="text" placeholder="Search conversations..." style="width: 100%; padding: 0.5rem 0.75rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; background-color: #ffffff; color: #111827; font-size: 0.875rem;" class="dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500" />
            </div>
            <div>
                {{ $this->createConversation }}
            </div>
        </div>
    </div>

    <x-filament-actions::modals />

    <livewire:fm-search />

    {{-- Conversations List --}}
    <main style="overflow-y: auto; flex: 1; position: relative; display: flex; flex-direction: column; gap: 0.5rem;">
        @if ($this->conversations->count() > 0)
            <ul style="display: flex; flex-direction: column; gap: 0.5rem; width: 100%;">
                @foreach ($this->conversations as $conversation)
                    <li wire:key="{{ $conversation->id }}">
                        <a wire:navigate
                            href="{{ Messages::getUrl(tenant: filament()->getTenant()) . '/' . $conversation->id }}"
                            style="padding: 0.75rem; display: flex; gap: 0.75rem; border-radius: 0.5rem; transition: colors 0.15s; width: 100%; cursor: pointer; @if ($conversation->id == $selectedConversation?->id) background-color: #f3f4f6; @else background-color: transparent; @endif" class="@if ($conversation->id !== $selectedConversation?->id) hover:bg-gray-100 @endif dark:hover:bg-gray-800 @if ($conversation->id == $selectedConversation?->id) dark:bg-gray-800 @endif">
                            {{-- Avatar --}}
                            <div style="flex-shrink: 0;">
                                @php
                                    $avatar = "https://ui-avatars.com/api/?name=" . urlencode($conversation->inbox_title);
                                @endphp
                                <img src="{{ $avatar }}" alt="{{ $conversation->inbox_title }}" style="width: 3rem; height: 3rem; border-radius: 9999px; object-fit: cover;" />
                            </div>

                            {{-- Conversation Details --}}
                            <aside style="display: flex; flex-direction: column; width: 100%; min-width: 0;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.25rem;">
                                    <h6 style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-weight: 500; color: #111827; font-size: 0.875rem;">
                                        {{ $conversation->inbox_title }}
                                    </h6>
                                    <span style="font-size: 0.75rem; flex-shrink: 0; color: #9ca3af; margin-left: 0.5rem;">
                                        {{ \Carbon\Carbon::parse($conversation->updated_at)->setTimezone(config('filament-messages.timezone', 'app.timezone'))->shortAbsoluteDiffForHumans() }}
                                    </span>
                                </div>

                                {{-- Last Message Preview --}}
                                @if ($conversation->latestMessage())
                                    <p style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 0.875rem; color: #4b5563; display: flex; align-items: center; gap: 0.5rem;">
                                        <span style="font-weight: 500;">
                                            {{ $conversation->latestMessage()->user_id == auth()->id() ? 'You:' : $conversation->latestMessage()->sender->name . ':' }}
                                        </span>
                                        @php
                                            $attachment = $conversation->latestMessage()->attachment;
                                        @endphp
                                        @if ($attachment)
                                            📎 Attachment
                                        @else
                                            {{ $conversation->latestMessage()->message }}
                                        @endif
                                    </p>
                                @endif

                                {{-- Unread Indicator --}}
                                @if ($conversation->latestMessage() && !in_array(auth()->id(), $conversation->latestMessage()->read_by))
                                    <div style="display: flex; margin-top: 0.25rem;">
                                        <span style="display: inline-block; width: 0.5rem; height: 0.5rem; border-radius: 9999px; background-color: #3b82f6;"></span>
                                    </div>
                                @endif
                            </aside>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; padding: 0.75rem;">
                <div style="padding: 0.75rem; margin-bottom: 1rem; background-color: #f3f4f6; border-radius: 9999px;">
                    <svg style="width: 1.5rem; height: 1.5rem; color: #9ca3af;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p style="font-size: 1rem; text-align: center; color: #4b5563;">
                    {{__('No conversations yet')}}
                </p>
            </div>
        @endif
    </main>
</div>
