#!/bin/bash
# Verify /app access and check for physical directory

echo "=== Checking for physical /app directory ==="
sudo ls -la /var/www/clients/client0/web4/web/app 2>&1
sudo ls -la /var/www/admin.nordicdigitalthailand.com/web/app 2>&1

echo ""
echo "=== Testing /app access through Apache ==="
curl -I https://admin.nordicdigitalthailand.com/app 2>&1 | head -10

echo ""
echo "=== Testing /app access directly to Laravel ==="
curl -I http://127.0.0.1:9000/app 2>&1 | head -10

echo ""
echo "=== Checking Apache error log for /app ==="
sudo tail -30 /var/log/apache2/error.log | grep -i "app\|403" | tail -10
