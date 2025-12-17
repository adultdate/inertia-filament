<?php

declare(strict_types=1);

namespace Adultdate\FilamentMessages\Models\Traits;

use Adultdate\FilamentMessages\Models\Inbox;
use Illuminate\Database\Eloquent\Builder;

trait HasFilamentMessages
{
    /**
     * Retrieves all conversations for the current user.
     */
    public function allConversations(): Builder
    {
        return Inbox::whereJsonContains('user_ids', $this->id)->orderBy('updated_at', 'desc');
    }
}
