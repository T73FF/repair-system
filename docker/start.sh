#!/bin/bash

# Фикс прав на storage и bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Ждём, пока база данных поднимется (опционально)
sleep 5

# Запускаем миграции
php artisan migrate --force

# Запускаем PHP-FPM в фоне
php-fpm -D

# Запускаем Nginx
nginx -g "daemon off;"