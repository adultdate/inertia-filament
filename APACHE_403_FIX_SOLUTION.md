# Fix for 403 on /admin

## Problem Found

Your Apache config has a `Directory` block at the top that denies access:
```apache
<Directory /var/www/admin.nordicdigitalthailand.com>
    AllowOverride None
    Require all denied
</Directory>
```

This is blocking access before the proxy rules can take effect.

## Solution

The proxy configuration is correct, but Apache processes Directory blocks before ProxyPass. You need to ensure the proxy rules are processed correctly.

### Option 1: Move Proxy Rules Before Directory Blocks (Recommended)

In your Apache config file (`/etc/apache2/sites-available/admin.nordicdigitalthailand.com.vhost`), move the proxy configuration to the BEGINNING of each VirtualHost block, right after the ServerName/ServerAlias lines.

For the HTTPS VirtualHost (*:443), it should look like:

```apache
<VirtualHost *:443>
    ServerName admin.nordicdigitalthailand.com
    ServerAlias www.admin.nordicdigitalthailand.com
    
    # PROXY CONFIGURATION FIRST - Before any Directory blocks
    ProxyPreserveHost On
    ProxyRequests Off
    
    RewriteEngine On
    RewriteCond %{HTTP:Upgrade} =websocket [NC]
    RewriteRule /(.*) ws://127.0.0.1:9000/$1 [P,L]
    
    ProxyPass / http://127.0.0.1:9000/
    ProxyPassReverse / http://127.0.0.1:9000/
    
    # Vite-specific paths
    <LocationMatch "^/(@vite|@react-refresh|@vite-client|resources)">
        ProxyPass http://127.0.0.1:4000
        ProxyPassReverse http://127.0.0.1:4000
    </LocationMatch>
    
    # ... rest of your config (SSL, Directory blocks, etc.)
</VirtualHost>
```

### Option 2: Add Exception for Proxy in Directory Block

Alternatively, you can add an exception to allow proxying:

```apache
<Directory /var/www/admin.nordicdigitalthailand.com>
    AllowOverride None
    Require all denied
    # Allow proxy to pass through
    ProxyPass !
</Directory>
```

But Option 1 is cleaner.

## Steps to Fix

1. **Edit the Apache config:**
   ```bash
   sudo nano /etc/apache2/sites-available/admin.nordicdigitalthailand.com.vhost
   ```

2. **Move the proxy configuration** (lines 279-293 for HTTPS, 120-136 for HTTP) to the BEGINNING of each VirtualHost block, right after ServerName/ServerAlias.

3. **Test the configuration:**
   ```bash
   sudo apache2ctl configtest
   ```

4. **If test passes, reload Apache:**
   ```bash
   sudo systemctl reload apache2
   ```

5. **Test accessing /admin:**
   ```bash
   curl -I https://admin.nordicdigitalthailand.com/admin
   ```

## Why This Happens

Apache processes configuration directives in order. Directory blocks with `Require all denied` are evaluated before ProxyPass rules. By moving ProxyPass to the beginning, Apache processes the proxy rules first and forwards the request to Laravel before checking directory permissions.

## Alternative: Remove the Deny Block

If the `/var/www/admin.nordicdigitalthailand.com` directory isn't needed, you could also remove or modify that deny block, but moving the proxy rules is safer and doesn't require changing ISPConfig's default structure.
