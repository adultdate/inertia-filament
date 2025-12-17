@php
    use Illuminate\Support\Facades\Schema;
    // use Adultdate\FilamentMessages\Enums\MediaCollectionType;
@endphp
@props(['selectedConversation'])
<!-- Right Section (Chat Box) -->
<div class="relative flex flex-col w-full h-full bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white overflow-hidden">
    <div class="pointer-events-none absolute -left-32 top-10 h-64 w-64 rounded-full bg-primary-500/20 blur-3xl"></div>
    <div class="pointer-events-none absolute right-0 -bottom-24 h-72 w-72 rounded-full bg-cyan-400/15 blur-3xl"></div>

    @if ($selectedConversation)
        {{-- Chat Header --}}
        <div class="flex items-center justify-between px-6 py-4 gap-4 border-b border-white/5 bg-white/10 backdrop-blur-sm shadow-lg shadow-black/20">
            <div class="flex items-center gap-3">
                @php
                    $avatar = "https://ui-avatars.com/api/?name=" . urlencode($selectedConversation->inbox_title);
                @endphp
                <img src="{{ $avatar }}" alt="{{ $selectedConversation->inbox_title }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-white/10" />
                <div>
                    <h2 class="text-lg font-semibold text-white">{{ $selectedConversation->inbox_title }}</h2>
                    <div class="flex items-center gap-2 text-xs text-white/70">
                        <span class="inline-block h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Active now</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm text-white/70">
                <div class="px-3 py-1 rounded-full bg-white/10 border border-white/10">Secure chat</div>
            </div>
        </div>

        {{-- Chat Messages Area --}}
        <main wire:poll.visible.{{ $pollInterval }}="pollMessages" id="chatContainer" class="flex flex-col gap-6 px-4 sm:px-6 lg:px-8 py-6 overflow-y-auto flex-1">
            <div class="mx-auto w-full max-w-4xl flex flex-col gap-6 bg-white/5 border border-white/10 rounded-3xl px-4 sm:px-6 lg:px-8 py-6 shadow-[0_20px_60px_-25px_rgba(0,0,0,0.45)] backdrop-blur">
            @php
                $orderedMessages = $conversationMessages->sortBy('created_at')->values();
                $previousDate = null;
            @endphp
            @foreach ($orderedMessages as $index => $message)
                @php
                    $currentMessageDate = \Carbon\Carbon::parse($message->created_at)
                        ->setTimezone(config('filament-messages.timezone', 'app.timezone'))
                        ->format('Y-m-d');
                @endphp

                @if ($previousDate !== $currentMessageDate)
                    <div class="flex justify-center">
                        <span class="text-xs text-white/80 bg-white/10 border border-white/10 px-3 py-1 rounded-full">
                            {{ \Carbon\Carbon::parse($message->created_at)->setTimezone(config('filament-messages.timezone', 'app.timezone'))->format('F j, Y') }}
                        </span>
                    </div>
                @endif

                <div wire:key="{{ $message->id }}" class="flex gap-3 @if ($message->user_id === auth()->id()) justify-end @else justify-start @endif">
                    {{-- Avatar for other users (group chats only) --}}
                    @if ($message->user_id !== auth()->id())
                        <div class="flex-shrink-0">
                            @php
                                $avatar = "https://ui-avatars.com/api/?name=" . urlencode($message->sender->name);
                            @endphp
                            <img src="{{ $avatar }}" alt="{{ $message->sender->name }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-white/10" />
                        </div>
                    @endif

                    {{-- Message Container --}}
                    <div class="max-w-[70%] flex flex-col @if ($message->user_id === auth()->id()) items-end @else items-start @endif gap-1">
                        {{-- Sender Name (group chats) --}}
                        @if ($message->user_id !== auth()->id())
                            <p class="text-xs font-semibold text-white/70">{{ $message->sender->name }}</p>
                        @endif

                        {{-- Message Bubble --}}
                        <div class="px-4 py-3 rounded-2xl shadow-lg shadow-black/20 break-words @if ($message->user_id === auth()->id()) bg-gradient-to-br from-sky-500 to-blue-600 text-white rounded-br-md @else bg-white/10 text-white rounded-bl-md border border-white/10 @endif">
                            @if ($message->message)
                                <p class="text-sm leading-relaxed whitespace-pre-line">{!! nl2br(e($message->message)) !!}</p>
                            @endif

                            {{-- File Attachment --}}
                            @if ($message->attachment_id)
                                <div class="mt-3 flex flex-col gap-2">
                                    @php
                                        $filePath = $message->attachment_id;
                                        $fileName = basename($filePath);
                                        
                                        // Try to determine mime type
                                        $mimeType = null;
                                        try {
                                            if (\Illuminate\Support\Facades\Storage::disk('local')->exists($filePath)) {
                                                $mimeType = \Illuminate\Support\Facades\Storage::disk('local')->mimeType($filePath);
                                            }
                                        } catch (\Exception $e) {
                                            // Fallback to generic application/octet-stream
                                        }
                                        $mimeType = $mimeType ?? 'application/octet-stream';
                                        
                                        $icon = '📎';
                                        if (str_starts_with($mimeType, 'image/')) {
                                            $icon = '🖼️';
                                        } elseif (str_starts_with($mimeType, 'video/')) {
                                            $icon = '🎥';
                                        } elseif (str_starts_with($mimeType, 'audio/')) {
                                            $icon = '🔊';
                                        }
                                    @endphp
                                    <a href="{{ route('filament-messages.download-attachment', ['path' => base64_encode($filePath)]) }}" target="_blank" class="flex items-center gap-2 px-3 py-2 rounded-lg border border-white/10 bg-white/10 text-sm transition hover:border-white/30">
                                        <span>{{ $icon }}</span>
                                        <span class="text-xs truncate">{{ $fileName }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Timestamp --}}
                        <p class="text-[11px] text-white/60">
                            @php
                                $createdAt = \Carbon\Carbon::parse($message->created_at)->setTimezone(config('filament-messages.timezone', 'app.timezone'));
                                if ($createdAt->isToday()) {
                                    $date = $createdAt->format('g:i A');
                                } else {
                                    $date = $createdAt->format('M d g:i A');
                                }
                            @endphp
                            {{ $date }}
                        </p>
                    </div>
                </div>

                @php
                    $previousDate = $currentMessageDate;
                @endphp
            @endforeach

            {{-- Load More --}}
            @if ($this->paginator->hasMorePages())
                <div x-intersect="$wire.loadMessages">
                    <div class="w-full py-6 text-center text-white/60 text-sm">Loading messages...</div>
                </div>
            @endif
            </div>
        </main>

        {{-- Chat Input Form --}}
        <footer class="flex-shrink-0 border-t border-white/10 bg-black/40 backdrop-blur-md">
        @php
            $attachmentsComponent = $this->form->getComponent('attachments');
            $messageComponent = $this->form->getComponent('message');
        @endphp

        <form
            wire:submit.prevent="sendMessage"
            class="px-4 sm:px-6 lg:px-8 py-4 flex flex-col gap-3 w-full"
            x-data="{
                sending: false,
                attaching: false
            }"
        >
            @if ($attachmentsComponent && $attachmentsComponent->isVisible())
                <div class="w-full p-3 rounded-2xl border border-white/10 bg-white/5 shadow-inner shadow-black/10">
                    {{ $attachmentsComponent }}
                </div>
            @endif

            <div class="chat-form flex items-center gap-3 w-full">
                <button
                    type="button"
                    wire:click="toggleUpload"
                    x-on:click="attaching = true; setTimeout(() => attaching = false, 1200)"
                    x-bind:disabled="attaching"
                    class="w-11 h-11 rounded-full bg-white/10 border border-white/20 text-white flex items-center justify-center shadow-lg shadow-black/20 transition hover:border-white/40 disabled:opacity-50 disabled:pointer-events-none"
                    aria-label="Attach file"
                >
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79V7a4 4 0 00-8 0v7a2 2 0 104 0V8" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10v7a6 6 0 0012 0" />
                    </svg>
                </button>

                @if ($messageComponent)
                    <div class="flex-1 min-w-0 w-full">
                        <div class="w-full rounded-full border border-white/10 bg-white/10 px-4 py-2.5 shadow-inner shadow-black/20 focus-within:border-primary-300 flex items-center gap-3" x-ref="messageFieldWrapper">
                            {{ $messageComponent }}
                        </div>
                    </div>
                @endif

                <button
                    type="submit"
                    wire:click.prevent="sendMessage"
                    x-on:click="sending = true; setTimeout(() => sending = false, 1200)"
                    x-bind:disabled="sending"
                    x-bind:class="sending ? 'opacity-50 pointer-events-none' : ''"
                    class="w-11 h-11 rounded-full bg-gradient-to-br from-sky-500 to-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-900/40 transition hover:brightness-110 disabled:opacity-50 disabled:pointer-events-none"
                    aria-label="Send message"
                >
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16.6915026,12.4744748 L3.50612381,13.2599618 C3.19218622,13.2599618 3.03521743,13.4170592 3.03521743,13.5741566 L1.15159189,20.0151496 C0.8376543,20.8006365 0.99,21.89 1.77946707,22.52 C2.41,22.99 3.50612381,23.1 4.13399899,22.8429026 L21.714504,14.0454487 C22.6563168,13.5741566 23.1272231,12.6315722 22.9702544,11.6889879 C22.9702544,11.6889879 22.9702544,11.6889879 22.9702544,11.6889879 L4.13399899,1.16346272 C3.34915502,0.9 2.40734225,1.00636533 1.77946707,1.4776575 C0.994623095,2.10604706 0.837654326,3.0486314 1.15159189,3.99021575 L3.03521743,10.4311088 C3.03521743,10.5882061 3.19218622,10.7453035 3.50612381,10.7453035 L16.6915026,11.5307905 C16.6915026,11.5307905 17.1624089,11.5307905 17.1624089,11.0595983 L17.1624089,12.0021827 C17.1624089,12.4744748 16.6915026,12.4744748 16.6915026,12.4744748 Z" />
                    </svg>
                </button>
            </div>
        </form>
        </footer>
    @else
        <div class="flex flex-col items-center justify-center h-full p-4 text-white">
            <div class="p-4 mb-3 bg-white/10 rounded-full border border-white/10">
                <svg class="w-8 h-8 text-white/70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <p class="text-base text-white/80 text-center">{{__('Select a conversation to start messaging')}}</p>
        </div>
    @endif
</div>

@script
<script>
    $wire.on('chat-box-scroll-to-bottom', () => {
        const chatContainer = document.getElementById('chatContainer');
        if (chatContainer) {
            chatContainer.scrollTo({
                top: chatContainer.scrollHeight,
                behavior: 'smooth',
            });
        }
    });

    const scrollChatToBottom = () => {
        const chatContainer = document.getElementById('chatContainer');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    };

    // Initial scroll on load
    window.addEventListener('load', scrollChatToBottom);

    // Scroll after Livewire updates
    if (window.Livewire) {
        Livewire.hook('message.processed', () => {
            scrollChatToBottom();
        });
    }

    // Fallback for Filament textarea autosize helper when not loaded
    if (typeof window.textareaFormComponent === 'undefined') {
        window.textareaFormComponent = (options = {}) => {
            return {
                state: options.state ?? '',
                initialHeight: options.initialHeight ?? 2.25,
                shouldAutosize: options.shouldAutosize ?? true,
                resize() {},
            };
        };
    }
</script>
@endscript