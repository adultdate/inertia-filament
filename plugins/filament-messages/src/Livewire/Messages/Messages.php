<?php

declare(strict_types=1);

namespace Adultdate\FilamentMessages\Livewire\Messages;

use Adultdate\FilamentMessages\Livewire\Traits\CanMarkAsRead;
use Adultdate\FilamentMessages\Livewire\Traits\CanValidateFiles;
use Adultdate\FilamentMessages\Livewire\Traits\HasPollInterval;
use Exception;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

final class Messages extends Component implements HasForms
{
    use CanMarkAsRead, CanValidateFiles, HasPollInterval, InteractsWithForms, WithPagination;

    public $selectedConversation;

    public $currentPage = 1;

    public Collection $conversationMessages;

    public ?array $data = [];

    public bool $showUpload = false;

    /**
     * Initialize the Messages component.
     *
     * This method is called when the component is mounted.
     * It sets the polling interval, fills the form state, and
     * if a conversation is selected, initializes the conversation
     * messages, loads existing messages, and marks them as read.
     */
    public function mount(): void
    {
        $this->setPollInterval();
        $this->form->fill(['message' => '']);
        if ($this->selectedConversation) {
            $this->conversationMessages = collect();
            $this->loadMessages();
            $this->markAsRead();
        }
    }

    /**
     * Poll for new messages in the selected conversation.
     *
     * This method retrieves messages that are newer than the
     * latest message currently loaded in the conversation.
     * If new messages are found, they are prepended to the
     * existing collection of conversation messages.
     */
    public function pollMessages(): void
    {
        $latestId = $this->conversationMessages->pluck('id')->first();
        $polledMessages = $this->selectedConversation->messages()->where('id', '>', $latestId)->latest()->get();
        if ($polledMessages->isNotEmpty()) {
            $this->conversationMessages = collect([
                ...$polledMessages,
                ...$this->conversationMessages,
            ]);
        }
    }

    /**
     * Load the next page of messages for the selected conversation.
     *
     * This method appends the messages from the next page to the
     * existing collection of conversation messages and increments
     * the current page number.
     */
    public function loadMessages(): void
    {
        $this->conversationMessages->push(...$this->paginator->getCollection());
        $this->currentPage = $this->currentPage + 1;
    }

    /**
     * Mount an action and dispatch it.
     *
     * @param  string  $name  The action name.
     */
    public function mountAction(string $name): void
    {
        $this->callAction($name);
    }

    /**
     * Call an action by name.
     *
     * @param  string  $name  The action name.
     */
    public function callAction(string $name): void
    {
        if ($name === 'show_hide_upload') {
            $this->showUpload = ! $this->showUpload;
        }
    }

