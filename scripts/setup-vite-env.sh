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

# Ensure build directory exists
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"
mkdir -p "$PROJECT_ROOT/public/build" 2>/dev/null || true

# Create a minimal manifest file as fallback
# Laravel will try to detect Vite dev server first, but needs this as fallback
# This prevents "manifest not found" errors while still allowing dev server detection
cat > "$PROJECT_ROOT/public/build/manifest.json" << 'EOF'
{
  "resources/js/app.tsx": {
    "file": "http://localhost:4000/resources/js/app.tsx",
    "src": "resources/js/app.tsx",
    "isEntry": true
  },
  "resources/css/app.css": {
    "file": "http://localhost:4000/resources/css/app.css",
    "src": "resources/css/app.css"
  }
}
EOF

# Exit successfully even if some commands fail
exit 0
