#!/bin/sh
set -e

echo "==> [Entrypoint] Initializing Sankara Tech Production Container..."

cd /var/www/html

# Create storage directory structure if not present
mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs storage/app/public bootstrap/cache

# Fix permissions for www-data
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Create storage symlink
if [ ! -L public/storage ]; then
    echo "==> Creating storage symlink..."
    php artisan storage:link || true
fi

# Run database migrations if DB is accessible
if [ "${AUTO_MIGRATE:-true}" = "true" ]; then
    echo "==> Running database migrations..."
    php artisan migrate --force || echo "==> Migration warning: database may not be ready or SQLite is used."
fi

# Generate XML Sitemap on startup
if [ "${AUTO_GENERATE_SITEMAP:-true}" = "true" ]; then
    echo "==> Generating XML Sitemap..."
    php artisan sitemap:generate || echo "==> Sitemap generation skipped."
fi

# Production optimizations caching
if [ "${APP_ENV:-production}" = "production" ]; then
    echo "==> Caching configuration, routes, and views for high performance..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
    php artisan event:cache || true
fi

# Setup Laravel cron schedule in crontab
echo "* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1" > /etc/cron.d/laravel-schedule
chmod 0644 /etc/cron.d/laravel-schedule
crontab /etc/cron.d/laravel-schedule

echo "==> [Entrypoint] Starting Supervisord (Nginx + PHP-FPM + Worker)..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
