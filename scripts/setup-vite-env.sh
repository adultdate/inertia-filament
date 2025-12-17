#!/bin/bash
# Workaround for Laravel Vite plugin Herd/Valet detection on Linux
# Creates directories and valid JSON config files to satisfy the plugin's checks

# Create Herd config directory with valid JSON
mkdir -p ~/.config/herd 2>/dev/null || true
echo '{}' > ~/.config/herd/config.json 2>/dev/null || true

# Create Valet config directory and certificates with valid JSON
mkdir -p ~/.config/valet 2>/dev/null || true
echo '{"tld":"test"}' > ~/.config/valet/config.json 2>/dev/null || true
mkdir -p ~/.config/valet/Certificates 2>/dev/null || true

# Also try common Valet locations with valid JSON
mkdir -p ~/.valet 2>/dev/null || true
echo '{"tld":"test"}' > ~/.valet/config.json 2>/dev/null || true
mkdir -p ~/.valet/Certificates 2>/dev/null || true

# Exit successfully even if some commands fail
exit 0
