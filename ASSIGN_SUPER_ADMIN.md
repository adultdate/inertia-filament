# Assign Super Admin Role to User

The admin panel requires the `super_admin` role. To assign it to your user, run:

## Option 1: Using Tinker (Recommended)

```bash
php artisan tinker
```

Then run:
```php
$user = App\Models\User::where('email', 'your-email@example.com')->first();
$user->assignRole('super_admin');
exit
```

## Option 2: Using Artisan Command

If Filament Shield provides a command:
```bash
php artisan shield:super-admin --user=your-email@example.com
```

## Option 3: Direct Database (if needed)

```bash
php artisan tinker
```

```php
use Spatie\Permission\Models\Role;
use App\Models\User;

$role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
$user = User::where('email', 'your-email@example.com')->first();
$user->assignRole($role);
exit
```

## Verify

After assigning the role, test access:
```bash
curl -I https://admin.nordicdigitalthailand.com/admin
```

You should now be able to access the admin panel after login.