    /**
     * Customize the form schema for the Messages component.
     *
     * This method defines the form schema used by the Messages component,
     * which includes support for file uploads and a message textarea.
     * The form state is stored in the 'data' property.
     *
     * - The 'attachments' field allows multiple file uploads and is
     *   conditionally visible based on the 'showUpload' property.
     * - The 'show_hide_upload' action toggles the visibility of the
     *   attachments upload field.
     * - The 'message' field is a textarea that supports live updates
     *   and automatically adjusts its height based on the content.
     *
     * @param  Schema  $schema  The form schema instance.
     * @return Schema The customized form instance.
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\FileUpload::make('attachments')
                    ->hiddenLabel()
                    ->directory('filament-messages')
                    ->multiple()
                    ->panelLayout('grid')
                    ->visible(fn () => $this->showUpload)
                    ->maxFiles(config('filament-messages.attachments.max_files'))
                    ->minFiles(config('filament-messages.attachments.min_files'))
                    ->maxSize(config('filament-messages.attachments.max_file_size'))
                    ->minSize(config('filament-messages.attachments.min_file_size'))
                    ->live()
                    ->columnSpan('full'),
                Actions::make([
                    Action::make('show_hide_upload')
                        ->hiddenLabel()
                        ->icon('heroicon-o-paper-clip')
                        ->color('gray')
                        ->tooltip(__('Attach Files'))
                        ->action(fn () => $this->showUpload = ! $this->showUpload),
                ])->grow(false),
                Forms\Components\Textarea::make('message')
                    ->live()
                    ->hiddenLabel()
                    ->rows(1)
                    ->autosize()
                    ->extraAttributes([
                        'style' => 'width: 100%;',
                    ]),
            ])
            ->statePath('data');
    }

    /**
     * Sends a message with attachments in the selected conversation.
     *
     * This method retrieves the form state, including message content and attachments,
     * and saves the message to the database within a transaction. The message is then
     * prepended to the conversation messages collection. Attachments are processed and
     * added to the media collection. The form is reset, the conversation's updated
     * timestamp is refreshed, and the inbox is refreshed. If an exception occurs, a
     * notification is sent to inform the user of the error.
     *
     * @throws Exception|Throwable
     */
    public function sendMessage(): void
    {
        $data = $this->form->getState();
        $rawData = $this->form->getRawState();

        try {
            DB::transaction(function () use ($data, $rawData) {
                $this->showUpload = false;

                $newMessage = $this->selectedConversation->messages()->create([
                    'message' => $data['message'] ?? null,
                    'user_id' => Auth::id(),
                    'read_by' => [Auth::id()],
                    'read_at' => [now()],
                    'notified' => [Auth::id()],
                ]);

                $this->conversationMessages->prepend($newMessage);

                // Process attachments if they exist (FileUpload stores paths as an array)
                if (! empty($rawData['attachments']) && is_array($rawData['attachments'])) {
                    collect($rawData['attachments'])->each(function ($attachment) use ($newMessage) {
                        if ($attachment) {
                            // Store the first attachment path (string) as attachment_id for display
                            if (empty($newMessage->attachment_id)) {
                                $newMessage->attachment_id = $attachment;
                                $newMessage->save();
                            }
                        }
                    });
                }

                $this->form->fill();

                $this->selectedConversation->updated_at = now();

                $this->selectedConversation->save();

                $this->dispatch('refresh-inbox');
                // Notify the frontend to scroll the chat container to the bottom
                $this->dispatch('chat-box-scroll-to-bottom');

                // Send Filament database notifications to other participants in the inbox
                $recipientIds = array_filter($this->selectedConversation->user_ids ?? [], fn ($id) => $id !== Auth::id());
                if (! empty($recipientIds)) {
                    $recipients = \App\Models\User::whereIn('id', $recipientIds)->get();
                    $preview = ! empty($data['message']) ? Str::limit($data['message'], 200) : __('Sent an attachment');

                    foreach ($recipients as $recipient) {
                        Notification::make()
                            ->title(__('New message from :name', ['name' => Auth::user()->name]))
                            ->body($preview)
                            ->sendToDatabase($recipient, true);
                    }
                }
            });
        } catch (Exception $exception) {
            Notification::make()
                ->title(__('Something went wrong'))
                ->body($exception->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    public function toggleUpload(): void
    {
        $this->showUpload = ! $this->showUpload;
    }

    /**
     * Computes the paginator for the conversation messages.
     *
     * This method retrieves the latest messages for the selected conversation
     * and paginates them by 10 messages per page. The pagination starts at
     * the current page index.
     *
     * @return Paginator The paginator instance
     *                   for the conversation messages.
     */
    #[Computed()]
    public function paginator(): Paginator
    {
        return $this->selectedConversation->messages()->latest()->paginate(10, ['*'], 'page', $this->currentPage);
    }

    /**
     * Download an attachment from the given file path and return it as a response.
     *
     * @param  string  $filePath  The file path of the attachment to download.
     * @param  string  $fileName  The file name to send with the attachment.
     * @return BinaryFileResponse The response containing the attachment.
     */
    public function downloadAttachment(string $filePath, string $fileName): BinaryFileResponse
    {
        $response = response()->download($filePath, $fileName);
        if (! $response instanceof BinaryFileResponse) {
            throw new RuntimeException('Failed to generate download response');
        }

        return $response;
    }

    /**
     * Determines if the message input is valid.
     */
    public function validateMessage(): bool
    {
        $rawData = $this->form->getRawState();

        // Return true if there's a message OR attachments
        return ! empty($rawData['message']) || ! empty($rawData['attachments']);
    }

    /**
     * Render the messages view for the Livewire component.
     *
     * This method returns the view responsible for displaying
     * the messages interface, which includes the chat box and
     * input area for sending messages.
     */
    public function render(): Application|Factory|View|\Illuminate\View\View
    {
        return view('filament-messages::livewire.messages.messages');
    }
}
