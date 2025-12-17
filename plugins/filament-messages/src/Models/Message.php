<?php

declare(strict_types=1);

namespace Adultdate\FilamentMessages\Models;

// use Adultdate\FilamentMessages\Enums\MediaCollectionType;
// use Adultdate\FilamentMessages\Models\Traits\HasMediaConvertionRegistrations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

// use Spatie\MediaLibrary\HasMedia;
// use Spatie\MediaLibrary\InteractsWithMedia;
// use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class Message extends Model
{
    use SoftDeletes;

    /**
     * Register media collections for the Message model.
     *
     * This method adds a media collection for 'FILAMENT_MESSAGES' and registers
     * media conversions using the defined conversion registrations.
     *
     * @return void
     */
    /**
     * The path of the attachment file stored via FileUpload.
     * This is a file path string, not an ID.
     */
    public ?string $attachment_id = null;

    protected $table = 'fm_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'inbox_id',
        'message',
        'user_id',
        'read_by',
        'read_at',
        'notified',
        'attachment_id',
    ];

    /**
     * Get the attachment file path.
     * Returns null if no attachment exists.
     */
    public function getAttachmentPathAttribute(): ?string
    {
        return $this->attachment_id;
    }

    /**
     * Get the user that sent the message.
     *
     * This relationship links the message to the user who sent it.
     *
     * @return BelongsTo<User>
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Get the inbox that this message belongs to.
     *
     * This relationship links the message to its parent inbox.
     *
     * @return BelongsTo<Inbox>
     */
    public function inbox(): BelongsTo
    {
        return $this->belongsTo(Inbox::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'read_by' => 'array',
            'read_at' => 'array',
            'notified' => 'array',
        ];
    }
}
