#!/bin/bash

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations (allow failure without stopping container)
php artisan migrate --force --no-interaction || echo "Migration failed or nothing to migrate"

# Cache configuration for production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start Apache
exec "$@"
