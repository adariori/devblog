#!/bin/sh
set -e

# Render fournit $PORT (souvent 10000) → on l'injecte dans nginx
sed -i "s/listen 10000;/listen ${PORT:-10000};/" /etc/nginx/nginx.conf

php artisan migrate --force
php artisan storage:link || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
