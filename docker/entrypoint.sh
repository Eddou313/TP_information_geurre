#!/usr/bin/env sh
set -eu

UPLOADS_DIR="/var/www/html/uploads"
CONTENT_DIR="/var/www/html/uploads/content"

mkdir -p "$CONTENT_DIR"

# Ensure Apache (www-data) can write uploaded files
chown -R www-data:www-data "$UPLOADS_DIR"
chmod -R 775 "$UPLOADS_DIR"

exec "$@"
