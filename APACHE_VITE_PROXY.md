# Apache Reverse Proxy Configuration for Vite Dev Server

To fix the mixed content errors, you need to configure Apache to proxy Vite requests through HTTPS.

## Apache Virtual Host Configuration

Add this to your Apache virtual host configuration file for `admin.nordicdigitalthailand.com`:

```apache
<VirtualHost *:443>
    ServerName admin.nordicdigitalthailand.com
    
    # ... your existing SSL and document root configuration ...
    
    # Proxy Vite dev server requests
    # This MUST come BEFORE your main RewriteRule for /
    ProxyPreserveHost On
    ProxyRequests Off
    
    # Enable WebSocket support
    RewriteEngine On
    RewriteCond %{HTTP:Upgrade} websocket [NC]
    RewriteCond %{HTTP:Connection} upgrade [NC]
    RewriteRule ^/(@vite|@react-refresh|@vite-client|resources)/?(.*) ws://127.0.0.1:4000/$1/$2 [P,L]
    
    # Proxy Vite client and HMR requests (HTTP)
    ProxyPass /@vite http://127.0.0.1:4000/@vite
    ProxyPassReverse /@vite http://127.0.0.1:4000/@vite
    
    ProxyPass /@react-refresh http://127.0.0.1:4000/@react-refresh
    ProxyPassReverse /@react-refresh http://127.0.0.1:4000/@react-refresh
    
    ProxyPass /@vite-client http://127.0.0.1:4000/@vite-client
    ProxyPassReverse /@vite-client http://127.0.0.1:4000/@vite-client
    
    # Proxy Vite resource requests
    <LocationMatch "^/resources/">
        ProxyPass http://127.0.0.1:4000
        ProxyPassReverse http://127.0.0.1:4000
    </LocationMatch>
    
    # Your existing Laravel configuration...
    DocumentRoot /home/ubuntu/web4/admin/public
    
    <Directory /home/ubuntu/web4/admin/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    # ... rest of your SSL configuration ...
</VirtualHost>
```

## Enable Required Apache Modules

```bash
sudo a2enmod proxy
sudo a2enmod proxy_http
sudo a2enmod proxy_wstunnel  # For WebSocket support
sudo a2enmod rewrite
sudo a2enmod headers
sudo systemctl restart apache2
```

## Steps to Apply

1. Edit your Apache virtual host:
   ```bash
   sudo nano /etc/apache2/sites-available/admin.nordicdigitalthailand.com.conf
   # or
   sudo nano /etc/httpd/conf.d/admin.nordicdigitalthailand.com.conf
   ```

2. Add the proxy configuration (before your DocumentRoot/Directory blocks)

3. Enable required modules:
   ```bash
   sudo a2enmod proxy proxy_http proxy_wstunnel rewrite headers
   ```

4. Test configuration:
   ```bash
   sudo apache2ctl configtest
   # or
   sudo httpd -t
   ```

5. Restart Apache:
   ```bash
   sudo systemctl restart apache2
   # or
   sudo systemctl restart httpd
   ```

6. Restart your Vite dev server (`composer dev`)

## How It Works

- Browser requests: `https://admin.nordicdigitalthailand.com/@vite/client`
- Apache proxies to: `http://127.0.0.1:4000/@vite/client`
- Browser sees HTTPS (no mixed content error)
- Vite dev server receives HTTP (works fine)

## Environment Variables

Make sure your `.env` file has:
```env
APP_URL=https://admin.nordicdigitalthailand.com
```

This ensures Laravel generates HTTPS URLs.
