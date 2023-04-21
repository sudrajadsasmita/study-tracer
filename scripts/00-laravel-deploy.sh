# !/usr/bin/env bash
echo "Run Access"
chmod -R 777 storage/

echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running storage link"
php artisan storage:link
