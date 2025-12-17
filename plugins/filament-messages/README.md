# Filament Messages

**Filament Messages** is a powerful messaging plugin for [FilamentPHP](https://filamentphp.com/). It provides an easy-to-use interface for real-time messaging within Filament admin panels.

![screen-1](resources/images/screen-1.png)
<p align="center">
  <img src="resources/images/screen-2.png" width="49.7%" />
  <img src="resources/images/screen-3.png" width="49.7%" />
</p>

![GitHub stars](https://img.shields.io/github/stars/jeddsaliba/filament-messages?style=flat-square)
![GitHub issues](https://img.shields.io/github/issues/jeddsaliba/filament-messages?style=flat-square)
![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)
![PHP Version](https://img.shields.io/badge/PHP-8.2-blue?style=flat-square&logo=php)
![Laravel Version](https://img.shields.io/badge/Laravel-11.0-red?style=flat-square&logo=laravel)
![Filament Version](https://img.shields.io/badge/Filament-3.2-purple?style=flat-square)

**Key Features:**
- **Seamless Integration:** Designed specifically for FilamentPHP, making it easy to integrate into your admin panel.
- **User-to-User & Group Chats:** Enables both private conversations and group discussions.
- **Unread Message Badges:** Displays unread message counts in the sidebar for better visibility.
- **File Attachments:** Allows sending images, documents, and other media.
- **Database-Driven:** Uses Eloquent models for structured and scalable messaging.
- **Configurable Refresh Interval:** Lets you set the chat update frequency for optimized performance.
- **Timezone Support:** Allows setting a preferred timezone to maintain consistent timestamps across messages.

## Quick Start

```bash
# 1. Install dependencies
composer require adultdate/filament-messages
composer require filament/spatie-laravel-media-library-plugin:"^3.2" -W

# 2. Run installation command (publishes config, migrations, and migrates)
php artisan filament-messages:install

# 3. Add trait to User model
# Add: use Adultdate\FilamentMessages\Models\Traits\HasFilamentMessages;

# 4. Register plugin in AdminPanelProvider
# Add: FilamentMessagesPlugin::make()
```

## Table of Contents
- [Quick Start](#quick-start)
- [Getting Started](#getting-started)
- [Prerequisite](#prerequisite)
- [User Model](#user-model)
- [Admin Panel Provider](#admin-panel-provider)
- [Configuration](#configuration)
- [Theming & Customization](#theming--customization)
- [Features](#features)
- [API Usage](#api-usage)
- [Troubleshooting](#troubleshooting)
- [Plugins Used](#plugins-used)
- [Acknowledgments](#acknowledgments)
- [Support](#support)

<a name="getting-started"></a>
## Getting Started

### Installation

1. **Install the package via Composer:**

```bash
composer require adultdate/filament-messages
```

2. **The service provider will be automatically registered** via Laravel's package auto-discovery feature.

3. **Publish the configuration file** (optional):

```bash
php artisan vendor:publish --tag="filament-messages-config"
```

4. **Publish and run the migrations:**

```bash
php artisan vendor:publish --tag="filament-messages-migrations"
php artisan migrate
```

Or use the install command to do both steps automatically:

```bash
php artisan filament-messages:install
```

5. **Publish the views** (optional, for customization):

```bash
php artisan vendor:publish --tag="filament-messages-views"
```

6. **Add plugin assets to your Filament theme CSS** (Required for styling):

If you're using a custom Filament theme, add these lines to your theme CSS file (e.g., `resources/css/filament/admin/theme.css`):

```css
/* For local plugin development (path repository) */
@import '../../../../plugins/filament-messages/resources/css/filament-messages.css';
@source '../../../../plugins/filament-messages/resources/views/**/*.blade.php';

/* For installed package (after publishing) */
@import '../../../../vendor/adultdate/filament-messages/resources/css/filament-messages.css';
@source '../../../../vendor/adultdate/filament-messages/resources/views/**/*.blade.php';
```

**Note:** Use the path that matches your installation method (local plugin or Composer package).

After adding these imports, rebuild your theme:

```bash
npm run build
# or
pnpm build
```

<a name="prerequisite"></a>
## Prerequisite

### Spatie Media Library
This plugin requires Filament Spatie Media Library for file attachments. Install it first:

```bash
composer require filament/spatie-laravel-media-library-plugin:"^3.2" -W
```

Publish and run the media library migrations:

```bash
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
php artisan migrate
```

For more details, see the [official documentation](https://github.com/filamentphp/spatie-laravel-media-library-plugin).

### Service Provider (Auto-registered)
The `FilamentMessagesServiceProvider` is **automatically registered** via Laravel's package auto-discovery. You don't need to manually add it to `config/app.php` or `bootstrap/providers.php`.

If auto-discovery is disabled in your project, manually add the provider:

```php
// config/app.php or bootstrap/providers.php
'providers' => [
    // ...
    Adultdate\FilamentMessages\FilamentMessagesServiceProvider::class,
],
```

<a name="user-model"></a>
## User Model
Add the trait to your User model:

```bash
<?php

use Adultdate\FilamentMessages\Models\Traits\HasFilamentMessages;

class User extends Authenticatable
{
    use HasFilamentMessages;
}

?>
```

<a name="admin-panel-provider"></a>
## Admin Panel Provider
Add this plugin to your FilamentPHP panel provider:

```bash
<?php

use Adultdate\FilamentMessages\FilamentMessagesPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugins([
                FilamentMessagesPlugin::make()
            ]);
    }
}
?>
```

## Configuration

After publishing the config file, you can customize settings in `config/filament-messages.php`:

```php
return [
    // Poll interval for checking new messages (in milliseconds)
    'poll_interval' => 5000,
    
    // Timezone for message timestamps
    'timezone' => config('app.timezone'),
    
    // Attachment settings
    'attachments' => [
        'max_file_size' => 5120,  // 5MB in KB
        'min_file_size' => 1,
        'max_files' => 5,
        'min_files' => 0,
    ],
    
    // Route slug for messages page
    'slug' => 'messages',
];
```

## Theming & Customization

### Custom Theme Integration

If you're using a custom Filament theme (recommended), you **must** include the plugin's assets in your theme file:

1. **Locate your theme CSS file:**
   - Usually at `resources/css/filament/admin/theme.css`
   - Or wherever your panel's theme is defined

2. **Add the following imports:**

```css
/* Import plugin CSS */
@import '../../../../vendor/adultdate/filament-messages/resources/css/filament-messages.css';

/* Include plugin Blade views for Tailwind purging */
@source '../../../../vendor/adultdate/filament-messages/resources/views/**/*.blade.php';
```

**For local development** (path repository):
```css
@import '../../../../plugins/filament-messages/resources/css/filament-messages.css';
@source '../../../../plugins/filament-messages/resources/views/**/*.blade.php';
```

3. **Rebuild your theme:**

```bash
npm run build
# or for pnpm
pnpm build
```

### Customizing Views

1. **Publish the views:**

```bash
php artisan vendor:publish --tag="filament-messages-views"
```

2. **Edit the published views** in `resources/views/vendor/filament-messages/`

3. **Available views to customize:**
   - `livewire/messages/inbox.blade.php` - Conversation list
   - `livewire/messages/messages.blade.php` - Chat interface
   - `livewire/messages/search.blade.php` - Search functionality
   - `filament/pages/messages.blade.php` - Main messages page

### Styling Tips

- All components use Tailwind CSS classes
- Dark mode is supported via `dark:` classes
- Message bubbles use blue for sent messages, gray for received
- Use Flux UI components where available for consistency

## Features

### Real-time Messaging
- Live message updates with configurable polling interval
- Message read receipts and status tracking
- Typing indicators (planned)
- Online/offline status (planned)

### File Attachments
- Upload multiple files per message
- Support for images, documents, and media
- File size and type validation
- Download attachments with original filenames

### User Experience
- Unread message badges
- Search conversations
- Create new conversations
- Group chat support
- Message timestamps with timezone support
- Dark mode compatible
- Mobile responsive design

### Security
- User authentication required
- Message ownership validation
- File upload restrictions
- CSRF protection

## API Usage

### Programmatic Conversation Creation

```php
use Adultdate\FilamentMessages\Models\Inbox;
use App\Models\User;

// Create a new conversation
$conversation = Inbox::create([
    'inbox_title' => 'Project Discussion',
]);

// Add participants
$user1 = User::find(1);
$user2 = User::find(2);

$conversation->users()->attach([$user1->id, $user2->id]);
```

### Sending Messages Programmatically

```php
use Adultdate\FilamentMessages\Models\Message;

$message = Message::create([
    'inbox_id' => $conversation->id,
    'user_id' => auth()->id(),
    'message' => 'Hello, this is a test message',
]);

// Add attachments
if ($file) {
    $message->addMedia($file)->toMediaCollection('filament-messages');
}
```

### Query Unread Messages

```php
// Get unread messages for current user
$unreadMessages = auth()->user()->messages()
    ->whereJsonDoesntContain('read_by', auth()->id())
    ->get();

// Get unread count
$unreadCount = auth()->user()->messages()
    ->whereJsonDoesntContain('read_by', auth()->id())
    ->count();
```

### Mark Messages as Read

```php
$message = Message::find($messageId);

// Add current user to read_by array
$readBy = $message->read_by ?? [];
if (!in_array(auth()->id(), $readBy)) {
    $readBy[] = auth()->id();
    $message->update([
        'read_by' => $readBy,
        'read_at' => array_merge($message->read_at ?? [], [now()]),
    ]);
}
```

### Listening for Events

```php
// In your EventServiceProvider or listener

use Adultdate\FilamentMessages\Events\MessageCreated;

Event::listen(MessageCreated::class, function ($event) {
    $message = $event->message;
    // Send notifications, update counters, etc.
});
```

## Troubleshooting

### Migrations not running automatically?
If migrations don't run automatically, publish and run them manually:

```bash
php artisan vendor:publish --tag="filament-messages-migrations"
php artisan migrate
```

### Views not loading?
Clear your view cache:

```bash
php artisan view:clear
php artisan optimize:clear
```

### Service provider not registered?
Ensure your `composer.json` has auto-discovery enabled. If not, manually register the provider in `bootstrap/providers.php`:

```php
return [
    App\Providers\AppServiceProvider::class,
    Adultdate\FilamentMessages\FilamentMessagesServiceProvider::class,
];
```

### Attachments not working?
Make sure you've installed and configured Spatie Media Library:

```bash
composer require filament/spatie-laravel-media-library-plugin:"^3.2" -W
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
php artisan migrate
```

Also ensure the `Message` model has the `InteractsWithMedia` trait:

```php
use Spatie\MediaLibrary\InteractsWithMedia;

class Message extends Model implements HasMedia
{
    use InteractsWithMedia;
}
```

### Styling not applied?
Make sure you've:
1. Added the CSS imports to your theme file
2. Run `npm run build` or `pnpm build` after adding imports
3. Cleared browser cache

```bash
php artisan optimize:clear
npm run build
```

### Messages not updating in real-time?
Check your polling interval in `config/filament-messages.php`:

```php
'poll_interval' => 5000, // 5 seconds in milliseconds
```

Lower values = more frequent updates but higher server load.

## Performance Tips

### Optimize Polling
Adjust the poll interval based on your needs:
- High traffic: `10000` (10 seconds)
- Medium traffic: `5000` (5 seconds, default)
- Low traffic: `3000` (3 seconds)

### Database Indexing
Add indexes to improve query performance:

```php
// In a migration
Schema::table('fm_messages', function (Blueprint $table) {
    $table->index('inbox_id');
    $table->index('user_id');
    $table->index('created_at');
});

Schema::table('fm_inboxes', function (Blueprint $table) {
    $table->index('updated_at');
});
```

### Enable Query Caching
Consider caching conversation lists for better performance:

```php
use Illuminate\Support\Facades\Cache;

$conversations = Cache::remember(
    "user.{$userId}.conversations",
    now()->addMinutes(5),
    fn() => $user->conversations()->latest()->get()
);
```

### Queue File Processing
For large file uploads, process them in background jobs:

```php
// In your message creation logic
dispatch(new ProcessMessageAttachment($message, $file));
```

## Best Practices

1. **Keep messages paginated** - The plugin loads 10 messages at a time by default
2. **Use appropriate file size limits** - Configure in `config/filament-messages.php`
3. **Monitor database size** - Consider archiving old conversations
4. **Use CDN for media** - Configure Spatie Media Library to use S3 or similar
5. **Implement proper authorization** - Use Laravel policies to control access
6. **Test with multiple users** - Ensure real-time updates work correctly
7. **Enable database transactions** - Messages are already wrapped in transactions

<a name="plugins-used"></a>
## Plugins Used
These are [Filament Plugins](https://filamentphp.com/plugins) use for this project.

| **Plugin**                                                                                          | **Author**                                              |
| :-------------------------------------------------------------------------------------------------- | :------------------------------------------------------ |
| [Filament Spatie Media Library](https://github.com/filamentphp/spatie-laravel-media-library-plugin) | [Filament Official](https://github.com/filamentphp)     |

<a name="acknowledgments"></a>
## Acknowledgments
- [FilamentPHP](https://filamentphp.com)
- [Laravel](https://laravel.com)
- [FilaChat](https://github.com/199ocero/filachat)

<a name="support"></a>
## Support
- [Report a bug](https://github.com/jeddsaliba/filament-messages/issues)
- [Request a feature](https://github.com/jeddsaliba/filament-messages/issues)
- [Email support](mailto:jeddsaliba@gmail.com)

## Show Your Support

Give a ⭐️ if this project helped you!
# filament-messages
# filament-messages
