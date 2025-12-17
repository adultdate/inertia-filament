#!/bin/bash
# Script to check Apache configuration for /admin blocking

echo "=== Checking Apache Config ==="
echo ""
echo "1. Full Apache config for the site:"
sudo cat /etc/apache2/sites-available/admin.nordicdigitalthailand.com.vhost

echo ""
echo "=== Checking for /admin blocks ==="
sudo grep -n -A 5 -B 5 "admin\|Admin\|ADMIN" /etc/apache2/sites-available/admin.nordicdigitalthailand.com.vhost

echo ""
echo "=== Checking Directory permissions ==="
sudo grep -n -A 10 "Directory" /etc/apache2/sites-available/admin.nordicdigitalthailand.com.vhost | head -50

echo ""
echo "=== Checking if site is enabled ==="
ls -la /etc/apache2/sites-enabled/ | grep admin

echo ""
echo "=== Checking Apache error log for recent /admin requests ==="
sudo tail -20 /var/log/apache2/error.log | grep -i admin
