# Debugging 403 on /app

Laravel is working fine (returns 302 redirect), so the 403 is from Apache.

## Check for Physical Directory

```bash
# Check if there's a physical /app directory
ls -la /var/www/clients/client0/web4/web/app
ls -la /var/www/admin.nordicdigitalthailand.com/web/app
```

If these directories exist, Apache might be trying to serve them instead of proxying.

## Check Apache Error Log

```bash
# Watch error log while accessing /app
sudo tail -f /var/log/apache2/error.log

# Then access https://admin.nordicdigitalthailand.com/app in browser
```

## Verify Proxy Configuration

The proxy config should handle `/app` since it uses `ProxyPass /`. Check if the proxy is actually working:

```bash
# Test through Apache
curl -I https://admin.nordicdigitalthailand.com/app

# Compare with direct Laravel access
curl -I http://127.0.0.1:9000/app
```

## Possible Issues

1. **Physical `/app` directory exists** - Apache serves it instead of proxying
2. **Proxy config order** - Directory blocks processed before ProxyPass
3. **ISPConfig regenerated config** - Manual edits were lost

## Quick Fix

If there's a physical `/app` directory, either:
- Remove it: `rm -rf /var/www/clients/client0/web4/web/app`
- Or ensure proxy config comes before Directory blocks in Apache config
