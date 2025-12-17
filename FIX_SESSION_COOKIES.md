# Fix Session/Cookie Configuration for HTTPS Behind Reverse Proxy

## Problem

When behind an Apache reverse proxy, Laravel needs to:
1. Trust the proxy to detect HTTPS correctly
2. Set secure cookies for HTTPS
3. Configure session domain correctly

## Solution

### 1. TrustProxies Middleware

Already added to `bootstrap/app.php` - this allows Laravel to trust the proxy headers.

### 2. Environment Variables (.env)

Add these to your `.env` file on the server:

```env
# Session Configuration for HTTPS
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

# Optional: Set session domain if needed
# SESSION_DOMAIN=.nordicdigitalthailand.com

# Make sure APP_URL is HTTPS
APP_URL=https://admin.nordicdigitalthailand.com
```

### 3. Apache Configuration

Make sure Apache is sending the correct headers. In your Apache virtual host, ensure you have:

```apache
ProxyPreserveHost On
RequestHeader set X-Forwarded-Proto "https"
RequestHeader set X-Forwarded-Port "443"
```

### 4. Clear Config Cache

After updating `.env`:

```bash
php artisan config:clear
php artisan cache:clear
```

## Verify

After making these changes:
1. Log out completely
2. Clear browser cookies
3. Log back in
4. Check browser DevTools → Application → Cookies
   - Session cookie should have `Secure` flag
   - `SameSite` should be `Lax`

## Debug

If still not working, check in tinker:

```php
php artisan tinker

// Check if request is detected as secure
$request = request();
echo "Is secure: " . ($request->secure() ? 'YES' : 'NO') . "\n";
echo "Scheme: " . $request->getScheme() . "\n";
echo "X-Forwarded-Proto: " . $request->header('X-Forwarded-Proto') . "\n";

// Check session config
echo "Session secure: " . (config('session.secure') ? 'YES' : 'NO') . "\n";
echo "Session domain: " . config('session.domain') . "\n";
exit
```
