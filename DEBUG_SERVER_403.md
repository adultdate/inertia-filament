# Debugging 403 on Server (but works on localhost)

Since it works on localhost but not on server, the issue is likely:
1. Role not assigned on server database
2. Cache issue
3. Different database state

## Step 1: Check if role exists and is assigned

Run on server:
```bash
php artisan tinker
```

```php
// Check if role exists
use Spatie\Permission\Models\Role;
Role::all()->pluck('name');

// Check if user has the role
$user = App\Models\User::where('email', 'super_admin@ndsth.com')->first();
$user->roles->pluck('name');
$user->hasRole('super_admin');
exit
```

## Step 2: Assign role on server

If role doesn't exist or isn't assigned:
```php
use Spatie\Permission\Models\Role;

// Create role if it doesn't exist
$role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

// Assign to user
$user = App\Models\User::where('email', 'super_admin@ndsth.com')->first();
$user->assignRole('super_admin');

// Verify
$user->hasRole('super_admin'); // Should return true
exit
```

## Step 3: Clear all caches

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Step 4: Check Laravel logs

```bash
tail -f storage/logs/laravel.log
```

Then try accessing /admin and watch for errors.

## Step 5: Verify canAccessPanel is working

In tinker:
```php
$user = App\Models\User::where('email', 'super_admin@ndsth.com')->first();
$panel = Filament\Facades\Filament::getPanel('admin');
$user->canAccessPanel($panel);
exit
```

This should return `true` if everything is set up correctly.
