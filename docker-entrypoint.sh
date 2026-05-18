#!/bin/bash

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations and seed admin user
php artisan migrate --force --no-interaction || echo "Migration warning: check logs"
php artisan db:seed --class=AdminUserSeeder --force || echo "Seeder warning: check logs"

# Cache configuration for production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g "daemon off;"
