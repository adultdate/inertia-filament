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

# In development mode, remove manifest.json so Laravel uses dev server
# This ensures Laravel detects the Vite dev server instead of using production build
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"

if [ -f "$PROJECT_ROOT/public/build/manifest.json" ]; then
    # Remove manifest in dev mode so Laravel uses Vite dev server
    # You can always rebuild with 'npm run build' for production
    rm -f "$PROJECT_ROOT/public/build/manifest.json" 2>/dev/null || true
fi

# Exit successfully even if some commands fail
exit 0
