#!/usr/bin/env bash
set -e

echo "🚀 [Deploy] Starting Production Deployment for Sankara Tech..."

# Enter maintenance mode
php artisan down || true

# Pull latest commits
git pull origin main

# Install PHP dependencies
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

# Compile frontend assets
npm install --no-audit
npm run build

# Run database migrations
php artisan migrate --force

# Clear and rebuild application caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Ensure storage link
php artisan storage:link || true

# Generate latest XML Sitemap
php artisan sitemap:generate

# Restart background queue workers
php artisan queue:restart || true

# Exit maintenance mode
php artisan up

# Reload PHP-FPM
sudo systemctl reload php8.4-fpm || sudo systemctl reload php8.3-fpm || sudo systemctl reload php-fpm || true

echo "✅ [Deploy] Deployment finished successfully! Website is LIVE."
