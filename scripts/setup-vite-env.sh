#!/bin/bash
# Workaround for Laravel Vite plugin Herd/Valet detection on Linux
# Creates empty directories and config files to satisfy the plugin's checks

# Create Herd config directory
mkdir -p ~/.config/herd 2>/dev/null || true
touch ~/.config/herd/config.json 2>/dev/null || true

# Create Valet config directory  
mkdir -p ~/.config/valet 2>/dev/null || true
touch ~/.config/valet/config.json 2>/dev/null || true

# Also try common Valet locations
mkdir -p ~/.valet 2>/dev/null || true
touch ~/.valet/config.json 2>/dev/null || true

# Exit successfully even if some commands fail
exit 0
