#!/bin/sh

# Start PHP-FPM in the background
php-fpm -D

# Run migrations (only in production or as needed)
# php artisan migrate --force

# Start Nginx in the foreground
nginx -g "daemon off;"
