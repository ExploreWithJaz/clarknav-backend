#!/bin/bash

cd /var/www/clarknav-api || exit  # Change this to your Laravel project path

echo "Pulling latest changes from GitHub..."
git pull origin main  # Change 'main' to your branch name if different

echo "Installing dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "Running migrations..."
php artisan migrate --force

echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize

echo "Restarting queue and services..."
php artisan queue:restart
sudo systemctl restart php8.3-fpm
sudo systemctl restart nginx  # If using Nginx

echo "Deployment complete!"
