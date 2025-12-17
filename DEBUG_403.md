# Debugging 403 on /admin

Since Laravel works fine (`curl http://127.0.0.1:9000/admin` returns 302), the 403 is from Apache.

## Check mod_security

```bash
# Check if mod_security is blocking
sudo tail -f /var/log/apache2/modsec_audit.log

# Then try accessing /admin in browser and watch the log
```

## Check Apache Configuration

```bash
# Check for any blocks on /admin
sudo grep -r "admin" /etc/apache2/sites-available/
sudo grep -r "admin" /etc/apache2/conf-available/
sudo grep -r "admin" /etc/apache2/conf-enabled/

# Check for Directory or Location blocks
sudo grep -A 10 -B 5 "Location\|Directory" /etc/apache2/sites-available/*.conf | grep -i admin
```

## Check Apache Error Log When Accessing

```bash
# In one terminal, watch error log
sudo tail -f /var/log/apache2/error.log

# In another terminal or browser, access:
# https://admin.nordicdigitalthailand.com/admin
```

## Common Issues

1. **mod_security blocking `/admin`** - Check modsec_audit.log
2. **Apache Directory block** - Check for `<Directory "/admin">` or similar
3. **Vite proxy rules** - Check if proxy rules are too broad
4. **.htaccess in public/admin** - Check if there's a public/admin directory with .htaccess

## Quick Test

```bash
# Check if there's a public/admin directory
ls -la /home/ubuntu/web4/admin/public/admin

# Check Apache config for the site
sudo cat /etc/apache2/sites-available/admin.nordicdigitalthailand.com.conf | grep -A 20 -B 5 admin
```
