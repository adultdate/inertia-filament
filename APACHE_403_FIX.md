# Fixing 403 Forbidden Error on /admin Path

If you're getting a 403 Forbidden error when accessing `https://admin.nordicdigitalthailand.com/admin`, it's likely an Apache configuration issue.

## Common Causes

1. **Apache Proxy Rules Interfering**: The Vite proxy rules might be catching `/admin` requests
2. **Directory Blocking**: Apache might have a Directory or Location block blocking `/admin`
3. **mod_security**: Security module might be blocking the path
4. **File Permissions**: Directory permissions might be incorrect

## Solution 1: Fix Apache Proxy Configuration

Make sure your Apache Vite proxy rules **exclude** the `/admin` path. Update your Apache virtual host:

```apache
<VirtualHost *:443>
    ServerName admin.nordicdigitalthailand.com
    
    # ... your existing SSL configuration ...
    
    # Proxy Vite dev server requests
    # IMPORTANT: Exclude /admin and other Laravel paths
    ProxyPreserveHost On
    ProxyRequests Off
    
    # Enable WebSocket support for Vite (but exclude /admin)
    RewriteEngine On
    RewriteCond %{HTTP:Upgrade} websocket [NC]
    RewriteCond %{HTTP:Connection} upgrade [NC]
    RewriteCond %{REQUEST_URI} !^/admin [NC]
    RewriteCond %{REQUEST_URI} !^/app [NC]
    RewriteRule ^/(@vite|@react-refresh|@vite-client|resources)/?(.*) ws://127.0.0.1:4000/$1/$2 [P,L]
    
    # Proxy Vite endpoints (exclude /admin and /app)
    <LocationMatch "^/(@vite|@react-refresh|@vite-client|resources)">
        ProxyPass http://127.0.0.1:4000
        ProxyPassReverse http://127.0.0.1:4000
    </LocationMatch>
    
    # Your existing Laravel configuration...
    DocumentRoot /home/ubuntu/web4/admin/public
    
    <Directory /home/ubuntu/web4/admin/public>
        AllowOverride All
        Require all granted
        Options -Indexes +FollowSymLinks
    </Directory>
    
    # ... rest of your SSL configuration ...
</VirtualHost>
```

## Solution 2: Check for Directory Blocks

Check if there's a `<Directory>` or `<Location>` block blocking `/admin`:

```bash
sudo grep -r "admin" /etc/apache2/sites-available/
sudo grep -r "admin" /etc/apache2/conf-available/
```

## Solution 3: Check mod_security

If mod_security is enabled, it might be blocking `/admin`:

```bash
# Check if mod_security is enabled
sudo apache2ctl -M | grep security

# If enabled, check logs
sudo tail -f /var/log/apache2/modsec_audit.log
sudo tail -f /var/log/apache2/error.log
```

To temporarily disable mod_security for testing:

```apache
<IfModule mod_security2.c>
    SecRuleEngine Off
</IfModule>
```

## Solution 4: Check File Permissions

Ensure the directory has correct permissions:

```bash
sudo chown -R www-data:www-data /home/ubuntu/web4/admin/public
sudo chmod -R 755 /home/ubuntu/web4/admin/public
```

## Solution 5: Test Direct Access

Test if Laravel is receiving the request:

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Test from command line
curl -I https://admin.nordicdigitalthailand.com/admin
```

## Quick Debug Steps

1. **Check Apache error logs**:
   ```bash
   sudo tail -f /var/log/apache2/error.log
   ```

2. **Check Apache access logs**:
   ```bash
   sudo tail -f /var/log/apache2/access.log
   ```

3. **Test Apache configuration**:
   ```bash
   sudo apache2ctl configtest
   ```

4. **Check if it's a Laravel issue** (access via IP/port directly):
   ```bash
   curl http://127.0.0.1:9000/admin
   ```

## Most Likely Fix

The most common issue is that the Vite proxy rules are catching `/admin` requests. Make sure your proxy rules are **specific** and don't match `/admin`:

```apache
# BAD - This would catch /admin
ProxyPass / http://127.0.0.1:4000

# GOOD - Only proxy specific Vite paths
<LocationMatch "^/(@vite|@react-refresh|@vite-client|resources)">
    ProxyPass http://127.0.0.1:4000
    ProxyPassReverse http://127.0.0.1:4000
</LocationMatch>
```

After making changes, restart Apache:
```bash
sudo systemctl restart apache2
```
