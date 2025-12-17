#!/bin/bash
# Check for /app blocking issues

echo "=== Checking if /app directory exists ==="
ls -la /var/www/admin.nordicdigitalthailand.com/web/app 2>/dev/null || echo "Directory doesn't exist"
ls -la /var/www/clients/client0/web4/web/app 2>/dev/null || echo "Directory doesn't exist"

echo ""
echo "=== Checking Apache config for /app blocks ==="
sudo grep -n -i "app\|/app" /etc/apache2/sites-available/admin.nordicdigitalthailand.com.vhost | head -20

echo ""
echo "=== Testing direct access ==="
echo "Note: Make sure Laravel dev server is running (composer dev)"
curl -I http://127.0.0.1:9000/app 2>&1 | head -5
